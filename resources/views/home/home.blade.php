<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Santo Rayo | Trazabilidad Inteligente</title>

    <!-- Bootstrap 5 + Icons + Fonts -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <!-- Google Fonts: Inter & Space Grotesk (modernas) -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,600;14..32,700;14..32,800&family=Space+Grotesk:wght@400;500;600&display=swap" rel="stylesheet">
    
    <!-- AOS Animation Library (scroll animations) -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #ffffff;
            color: #0a0c12;
            overflow-x: hidden;
            /* PADDING TOP para que el navbar fijo no tape el contenido */
            padding-top: 76px;
        }

        /* Custom modern scroll */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        ::-webkit-scrollbar-thumb {
            background: #f59e0b;
            border-radius: 10px;
        }

        /* Navbar glassmorphism + blur - ajustado para fixed-top */
        .navbar-modern {
            background: rgba(10, 14, 23, 0.92);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255,255,255,0.1);
            transition: all 0.3s ease;
            padding: 1rem 2rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        .navbar-brand {
            font-family: 'Space Grotesk', monospace;
            font-weight: 600;
            font-size: 1.7rem;
            letter-spacing: -0.5px;
            background: linear-gradient(135deg, #FFF 30%, #fbbf24 80%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent !important;
        }
        .btn-outline-glass {
            border: 1px solid rgba(255,255,255,0.3);
            background: rgba(255,255,255,0.05);
            border-radius: 60px;
            padding: 8px 24px;
            color: white;
            font-weight: 500;
            transition: 0.25s;
        }
        .btn-outline-glass:hover {
            background: #f59e0b;
            border-color: #f59e0b;
            color: #0a0c12;
            transform: scale(1.02);
        }

        /* Hero Section - modern dynamic gradient */
        .hero-modern {
            min-height: calc(90vh - 76px);
            background: radial-gradient(circle at 80% 20%, rgba(15,25,45,1) 0%, rgba(2,6,23,1) 100%);
            position: relative;
            display: flex;
            align-items: center;
            overflow: hidden;
            margin-top: 0;
        }
        .hero-modern::before {
            content: "";
            position: absolute;
            width: 100%;
            height: 100%;
            background: url('https://images.unsplash.com/photo-1519003722824-194d4455a60c?q=80&w=2070&auto=format');
            background-size: cover;
            background-position: center;
            opacity: 0.12;
            filter: brightness(0.7);
            pointer-events: none;
        }
        .hero-glow {
            position: absolute;
            width: 60%;
            height: 60%;
            background: radial-gradient(circle, rgba(245,158,11,0.2) 0%, rgba(0,0,0,0) 70%);
            top: 20%;
            right: -10%;
            border-radius: 50%;
            filter: blur(80px);
        }
        .hero-title {
            font-weight: 800;
            font-size: 3.8rem;
            line-height: 1.2;
            letter-spacing: -1.5px;
        }
        .hero-gradient-text {
            background: linear-gradient(120deg, #FFE6B0, #f59e0b, #FFB347);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        .btn-primary-glow {
            background: linear-gradient(95deg, #f59e0b 0%, #fbbf24 100%);
            border: none;
            padding: 12px 32px;
            border-radius: 40px;
            font-weight: 600;
            color: #0f172a;
            transition: all 0.3s;
            box-shadow: 0 8px 20px rgba(245,158,11,0.3);
        }
        .btn-primary-glow:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(245,158,11,0.5);
            background: linear-gradient(95deg, #fbbf24 0%, #f59e0b 100%);
            color: #000;
        }

        /* Feature cards - elegant & modern */
        .feature-card {
            background: #ffffff;
            border-radius: 2rem;
            padding: 1.8rem 1.2rem;
            transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
            border: 1px solid rgba(0,0,0,0.04);
            box-shadow: 0 15px 35px -12px rgba(0,0,0,0.05);
            text-align: center;
            height: 100%;
        }
        .feature-card:hover {
            transform: translateY(-12px);
            border-color: rgba(245,158,11,0.3);
            box-shadow: 0 30px 45px -20px rgba(245,158,11,0.25);
        }
        .feature-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(145deg, #fef3c7, #ffedd5);
            border-radius: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2rem;
            color: #f59e0b;
        }
        .feature-title {
            font-weight: 700;
            font-size: 1.5rem;
            margin-bottom: 0.75rem;
        }

        /* Dashboard preview / stats modern */
        .stats-modern {
            background: #0f172a;
            border-radius: 2.5rem;
            padding: 2.5rem;
            color: white;
            box-shadow: 0 20px 35px -15px rgba(0,0,0,0.2);
        }
        .glass-stats {
            background: rgba(255,255,255,0.05);
            backdrop-filter: blur(8px);
            border-radius: 1.5rem;
            padding: 1.2rem;
            border: 1px solid rgba(255,255,255,0.1);
        }
        .counter-number {
            font-size: 2.5rem;
            font-weight: 800;
            font-family: 'Space Grotesk', monospace;
        }

        /* Modern testimonial / CTA */
        .cta-modern {
            background: linear-gradient(115deg, #0a0c1a 0%, #141b2b 100%);
            border-radius: 2.5rem;
            padding: 3rem;
            position: relative;
            overflow: hidden;
        }
        .cta-modern::after {
            content: "⚡";
            font-size: 12rem;
            opacity: 0.05;
            position: absolute;
            bottom: -30px;
            right: 20px;
            font-weight: 900;
        }

        footer {
            background: #020617;
            color: #94a3b8;
            padding: 2rem;
            border-top: 1px solid #1e293b;
        }

        /* responsive */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            .navbar-modern {
                padding: 0.8rem 1rem;
            }
            body {
                padding-top: 68px;
            }
            .hero-modern {
                min-height: calc(85vh - 68px);
            }
        }
        .img-elegant {
            border-radius: 2rem;
            box-shadow: 0 25px 40px -15px rgba(0,0,0,0.2);
            transition: transform 0.4s;
        }
        .img-elegant:hover {
            transform: scale(1.01);
        }
        .badge-modern {
            background: rgba(245,158,11,0.15);
            color: #fbbf24;
            border-radius: 40px;
            padding: 6px 14px;
            font-weight: 500;
            font-size: 0.85rem;
        }
        /* Ajuste extra para asegurar que el contenido no quede debajo del navbar */
        section:first-of-type {
            scroll-margin-top: 80px;
        }
    </style>
</head>
<body>

<!-- NAVBAR - transparente y moderno (fixed-top) -->
<nav class="navbar navbar-expand-lg navbar-modern fixed-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#">
            <i class="fa-solid fa-bolt me-2" style="color: #f59e0b;"></i> Santo Rayo
        </a>
        <div class="ms-auto d-flex align-items-center gap-3">
            <a href="{{url('login')}}" class="btn btn-outline-glass">
                <i class="fa-regular fa-user me-1"></i> Ingresar
            </a>
        </div>
    </div>
</nav>

<!-- HERO MODERNO con ajuste para que no tape el navbar -->
<section class="hero-modern">
    <div class="hero-glow"></div>
    <div class="container position-relative" style="z-index: 2;">
        <div class="row align-items-center">
            <div class="col-lg-7 text-white" data-aos="fade-up" data-aos-duration="1000">
                <span class="badge-modern d-inline-block mb-3">
                    <i class="fa-solid fa-location-dot me-1"></i> Trazabilidad en tiempo real
                </span>
                <h1 class="hero-title mb-4">
                    Control logístico <br>
                    con <span class="hero-gradient-text">evidencia viva</span> y geolocalización
                </h1>
                <p class="lead mb-4 opacity-75" style="max-width: 90%;">
                    Monitoreo QR, fotografía georreferenciada y tiempos exactos. 
                    La nueva era de transparencia para tu flota.
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="{{url('login')}}" class="btn btn-primary-glow btn-lg">
                        <i class="fa-solid fa-chart-line me-2"></i> Panel de control
                    </a>
                    <a href="#" class="btn btn-outline-light rounded-pill px-4">
                        <i class="fa-regular fa-circle-play me-2"></i> Ver demo
                    </a>
                </div>
                <div class="mt-5 d-flex gap-4 flex-wrap">
                    <div><i class="fa-regular fa-clock text-warning me-1"></i> <span class="small">Actualización 5s</span></div>
                    <div><i class="fa-solid fa-qrcode text-warning me-1"></i> <span class="small">Escaneo offline</span></div>
                    <div><i class="fa-solid fa-camera text-warning me-1"></i> <span class="small">Evidencia forense</span></div>
                </div>
            </div>
            <div class="col-lg-5 mt-5 mt-lg-0" data-aos="fade-left" data-aos-delay="200">
                <div class="stats-modern">
                    <div class="glass-stats mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <span><i class="fa-solid fa-truck-fast me-2 text-warning"></i> Entregas activas</span>
                            <span class="counter-number" id="activeDeliveries">247</span>
                        </div>
                        <div class="progress mt-2" style="height: 5px;">
                            <div class="progress-bar bg-warning" style="width: 82%"></div>
                        </div>
                    </div>
                    <div class="glass-stats mb-3">
                        <div class="d-flex justify-content-between">
                            <span><i class="fa-regular fa-clock me-2"></i> Tiempo promedio</span>
                            <span><strong>2.4h</strong> / ruta</span>
                        </div>
                    </div>
                    <div class="glass-stats">
                        <div class="d-flex justify-content-between">
                            <span><i class="fa-solid fa-check-circle me-2 text-success"></i> Precisión GPS</span>
                            <span><strong class="text-warning">99.7%</strong></span>
                        </div>
                        <div class="small opacity-50 mt-1">+ geocercas activas</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FEATURES: modern card design -->
<section class="py-5" style="background-color: #fefcf7;">
    <div class="container py-4">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="badge-modern bg-dark text-warning">Ecosistema inteligente</span>
            <h2 class="display-6 fw-bold mt-3">Potencia tu operación logística</h2>
            <p class="text-secondary mx-auto" style="max-width: 600px;">Soluciones integradas para visibilidad total desde origen hasta destino.</p>
        </div>
        <div class="row g-4">
            <div class="col-md-3 col-sm-6" data-aos="fade-up" data-aos-delay="100">
                <div class="feature-card">
                    <div class="feature-icon"><i class="fa-solid fa-location-dot"></i></div>
                    <h4 class="feature-title">Geocerca GPS</h4>
                    <p class="text-secondary">Alertas en tiempo real, perímetros virtuales y rutas dinámicas con precisión satelital.</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6" data-aos="fade-up" data-aos-delay="200">
                <div class="feature-card">
                    <div class="feature-icon"><i class="fa-solid fa-qrcode"></i></div>
                    <h4 class="feature-title">Escaneo QR</h4>
                    <p class="text-secondary">Códigos únicos por envío, registro instantáneo y validación antifraude.</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6" data-aos="fade-up" data-aos-delay="300">
                <div class="feature-card">
                    <div class="feature-icon"><i class="fa-solid fa-camera-retro"></i></div>
                    <h4 class="feature-title">Evidencia visual</h4>
                    <p class="text-secondary">Fotos de carga/entrega con sello de tiempo y geolocalización automática.</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6" data-aos="fade-up" data-aos-delay="400">
                <div class="feature-card">
                    <div class="feature-icon"><i class="fa-solid fa-chart-simple"></i></div>
                    <h4 class="feature-title">Control de tiempos</h4>
                    <p class="text-secondary">KPIs de eficiencia, heatmaps de demoras y reportes inteligentes.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SECCIÓN INTERACTIVA: mapa visual mockup + imagen moderna de operación -->
<section class="py-5">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="position-relative">
                    <img src="https://images.pexels.com/photos/4483610/pexels-photo-4483610.jpeg" 
                         class="img-fluid img-elegant w-100" 
                         alt="flota logística moderna" style="object-fit: cover; height: 380px;">
                    <div class="position-absolute top-0 start-0 m-3 bg-dark bg-opacity-75 text-white px-3 py-1 rounded-pill">
                        <i class="fa-solid fa-map-pin text-warning"></i> Monitoreo en vivo
                    </div>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <span class="badge-modern"><i class="fa-regular fa-eye"></i> Central de control</span>
                <h3 class="fw-bold display-6 mt-2">Dashboard interactivo</h3>
                <p class="lead text-secondary">Visualiza cada paso de la cadena con métricas actualizadas, trazabilidad desde el primer kilómetro.</p>
                <div class="row mt-4">
                    <div class="col-6 mb-3">
                        <div class="bg-light p-3 rounded-4">
                            <i class="fa-solid fa-flag-checkered fa-2x text-warning mb-2"></i>
                            <h5 class="fw-bold">+1,200</h5>
                            <small class="text-secondary">Entregas exitosas / mes</small>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="bg-light p-3 rounded-4">
                            <i class="fa-solid fa-mobile-alt fa-2x text-warning mb-2"></i>
                            <h5 class="fw-bold">98%</h5>
                            <small class="text-secondary">Digitalización QR</small>
                        </div>
                    </div>
                </div>
                <a href="{{url('login')}}" class="btn btn-dark rounded-pill px-4 mt-2">Explorar módulos <i class="fa-solid fa-arrow-right ms-2"></i></a>
            </div>
        </div>
    </div>
</section>

<!-- VIDEO / TECNOLOGIA: Cards de beneficios adicionales con íconos elegantes -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <i class="fa-solid fa-microchip fa-2x text-warning mb-2"></i>
            <h2 class="fw-bold">Innovación aplicada a la logística</h2>
            <p class="text-secondary">Tecnología de punta para equipos que exigen resultados medibles</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4" data-aos="flip-left" data-aos-delay="100">
                <div class="d-flex gap-3 p-3 rounded-4 border-0 shadow-sm">
                    <i class="fa-solid fa-cloud-arrow-up fa-3x text-warning"></i>
                    <div>
                        <h5 class="fw-bold">Sincronización cloud</h5>
                        <p class="text-secondary">Datos en tiempo real desde cualquier dispositivo móvil o tablet.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4" data-aos="flip-left" data-aos-delay="200">
                <div class="d-flex gap-3 p-3 rounded-4 border-0 shadow-sm">
                    <i class="fa-solid fa-shield-haltered fa-3x text-warning"></i>
                    <div>
                        <h5 class="fw-bold">Evidencia inalterable</h5>
                        <p class="text-secondary">Hash de verificación + metadatos de ubicación y hora.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4" data-aos="flip-left" data-aos-delay="300">
                <div class="d-flex gap-3 p-3 rounded-4 border-0 shadow-sm">
                    <i class="fa-solid fa-chart-line fa-3x text-warning"></i>
                    <div>
                        <h5 class="fw-bold">Reportes automáticos</h5>
                        <p class="text-secondary">Exporta indicadores de desempeño y eficiencia por ruta.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA MODERNA con efecto glass -->
<section class="py-5">
    <div class="container">
        <div class="cta-modern" data-aos="zoom-in">
            <div class="row align-items-center">
                <div class="col-md-8 text-white">
                    <h3 class="fw-bold">¿Listo para transformar tu trazabilidad?</h3>
                    <p class="mb-0 opacity-75">Únete a empresas que ya optimizan su cadena con Santo Rayo.</p>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <a href="{{url('login')}}" class="btn btn-warning btn-lg rounded-pill px-5 fw-semibold">
                        Comenzar ahora <i class="fa-regular fa-paper-plane ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FOOTER moderno -->
<footer>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                <i class="fa-solid fa-bolt text-warning me-1"></i> <strong>Santo Rayo</strong> — Trazabilidad con integridad
            </div>
            <div class="col-md-6 text-center text-md-end">
                <span class="me-3"><i class="fa-regular fa-copyright"></i> 2026 Santo Rayo</span>
                <span class="me-3"><i class="fa-brands fa-github"></i> Innovación logística</span>
                <span><i class="fa-solid fa-map-pin"></i> Tiempo real</span>
            </div>
        </div>
    </div>
</footer>

<!-- Scripts: AOS + contador animado ligero -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    // Inicializar AOS animaciones
    AOS.init({
        duration: 800,
        once: true,
        mirror: false
    });

    // Contador simple dinámico para dar sensación de actualización (solo estético)
    let counter = 247;
    const counterElem = document.getElementById('activeDeliveries');
    if(counterElem) {
        setInterval(() => {
            // simula variación sutil
            let change = Math.floor(Math.random() * 5) - 2; // -2 .. 2
            let newVal = counter + change;
            if(newVal >= 210 && newVal <= 285) {
                counter = newVal;
                counterElem.innerText = counter;
            } else {
                if(newVal > 285) counter = 283;
                if(newVal < 210) counter = 215;
                counterElem.innerText = counter;
            }
        }, 4000);
    }

    // Smooth scroll para enlaces internos (si se agregan)
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if(href !== "#" && href !== "") {
                const target = document.querySelector(href);
                if(target) {
                    e.preventDefault();
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            }
        });
    });
</script>
<!-- Bootstrap JS Bundle (opcional para componentes) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>