<?php
// Datos por defecto (si falla la API)
$temperature = 0;
$humidity = 0;
$windSpeed = 0;
$isDay = 1; // Default to day
$weatherBg = 'bg-[#ff8200]';
$weatherIcon = 'sunny';
$sunriseTime = '--:--';
$sunsetTime = '--:--';
$caudal = 50;

// Cálculos para el círculo de caudal (Radio 78px, Ancho 12px)
$radius = 78;
$circumference = 2 * M_PI * $radius;
$dashoffset = $circumference * (1 - ($caudal / 100));


// Determinar el texto de "Nivel" según el caudal
$nivelText = "Medio";
if ($caudal <= 25) {
} elseif ($caudal >= 75) {
    $nivelText = "Alto";
}

// Mock de últimos cambios
$recentChanges = [
    ['date' => '27/01', 'time' => '14:30', 'status' => 'Medio'],
    ['date' => '27/01', 'time' => '10:15', 'status' => 'Bajo'],
    ['date' => '27/01', 'time' => '08:00', 'status' => 'Alto'],
    ['date' => '26/01', 'time' => '18:45', 'status' => 'Medio'],
    ['date' => '26/01', 'time' => '12:00', 'status' => 'Bajo'],
];

// URL de Open-Meteo
$apiUrl = "https://api.open-meteo.com/v1/forecast?latitude=-31.5375&longitude=-68.5364&current=temperature_2m,relative_humidity_2m,wind_speed_10m,is_day&daily=sunrise,sunset&timezone=auto";

// Inicializar cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, 5); // Timeout corto para no bloquear la carga
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode === 200 && $response) {
    $data = json_decode($response, true);
    if (isset($data['current'])) {
        $temperature = round($data['current']['temperature_2m']);
        $humidity = $data['current']['relative_humidity_2m'];
        $windSpeed = round($data['current']['wind_speed_10m']);
        $isDay = $data['current']['is_day'];
    }
    if (isset($data['daily']['sunrise'][0]) && isset($data['daily']['sunset'][0])) {
        // Formato devuelto: "2023-10-27T06:30"
        $sunriseParts = explode('T', $data['daily']['sunrise'][0]);
        $sunsetParts = explode('T', $data['daily']['sunset'][0]);
        $sunriseTime = isset($sunriseParts[1]) ? $sunriseParts[1] : '--:--';
        $sunsetTime = isset($sunsetParts[1]) ? $sunsetParts[1] : '--:--';
    }
}

// Determinar el estilo según si es de día o de noche
if ($isDay == 1) {
    $weatherBg = 'bg-[#ff8200]';
    $weatherIcon = 'sunny';
} else {
    $weatherBg = 'bg-slate-700'; // Gris azulado
    $weatherIcon = 'bedtime';
}

