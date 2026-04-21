<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Santo Rayo | Ingresar</title>

    @include('header')
    <!-- Bootstrap + Icons + Fonts -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700;800&family=Space+Grotesk:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: radial-gradient(circle at 10% 30%, #0f172a 0%, #020617 100%);
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow-x: hidden;
        }

        /* efecto de fondo */
        body::before {
            content: "";
            position: absolute;
            width: 100%;
            height: 100%;
            background: url('https://images.unsplash.com/photo-1519003722824-194d4455a60c?q=80&w=2070&auto=format');
            background-size: cover;
            background-position: center;
            opacity: 0.08;
            pointer-events: none;
        }

        .login-container {
            width: 460px;
            max-width: 100%;
            position: relative;
            z-index: 2;
        }

        .card-santo {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(2px);
            border-radius: 2rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35);
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .card-santo:hover {
            transform: translateY(-5px);
        }

        .brand-header {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            padding: 1.8rem;
            text-align: center;
        }

        .brand-header h2 {
            font-family: 'Space Grotesk', monospace;
            font-weight: 700;
            font-size: 2rem;
            background: linear-gradient(135deg, #FFF 20%, #fbbf24 90%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin: 0;
        }

        .brand-header p {
            color: #94a3b8;
            font-size: 0.85rem;
            margin-top: 8px;
        }

        .form-santo {
            padding: 2rem 2rem 1.8rem;
        }

        .input-group-custom {
            margin-bottom: 1.25rem;
        }

        .input-group-custom label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 0.5rem;
        }

        .input-group-custom label i {
            color: #f59e0b;
            width: 24px;
        }

        .input-group-custom input {
            width: 100%;
            padding: 12px 16px;
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
            border-radius: 1rem;
            font-family: 'Inter', sans-serif;
            font-size: 0.95rem;
            transition: all 0.2s;
        }

        .input-group-custom input:focus {
            outline: none;
            border-color: #f59e0b;
            box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.15);
            background: white;
        }

        .btn-santo-primary {
            width: 100%;
            padding: 12px;
            background: linear-gradient(95deg, #f59e0b, #fbbf24);
            border: none;
            border-radius: 2rem;
            font-weight: 700;
            font-size: 1rem;
            color: #0f172a;
            transition: all 0.2s;
            margin-top: 0.5rem;
        }

        .btn-santo-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(245, 158, 11, 0.35);
        }

        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 1.5rem 0;
            color: #94a3b8;
            font-size: 0.75rem;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #e2e8f0;
        }

        .divider span {
            padding: 0 10px;
        }

        .footer-links {
            text-align: center;
            padding: 1.2rem;
            background: #f8fafc;
            border-top: 1px solid #eef2f6;
        }

        .footer-links a {
            color: #f59e0b;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .footer-links a:hover {
            text-decoration: underline;
        }

        .tech-badge {
            display: flex;
            justify-content: center;
            gap: 1.8rem;
            margin-top: 1rem;
            font-size: 0.75rem;
            color: #64748b;
        }

        .tech-badge i {
            color: #f59e0b;
            margin-right: 5px;
        }

        .corner-rayo {
            position: fixed;
            bottom: 16px;
            right: 16px;
            font-size: 11px;
            color: #475569;
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(4px);
            padding: 5px 12px;
            border-radius: 30px;
            color: #cbd5e1;
        }
    </style>
</head>
<body>

@include('toast.toasts')

<div class="login-container">
    <div class="card-santo">
        <div class="brand-header">
            <h2><i class="fa-solid fa-bolt me-2"></i> Santo Rayo</h2>
            <p>Trazabilidad con evidencia y geolocalización</p>
        </div>

        <div class="form-santo">
            <form action="{{url('Ingresar')}}" method="post">
                @csrf
                <div class="input-group-custom">
                    <label><i class="fa-regular fa-envelope"></i> Correo electrónico</label>
                    <input type="email" name="mail" placeholder="usuario@santoryo.com" required>
                </div>

                <div class="input-group-custom">
                    <label><i class="fa-solid fa-lock"></i> Contraseña</label>
                    <input type="password" name="pass" placeholder="••••••••" required>
                </div>

                <button type="submit" class="btn-santo-primary">
                    <i class="fa-regular fa-arrow-right-to-bracket me-2"></i> Ingresar
                </button>
            </form>

            <div class="divider">
                <span>Seguridad operativa</span>
            </div>

            <div class="tech-badge">
                <span><i class="fa-solid fa-satellite-dish"></i> GPS real-time</span>
                <span><i class="fa-solid fa-qrcode"></i> QR tracking</span>
                <span><i class="fa-solid fa-camera"></i> Evidencia</span>
            </div>
        </div>

        <div class="footer-links">
            <a href="{{url('create')}}"><i class="fa-regular fa-user-plus me-1"></i> Crear cuenta nueva</a>
            <span class="mx-2 text-secondary">|</span>
            <a href="#"><i class="fa-regular fa-key me-1"></i> ¿Olvidaste tu contraseña?</a>
        </div>
    </div>
</div>

<div class="corner-rayo">
    <i class="fa-solid fa-bolt text-warning"></i> Santo Rayo Trazability
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>