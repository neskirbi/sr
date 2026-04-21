<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Santo Rayo | Nueva Contraseña</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@300;400;500;600;700;800&family=Space+Grotesk:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: radial-gradient(circle at 80% 20%, #0f172a 0%, #020617 100%);
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
        }

        body::before {
            content: "";
            position: absolute;
            width: 100%;
            height: 100%;
            background: url('https://images.unsplash.com/photo-1519003722824-194d4455a60c?q=80&w=2070&auto=format');
            background-size: cover;
            background-position: center;
            opacity: 0.06;
            pointer-events: none;
        }

        .reset-container {
            width: 440px;
            max-width: 100%;
            position: relative;
            z-index: 2;
        }

        .card-reset {
            background: white;
            border-radius: 2rem;
            box-shadow: 0 25px 45px -12px rgba(0, 0, 0, 0.4);
            overflow: hidden;
        }

        .reset-header {
            background: linear-gradient(135deg, #0f172a, #1e293b);
            padding: 1.8rem;
            text-align: center;
        }

        .reset-header h2 {
            font-family: 'Space Grotesk', monospace;
            font-weight: 700;
            font-size: 1.9rem;
            background: linear-gradient(135deg, #FFF, #fbbf24);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin: 0;
        }

        .reset-header p {
            color: #94a3b8;
            font-size: 0.85rem;
            margin-top: 8px;
        }

        .form-reset {
            padding: 2rem;
        }

        .input-pass {
            margin-bottom: 1.5rem;
        }

        .input-pass label {
            display: block;
            font-weight: 600;
            font-size: 0.85rem;
            color: #1e293b;
            margin-bottom: 8px;
        }

        .input-pass label i {
            color: #f59e0b;
            width: 24px;
        }

        .input-pass input {
            width: 100%;
            padding: 12px 16px;
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
            border-radius: 1rem;
            font-family: 'Inter', sans-serif;
            transition: all 0.2s;
        }

        .input-pass input:focus {
            outline: none;
            border-color: #f59e0b;
            box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
            background: white;
        }

        .password-strength {
            font-size: 0.7rem;
            margin-top: 5px;
        }

        .btn-reset {
            width: 100%;
            padding: 12px;
            background: linear-gradient(95deg, #f59e0b, #fbbf24);
            border: none;
            border-radius: 2rem;
            font-weight: 700;
            font-size: 1rem;
            color: #0f172a;
            transition: 0.2s;
            margin-top: 0.5rem;
        }

        .btn-reset:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(245, 158, 11, 0.4);
        }

        .info-footer {
            background: #f8fafc;
            padding: 1rem;
            text-align: center;
            border-top: 1px solid #eef2f6;
            font-size: 0.75rem;
            color: #64748b;
        }

        .info-footer i {
            color: #f59e0b;
        }

        .alert-custom {
            font-size: 0.75rem;
            padding: 8px 12px;
            border-radius: 1rem;
        }

        .corner {
            position: fixed;
            bottom: 16px;
            right: 16px;
            background: rgba(0,0,0,0.4);
            backdrop-filter: blur(4px);
            padding: 4px 12px;
            border-radius: 30px;
            font-size: 11px;
            color: #94a3b8;
        }
    </style>
</head>
<body>

@include('toast.toasts')

<div class="reset-container">
    <div class="card-reset">
        <div class="reset-header">
            <h2><i class="fa-solid fa-key me-2"></i> Santo Rayo</h2>
            <p>Establece tu nueva contraseña</p>
        </div>

        <div class="form-reset">
            <form action="{{url('savepass')}}/{{$usuario->id}}" method="post" id="resetForm">
                @csrf

                <div class="input-pass">
                    <label><i class="fa-solid fa-lock"></i> Nueva contraseña</label>
                    <input type="password" name="pass" id="pass" placeholder="Mínimo 6 caracteres" required onkeyup="validarPassword();">
                    <div class="password-strength text-secondary" id="passHelp"></div>
                </div>

                <div class="input-pass">
                    <label><i class="fa-solid fa-check-circle"></i> Confirmar contraseña</label>
                    <input type="password" name="pass2" id="pass2" placeholder="Repite la contraseña" required onkeyup="validarPassword();">
                </div>

                <div id="matchAlert" class="alert-custom mb-3" style="display: none;"></div>

                <button type="submit" class="btn-reset" id="submitBtn">
                    <i class="fa-regular fa-floppy-disk me-2"></i> Guardar nueva contraseña
                </button>
            </form>
        </div>

        <div class="info-footer">
            <i class="fa-solid fa-bolt"></i> La seguridad de tu flota comienza aquí
        </div>
    </div>
</div>

<div class="corner">
    <i class="fa-solid fa-shield-haltered text-warning"></i> Santo Rayo
</div>

<script>
    function validarPassword() {
        const pass = document.getElementById('pass').value;
        const pass2 = document.getElementById('pass2').value;
        const matchAlert = document.getElementById('matchAlert');
        const submitBtn = document.getElementById('submitBtn');
        const passHelp = document.getElementById('passHelp');

        // validar longitud
        if (pass.length > 0 && pass.length < 6) {
            passHelp.innerHTML = '<i class="fa-regular fa-circle-exclamation"></i> Mínimo 6 caracteres';
            passHelp.style.color = '#eab308';
        } else if (pass.length >= 6) {
            passHelp.innerHTML = '<i class="fa-regular fa-circle-check"></i> Contraseña válida';
            passHelp.style.color = '#10b981';
        } else {
            passHelp.innerHTML = '';
        }

        if (pass2.length > 0 && pass !== pass2) {
            matchAlert.style.display = 'block';
            matchAlert.innerHTML = '<i class="fa-regular fa-circle-xmark me-1"></i> Las contraseñas no coinciden';
            matchAlert.style.background = '#fef2f2';
            matchAlert.style.color = '#dc2626';
            submitBtn.disabled = true;
            submitBtn.style.opacity = '0.6';
            submitBtn.style.cursor = 'not-allowed';
        } else if (pass === pass2 && pass.length >= 6 && pass2.length >= 6) {
            matchAlert.style.display = 'block';
            matchAlert.innerHTML = '<i class="fa-regular fa-circle-check me-1"></i> Las contraseñas coinciden';
            matchAlert.style.background = '#ecfdf5';
            matchAlert.style.color = '#059669';
            submitBtn.disabled = false;
            submitBtn.style.opacity = '1';
            submitBtn.style.cursor = 'pointer';
        } else if (pass === pass2 && pass.length < 6 && pass.length > 0) {
            matchAlert.style.display = 'block';
            matchAlert.innerHTML = '<i class="fa-regular fa-circle-exclamation"></i> La contraseña debe tener al menos 6 caracteres';
            matchAlert.style.background = '#fffbeb';
            matchAlert.style.color = '#d97706';
            submitBtn.disabled = true;
        } else {
            matchAlert.style.display = 'none';
            submitBtn.disabled = true;
            submitBtn.style.opacity = '0.6';
        }
    }

    // inicializar deshabilitado
    document.getElementById('submitBtn').disabled = true;
    document.getElementById('submitBtn').style.opacity = '0.6';
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>