?>
<!DOCTYPE html>
<html class="light" lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Información Completa del Balneario Rio Las Moras</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#ff8200",
                        "river-blue": "#87CEEB",
                        "background-light": "#f8fafc",
                        "background-dark": "#0f172a",
                    },
                    fontFamily: {
                        "sans": ["Plus Jakarta Sans", "sans-serif"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.5rem",
                        "lg": "1rem",
                        "xl": "1.5rem",
                        "2xl": "2rem"
                    },
                },
            },
        }
    </script>
    <style type="text/tailwindcss">
        @layer base {
            html { scroll-behavior: smooth; }
            body { background-color: #e2e8f0; color: #0f172a; }
        }
        .snap-x {
            scroll-snap-type: x mandatory;
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .snap-x::-webkit-scrollbar {
            display: none;
        }
        .snap-center {
            scroll-snap-align: center;
        }
        .celeste-bg {
            background-color: #87CEEB;
        }
    </style>
    <style>
        body {
            min-height: max(884px, 100dvh);
        }
    </style>
</head>

<body class="dark:bg-background-dark dark:text-slate-100 min-h-screen">
    <header
        class="sticky top-0 z-50 bg-white/90 dark:bg-slate-900/90 backdrop-blur-md border-b border-slate-200 dark:border-slate-800 px-4 py-3">
        <div class="max-w-5xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="https://sanjuan.tur.ar/"
                    class="size-10 flex items-center justify-center rounded-full bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300"
                    title="Volver">
                    <span class="material-symbols-outlined">arrow_back</span>
                </a>
                <div>
                    <h1 class="font-extrabold text-lg tracking-tight">Balneario Rio Las Moras</h1>
                    <p class="text-[10px] text-primary font-bold uppercase tracking-widest">Dirección de Recursos
                        Energéticos</p>
                </div>
            </div>
            <button onclick="window.open('https://wa.me/?text=' + encodeURIComponent(window.location.href), '_blank')"
                class="bg-primary text-white p-2 rounded-full shadow-lg shadow-primary/20">
                <span class="material-symbols-outlined">share</span>
            </button>
        </div>
    </header>
    <main class="max-w-5xl mx-auto space-y-8 pb-32">
        <section class="relative w-full overflow-hidden">
            <div id="carousel"
                class="relative max-w-5xl mx-auto aspect-[4/3] md:aspect-[21/9] overflow-hidden border border-slate-100 shadow-sm">
                <img id="carousel-img" src="./foto_1.jpg" alt="Vista del río"
                    class="w-full h-full object-cover transition-opacity duration-700"
                    style="opacity:1; border-radius:0;" />
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent pointer-events-none"></div>
                <div id="carousel-indicators" class="absolute bottom-6 left-1/2 -translate-x-1/2 flex gap-2 z-10">
                    <button class="w-8 h-1.5 rounded-full transition-all" data-idx="0"
                        style="background: #fff;"></button>
                    <button class="w-2 h-1.5 rounded-full transition-all" data-idx="1" style="background: #fff4;">
                    </button>
                    <button class="w-2 h-1.5 rounded-full transition-all" data-idx="2" style="background: #fff4;">
                    </button>
                    <button class="w-2 h-1.5 rounded-full transition-all" data-idx="3" style="background: #fff4;">
                    </button>
                </div>
                <script>
                        (function () {
                            const images = [
                                './foto_1.jpg',
                                './foto_2.jpg',
                                './foto_3.jpg',
                                './foto_4.jpg'
                            ];
                            let idx = 0;
                            const img = document.getElementById('carousel-img');
                            const indicators = document.querySelectorAll('#carousel-indicators button');
                            let interval = null;
                            function show(idxToShow) {
                                idx = idxToShow;
                                img.style.opacity = 0;
                                setTimeout(() => {
                                    img.src = images[idx];
                                    img.style.opacity = 1;
                                }, 400);
                                indicators.forEach((el, i) => {
                                    if (i === idx) {
                                        el.style.background = '#fff';
                                        el.classList.add('w-8');
                                        el.classList.remove('w-2');
                                    } else {
                                        el.style.background = '#fff4';
                                        el.classList.remove('w-8');
                                        el.classList.add('w-2');
                                    }
                                });
                            }
                            indicators.forEach((el, i) => {
                                el.addEventListener('click', () => {
                                    clearInterval(interval);
                                    show(i);
                                    interval = setInterval(next, 3500);
                                });
                            });
                            function next() {
                                show((idx + 1) % images.length);
                            }
                            show(0);
                            interval = setInterval(next, 3500);
                        })();
                </script>
            </div>
            <div class="absolute top-6 right-6">
                <span
                    class="bg-green-500 text-white px-4 py-1.5 rounded-full text-xs font-bold uppercase flex items-center gap-2 shadow-xl border border-white/20">
                    <span class="size-2 bg-white rounded-full animate-pulse"></span>
                    Seguro para Baño
                </span>
            </div>
        </section>
        <section class="px-4">
            <div class="aspect-video w-full rounded-2xl overflow-hidden my-8">
                <iframe width="100%" height="100%" src="https://www.youtube.com/embed/5eAO3eujEwg" title="YouTube video"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    allowfullscreen class="w-full h-full"></iframe>
            </div>
        </section>
        <section class="px-4 scroll-mt-24" id="caudal">
            <div class="bg-[#87CEEB] rounded-2xl p-8 shadow-sm border border-slate-100 text-center">
                <h2 class="font-extrabold uppercase tracking-widest text-sm mb-6 text-sky-900 drop-shadow">Estado Actual
                    del Río</h2>
                <div class="flex flex-col items-center">
                    <div class="relative flex items-center justify-center">
                        <div
                            class="size-48 rounded-full border-[12px] border-white flex items-center justify-center relative bg-white/20">
                            <!-- SVG Dinámico para el progreso -->
                            <svg class="absolute inset-0 size-full -rotate-90" viewBox="0 0 168 168">
                                <circle cx="84" cy="84" r="78" fill="none"
                                    class="stroke-sky-900 transition-all duration-1000 ease-out" stroke-width="12"
                                    stroke-dasharray="<?php echo $circumference; ?>"
                                    stroke-dashoffset="<?php echo $dashoffset; ?>" stroke-linecap="round" />
                            </svg>

                            <div class="flex flex-col items-center relative z-10">
                                <span
                                    class="text-4xl font-black text-sky-900 drop-shadow"><?php echo $caudal; ?>%</span>
                                <span class="text-xs font-bold text-sky-900/80 uppercase">Caudal</span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-8 w-full max-w-sm flex flex-col gap-3">
                        <div class="bg-white/30 p-4 rounded-xl w-full text-center">
                            <p class="text-[10px] font-bold text-sky-900/80 uppercase mb-1">Nivel</p>
                            <p class="text-lg font-bold text-sky-900 drop-shadow">
                                <?php echo $nivelText; ?>
                            </p>
                        </div>

                        <!-- Listado de últimos cambios -->
                        <div id="historial" class="bg-white/20 p-4 rounded-xl w-full">
                            <p class="text-[10px] font-bold text-sky-900/80 uppercase mb-3 text-center">Últimos Cambios
                            </p>
                            <div class="space-y-2">
                                <?php foreach ($recentChanges as $index => $change): ?>
                                    <div
                                        class="flex items-center justify-between text-xs border-b border-sky-900/10 pb-1 last:border-0 last:pb-0">
                                        <span class="text-sky-900/70 font-medium">
                                            <?php echo $change['date']; ?> <span class="mx-1">•</span>
                                            <?php echo $change['time']; ?> hs
                                        </span>
                                        <span class="text-sky-900 font-bold"><?php echo $change['status']; ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="px-4 scroll-mt-24" id="clima">
            <div
                class="<?php echo $weatherBg; ?> text-white rounded-3xl p-10 overflow-hidden relative transition-colors duration-500">
                <div class="absolute -top-6 -right-6 p-8 opacity-20">
                    <span class="material-symbols-outlined !text-[150px] text-white"><?php echo $weatherIcon; ?></span>
                </div>
                <h2 class="font-extrabold uppercase tracking-widest text-base mb-10 text-white drop-shadow">Clima en el
                    Área</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-10 relative z-10">
                    <div class="flex items-center gap-6">
                        <div class="size-20 bg-white/20 rounded-2xl flex items-center justify-center">
                            <span class="material-symbols-outlined text-white text-5xl">device_thermostat</span>
                        </div>
                        <div>
                            <p class="text-4xl font-black text-white drop-shadow">
                                <?php echo $temperature; ?>°C
                            </p>
                            <p class="text-sm font-bold text-white/90">Temperatura Actual</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-6">
                        <div class="size-20 bg-white/20 rounded-2xl flex items-center justify-center">
                            <span class="material-symbols-outlined text-white text-5xl">humidity_percentage</span>
                        </div>
                        <div>
                            <p class="text-4xl font-black text-white drop-shadow">
                                <?php echo $humidity; ?>%
                            </p>
                            <p class="text-sm font-bold text-white/90">Humedad Ambiente</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-6">
                        <div class="size-20 bg-white/20 rounded-2xl flex items-center justify-center">
                            <span class="material-symbols-outlined text-white text-5xl">air</span>
                        </div>
                        <div>
                            <p class="text-4xl font-black text-white drop-shadow">
                                <?php echo $windSpeed; ?> <span class="text-lg">km/h</span>
                            </p>
                            <p class="text-sm font-bold text-white/90">Viento Norte</p>
                        </div>
                    </div>
                </div>
                <div class="mt-8 pt-6 border-t border-white/20 flex items-center justify-between gap-6">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-white/80 text-3xl">sunny</span>
                        <p class="text-white/90 font-bold text-xl">Salida: <span
                                class="text-white"><?php echo $sunriseTime; ?> hs</span></p>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-white/80 text-3xl">bedtime</span>
                        <p class="text-white/90 font-bold text-xl">Puesta: <span
                                class="text-white"><?php echo $sunsetTime; ?> hs</span></p>
                    </div>
                </div>
            </div>
        </section>
        <section class="px-4">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-primary font-extrabold uppercase tracking-widest text-sm">Recomendaciones para Turistas
                </h2>
            </div>
            <div class="space-y-4">
                <div
                    class="bg-white dark:bg-slate-900 p-5 rounded-2xl border border-slate-100 dark:border-slate-800 flex gap-4">
                    <div class="size-12 bg-primary/10 rounded-xl flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-primary">health_and_safety</span>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-800 dark:text-white mb-1">Uso de Guardavidas</h4>
                        <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed">Báñese únicamente en las
                            zonas delimitadas por boyas y bajo supervisión.</p>
                    </div>
                </div>
                <div
                    class="bg-white dark:bg-slate-900 p-5 rounded-2xl border border-slate-100 dark:border-slate-800 flex gap-4">
                    <div class="size-12 bg-primary/10 rounded-xl flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-primary">eco</span>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-800 dark:text-white mb-1">Cuidado del Entorno</h4>
                        <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed">No arroje residuos al río.
                            Utilice los cestos diferenciados en la costa.</p>
                    </div>
                </div>
                <div
                    class="bg-white dark:bg-slate-900 p-5 rounded-2xl border border-slate-100 dark:border-slate-800 flex gap-4">
                    <div class="size-12 bg-primary/10 rounded-xl flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-primary">light_mode</span>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-800 dark:text-white mb-1">Protección Solar</h4>
                        <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed">Evite la exposición
                            directa entre las 11:00 y las 16:00 horas.</p>
                    </div>
                </div>
            </div>
        </section>
        <section class="px-4 scroll-mt-24" id="mapa">
            <div class="bg-[#ff8200] rounded-3xl p-5 shadow-sm border border-white/20 text-white">
                <h2 class="text-white font-extrabold uppercase tracking-widest text-sm mb-6 drop-shadow">Ubicación y
                    Acceso</h2>
                <div
                    class="aspect-[3/4] w-full rounded-xl bg-white/20 mb-6 flex items-center justify-center overflow-hidden border border-white/20">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d5307.41073392544!2d-68.71321014068732!3d-31.485314534038586!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9681450031056b01%3A0xaa48e807cd9dee77!2sR%C3%ADo%20San%20Juan!5e1!3m2!1ses!2sar!4v1769490447238!5m2!1ses!2sar"
                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade" class="w-full h-full"></iframe>
                </div>
                <!-- Botón "Cómo llegar" simple y estilizado -->
                <button onclick="window.open('https://maps.app.goo.gl/5Q1M3yGwXjBHFamg7', '_blank')"
                    class="w-full bg-white text-primary hover:bg-slate-50 py-4 px-6 rounded-xl flex items-center justify-center gap-3 font-extrabold transition-all active:scale-[0.98] shadow-lg shadow-black/10">
                    <span class="material-symbols-outlined">map</span>
                    Cómo llegar en Google Maps
                </button>
            </div>
        </section>
    </main>
    <nav
        class="fixed bottom-0 left-0 right-0 bg-white/95 dark:bg-slate-900/95 backdrop-blur-xl border-t border-slate-200 dark:border-slate-800 px-8 py-4 flex justify-between items-center z-50">
        <a href="#" class="flex flex-col items-center gap-1 text-slate-400 hover:text-primary transition-colors">
            <span class="material-symbols-outlined text-[28px] font-bold">home</span>
            <span class="text-[10px] font-extrabold uppercase tracking-tighter">Inicio</span>
        </a>
        <a href="#caudal" class="flex flex-col items-center gap-1 text-slate-400 hover:text-primary transition-colors">
            <span class="material-symbols-outlined text-[28px]">water_drop</span>
            <span class="text-[10px] font-bold uppercase tracking-tighter">Caudal</span>
        </a>
        <a href="#clima" class="flex flex-col items-center gap-1 text-slate-400 hover:text-primary transition-colors">
            <span class="material-symbols-outlined text-[28px]">partly_cloudy_day</span>
            <span class="text-[10px] font-bold uppercase tracking-tighter">Clima</span>
        </a>
        <a href="#mapa" class="flex flex-col items-center gap-1 text-slate-400 hover:text-primary transition-colors">
            <span class="material-symbols-outlined text-[28px]">map</span>
            <span class="text-[10px] font-bold uppercase tracking-tighter">Mapa</span>
        </a>
    </nav>

</body>

</html>