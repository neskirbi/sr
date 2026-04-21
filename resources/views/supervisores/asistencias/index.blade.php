<!DOCTYPE html>
<html lang="en">
<head>
  @include('header')
  <title>{{GetBrand()}} | Asistencias</title>
  
  <!-- Google Maps API con variable de entorno -->
  <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap" async defer></script>
  
  <style>
    #map {
      height: 350px;
      width: 100%;
      border-radius: 8px;
      margin-bottom: 15px;
    }
    .coords-info {
      background: #f8f9fa;
      padding: 10px;
      border-radius: 5px;
      margin-top: 10px;
      font-size: 13px;
    }
  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
@include('toast.toasts')  
<div class="wrapper">

  @include('supervisores.navigations.navigation')
  @include('supervisores.sidebars.sidebar')

  <div class="content-wrapper">
    <section class="content">
      <div class="container-fluid">
        
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-fingerprint text-warning" aria-hidden="true"></i> 
                  <strong>Control de Asistencias</strong>
                </h3>
                <div class="card-tools">
                  <span class="badge badge-warning p-2">
                    <i class="fas fa-calendar-check"></i> Total: {{ $asistencias->count() }}
                  </span>
                </div>
              </div>
              
              <div class="card-body">
                
                <!-- FORMULARIO PARA REGISTRAR ASISTENCIA -->
                <div class="card card-warning mt-4">
                  <div class="card-header">
                    <h3 class="card-title">
                      <i class="fas fa-map-marked-alt"></i> <strong>Registrar asistencia con ubicación</strong>
                    </h3>
                  </div>
                  <div class="card-body">
                    <form action="{{ url('supervision/asistencias') }}" method="post" id="formAsistencia">
                      @csrf
                      
                      <!-- Selector de Operador -->
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label><i class="fas fa-user"></i> Operador</label>
                            <select class="form-control" name="id_operador" id="id_operador" required>
                              <option value="">Seleccionar operador</option>
                              @foreach($operadores ?? [] as $operador)
                                <option value="{{ $operador->id }}">{{ $operador->nombres }} {{ $operador->apellidos }} - {{ $operador->mail }}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                      </div>
                      
                      <div class="row">
                        <div class="col-md-12">
                          <label><i class="fas fa-map"></i> Ubicación</label>
                          <div id="map"></div>
                        </div>
                      </div>
                      
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label><i class="fas fa-map-marker-alt"></i> Latitud</label>
                            <input type="text" class="form-control" name="lat" id="lat" placeholder="Ej: 19.4326" readonly required>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label><i class="fas fa-map-marker-alt"></i> Longitud</label>
                            <input type="text" class="form-control" name="lon" id="lon" placeholder="Ej: -99.1332" readonly required>
                          </div>
                        </div>
                      </div>
                      
                      <div class="coords-info" id="coordsInfo">
                        <i class="fas fa-info-circle text-info"></i> Esperando ubicación...
                      </div>
                      
                      <div class="row">
                        <div class="col-12 text-right">
                          <button type="submit" class="btn btn-warning btn-lg">
                            <i class="fas fa-save"></i> Registrar asistencia
                          </button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>

                <!-- TABLA DE ASISTENCIAS EXISTENTES -->
                <div class="mt-4">
                  <h5><i class="fas fa-history text-warning"></i> Historial de asistencias</h5>
                  <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                      <thead class="bg-light">
                        <tr>
                          <th><i class="fas fa-hashtag"></i> ID</th>
                          <th><i class="fas fa-user"></i> Operador</th>
                          <th><i class="fas fa-envelope"></i> Correo</th>
                          <th><i class="fas fa-phone"></i> Teléfono</th>
                          <th><i class="fas fa-map-marker-alt"></i> Ubicación</th>
                          <th><i class="fas fa-calendar"></i> Fecha/Hora</th>
                          <th><i class="fas fa-cog"></i> Acciones</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($asistencias as $asistencia)
                        <tr>
                          <td>{{ $asistencia->id }}</td>
                          <td>
                            <strong>{{ $asistencia->operador->nombres ?? 'N/A' }} {{ $asistencia->operador->apellidos ?? '' }}</strong>
                          </td>
                          <td>{{ $asistencia->operador->mail ?? 'N/A' }}</td>
                          <td>{{ $asistencia->operador->telefono ?? 'N/A' }}</td>
                          <td>
                            <span class="badge badge-info">
                              <i class="fas fa-map-pin"></i> {{ $asistencia->lat ?? 'N/A' }}, {{ $asistencia->lon ?? 'N/A' }}
                            </span>
                          </td>
                          <td>
                            <i class="far fa-clock"></i> {{ \Carbon\Carbon::parse($asistencia->created_at)->format('d/m/Y H:i:s') }}
                          </td>
                          <td>
                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalEliminar{{ $asistencia->id }}">
                              <i class="fas fa-trash-alt"></i> Eliminar
                            </button>
                          </td>
                        </tr>

                        <!-- MODAL PARA ELIMINAR -->
                        <div class="modal fade" id="modalEliminar{{ $asistencia->id }}" tabindex="-1" role="dialog">
                          <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                              <div class="modal-header bg-danger text-white">
                                <h5 class="modal-title"><i class="fas fa-exclamation-triangle"></i> Confirmar eliminación</h5>
                                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                              </div>
                              <div class="modal-body">
                                <p>¿Estás seguro de eliminar este registro?</p>
                                <div class="alert alert-warning text-center">
                                  <strong>{{ $asistencia->operador->nombres ?? 'Operador' }} {{ $asistencia->operador->apellidos ?? '' }}</strong>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <form action="{{ url('supervision/asistencias') }}/{{ $asistencia->id }}" method="post" style="display:inline;">
                                  @csrf
                                  @method('delete')
                                  <button type="submit" class="btn btn-danger">Eliminar</button>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>

      </div>
    </section>
  </div>

  <footer class="main-footer"></footer>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  var map;
  var marker;

  function initMap() {
    // Cargar mapa con ubicación por defecto (CDMX)
    var ubicacionDefault = { lat: 19.4326, lng: -99.1332 };
    
    map = new google.maps.Map(document.getElementById('map'), {
      center: ubicacionDefault,
      zoom: 14,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });
    
    marker = new google.maps.Marker({
      position: ubicacionDefault,
      map: map,
      draggable: true
    });
    
    document.getElementById('lat').value = ubicacionDefault.lat.toFixed(7);
    document.getElementById('lon').value = ubicacionDefault.lng.toFixed(7);
    
    // Obtener ubicación real automáticamente
    if (navigator.geolocation) {
      document.getElementById('coordsInfo').innerHTML = '<i class="fas fa-spinner fa-spin"></i> Obteniendo tu ubicación...';
      
      navigator.geolocation.getCurrentPosition(
        function(position) {
          var lat = position.coords.latitude;
          var lng = position.coords.longitude;
          var ubicacionReal = { lat: lat, lng: lng };
          
          map.setCenter(ubicacionReal);
          marker.setPosition(ubicacionReal);
          
          document.getElementById('lat').value = lat.toFixed(7);
          document.getElementById('lon').value = lng.toFixed(7);
          document.getElementById('coordsInfo').innerHTML = '<i class="fas fa-check-circle text-success"></i> Ubicación obtenida y marcada en el mapa.';
        },
        function(error) {
          document.getElementById('coordsInfo').innerHTML = '<i class="fas fa-exclamation-triangle text-warning"></i> No se pudo obtener tu ubicación. Usando ubicación por defecto. Haz clic en el mapa para seleccionar.';
        }
      );
    } else {
      document.getElementById('coordsInfo').innerHTML = '<i class="fas fa-exclamation-triangle text-warning"></i> Tu navegador no soporta geolocalización. Selecciona manualmente en el mapa.';
    }
    
    // Mover marcador con clic en el mapa
    map.addListener('click', function(event) {
      marker.setPosition(event.latLng);
      document.getElementById('lat').value = event.latLng.lat().toFixed(7);
      document.getElementById('lon').value = event.latLng.lng().toFixed(7);
      document.getElementById('coordsInfo').innerHTML = '<i class="fas fa-check-circle text-success"></i> Ubicación seleccionada manualmente.';
    });
    
    // Mover marcador arrastrando
    marker.addListener('dragend', function(event) {
      document.getElementById('lat').value = event.latLng.lat().toFixed(7);
      document.getElementById('lon').value = event.latLng.lng().toFixed(7);
      document.getElementById('coordsInfo').innerHTML = '<i class="fas fa-check-circle text-success"></i> Ubicación actualizada manualmente.';
    });
  }
  
  // Validar formulario
  document.getElementById('formAsistencia').addEventListener('submit', function(e) {
    var lat = document.getElementById('lat').value;
    var lon = document.getElementById('lon').value;
    var operador = document.getElementById('id_operador').value;
    
    if (!operador) {
      e.preventDefault();
      if (typeof toastr !== 'undefined') toastr.error('Selecciona un operador');
      return false;
    }
    
    if (!lat || !lon) {
      e.preventDefault();
      if (typeof toastr !== 'undefined') toastr.error('Selecciona una ubicación en el mapa');
      return false;
    }
  });
</script>
@include('footer')
</body>
</html>