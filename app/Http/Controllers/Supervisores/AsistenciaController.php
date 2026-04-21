<?php

namespace App\Http\Controllers\Supervisores;

use App\Http\Controllers\Controller;

use App\Models\Asistencia;
use App\Models\Operador;
use App\Models\Administrador;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AsistenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $asistencias = Asistencia::with('operador')->orderBy('created_at', 'desc')->get();
        $operadores = Operador::all();
        
        return view('supervisores.asistencias.index', compact('asistencias', 'operadores'));
    }

    /**
     * Store a newly created resource in storage.
     * Desde formulario web (admin)
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_operador' => 'required|string|max:32',
            'lat' => 'required|string|max:20',
            'lon' => 'required|string|max:20',
        ]);

        $asistencia = Asistencia::create([
            'id' => Str::random(32),
            'id_administrador' => auth()->user()->id ?? 'admin_sistema',
            'id_operador' => $request->id_operador,
            'lat' => $request->lat,
            'lon' => $request->lon,
        ]);

        return redirect()->route('asistencias.index')->with('success', 'Asistencia registrada correctamente');
    }

    /**
     * Registrar asistencia mediante escaneo QR (desde app móvil)
     */
    public function registrarPorQR(Request $request)
    {
        $request->validate([
            'qr_token' => 'required|string',
            'lat' => 'required|numeric',
            'lon' => 'required|numeric',
            'id_operador' => 'required|string|max:32',
            'foto_url' => 'nullable|string',
        ]);

        // Validar que el QR no haya sido usado hoy
        $yaRegistrado = Asistencia::where('qr_token', $request->qr_token)
            ->whereDate('created_at', Carbon::today())
            ->exists();

        if ($yaRegistrado) {
            return response()->json([
                'success' => false,
                'message' => 'Este QR ya fue escaneado hoy'
            ], 422);
        }

        // Validar geocerca (puedes definir coordenadas permitidas)
        $dentroGeocerca = $this->validarGeocerca($request->lat, $request->lon);

        // Crear registro
        $asistencia = Asistencia::create([
            'id' => Str::random(32),
            'id_administrador' => $request->id_administrador ?? 'app_movil',
            'id_operador' => $request->id_operador,
            'lat' => $request->lat,
            'lon' => $request->lon,
            'qr_token' => $request->qr_token,
            'foto_url' => $request->foto_url,
            'dentro_geocerca' => $dentroGeocerca,
            'tipo' => $request->tipo ?? 'entrada',
            'fecha_asistencia' => Carbon::today(),
            'dispositivo_id' => $request->dispositivo_id,
            'estado' => $dentroGeocerca ? 'valido' : 'anomalia',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Asistencia registrada correctamente',
            'data' => $asistencia
        ]);
    }

    /**
     * Validar si el operador está dentro de la geocerca permitida
     */
    private function validarGeocerca($lat, $lon)
    {
        // Define las coordenadas permitidas (ejemplo: bodega)
        $geocercas = [
            ['lat' => 19.4326, 'lon' => -99.1332, 'radio' => 500], // Bodega Centro
            ['lat' => 19.4285, 'lon' => -99.1277, 'radio' => 300], // Oficinas
        ];

        foreach ($geocercas as $geocerca) {
            $distancia = $this->calcularDistancia($lat, $lon, $geocerca['lat'], $geocerca['lon']);
            if ($distancia <= $geocerca['radio']) {
                return true;
            }
        }

        return false;
    }

    /**
     * Calcular distancia entre dos puntos (Haversine formula)
     */
    private function calcularDistancia($lat1, $lon1, $lat2, $lon2)
    {
        $radioTierra = 6371000; // metros
        
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        
        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLon / 2) * sin($dLon / 2);
        
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        
        return $radioTierra * $c;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $asistencia = Asistencia::findOrFail($id);
        
        $request->validate([
            'lat' => 'nullable|string|max:20',
            'lon' => 'nullable|string|max:20',
        ]);

        $asistencia->update([
            'lat' => $request->lat ?? $asistencia->lat,
            'lon' => $request->lon ?? $asistencia->lon,
        ]);

        return redirect()->route('asistencias.index')->with('success', 'Asistencia actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $asistencia = Asistencia::findOrFail($id);
        $asistencia->delete();

        return redirect()->route('asistencias.index')->with('success', 'Asistencia eliminada correctamente');
    }

    /**
     * Obtener asistencias de un operador específico
     */
    public function getByOperador($id_operador)
    {
        $asistencias = Asistencia::with('operador')
            ->where('id_operador', $id_operador)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($asistencias);
    }

    /**
     * Obtener asistencias por fecha
     */
    public function getByFecha(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date',
        ]);

        $asistencias = Asistencia::with('operador')
            ->whereDate('created_at', $request->fecha)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($asistencias);
    }

    /**
     * Reporte de asistencias por rango de fechas
     */
    public function reporte(Request $request)
    {
        $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        $asistencias = Asistencia::with('operador')
            ->whereBetween('created_at', [
                Carbon::parse($request->fecha_inicio)->startOfDay(),
                Carbon::parse($request->fecha_fin)->endOfDay()
            ])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('supervisores.asistencias.reporte', compact('asistencias'));
    }

    /**
     * Estadísticas de asistencias
     */
    public function estadisticas()
    {
        $hoy = Asistencia::whereDate('created_at', Carbon::today())->count();
        $semana = Asistencia::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
        $mes = Asistencia::whereMonth('created_at', Carbon::now()->month)->count();
        
        $porOperador = Asistencia::selectRaw('id_operador, count(*) as total')
            ->with('operador')
            ->groupBy('id_operador')
            ->orderBy('total', 'desc')
            ->limit(10)
            ->get();

        return response()->json([
            'hoy' => $hoy,
            'semana' => $semana,
            'mes' => $mes,
            'top_operadores' => $porOperador
        ]);
    }
}