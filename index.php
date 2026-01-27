<!DOCTYPE html>
<html class="light" lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Información Completa del Balneario Rio Las Moras</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
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
    <header class="sticky top-0 z-50 bg-white/90 dark:bg-slate-900/90 backdrop-blur-md border-b border-slate-200 dark:border-slate-800 px-4 py-3">
        <div class="max-w-5xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="https://sanjuan.tur.ar/" class="size-10 flex items-center justify-center rounded-full bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300" title="Volver">
                    <span class="material-symbols-outlined">arrow_back</span>
                </a>
                <div>
                    <h1 class="font-extrabold text-lg tracking-tight">Balneario Rio Las Moras</h1>
                    <p class="text-[10px] text-primary font-bold uppercase tracking-widest">Dirección de Recursos Energéticos</p>
                </div>
            </div>
            <button class="bg-primary text-white p-2 rounded-full shadow-lg shadow-primary/20">
                <span class="material-symbols-outlined">share</span>
            </button>
        </div>
    </header>
    <main class="max-w-5xl mx-auto space-y-8 pb-32">
        <section class="relative w-full overflow-hidden">
            <div id="carousel" class="relative max-w-5xl mx-auto aspect-[4/3] md:aspect-[21/9] overflow-hidden border border-slate-100 shadow-sm">
                <img id="carousel-img" src="./foto_1.jpg" alt="Vista del río" class="w-full h-full object-cover transition-opacity duration-700" style="opacity:1; border-radius:0;" />
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent pointer-events-none"></div>
                <div id="carousel-indicators" class="absolute bottom-6 left-1/2 -translate-x-1/2 flex gap-2 z-10">
                    <button class="w-8 h-1.5 rounded-full transition-all" data-idx="0" style="background: #fff;"></button>
                    <button class="w-2 h-1.5 rounded-full transition-all" data-idx="1" style="background: #fff4;"> </button>
                    <button class="w-2 h-1.5 rounded-full transition-all" data-idx="2" style="background: #fff4;"> </button>
                    <button class="w-2 h-1.5 rounded-full transition-all" data-idx="3" style="background: #fff4;"> </button>
                </div>
                <script>
                (function() {
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
                <span class="bg-green-500 text-white px-4 py-1.5 rounded-full text-xs font-bold uppercase flex items-center gap-2 shadow-xl border border-white/20">
                    <span class="size-2 bg-white rounded-full animate-pulse"></span>
                    Seguro para Baño
                </span>
            </div>
        </section>
                <section class="px-4">
                    <div class="aspect-video w-full rounded-2xl overflow-hidden my-8">
                        <iframe width="100%" height="100%" src="https://www.youtube.com/embed/5eAO3eujEwg" title="YouTube video" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen class="w-full h-full"></iframe>
                    </div>
                </section>
        <section class="px-4">
            <div class="bg-[#87CEEB] rounded-2xl p-8 shadow-sm border border-slate-100 text-center">
                <h2 class="font-extrabold uppercase tracking-widest text-sm mb-6 text-sky-900 drop-shadow">Estado Actual del Río</h2>
                <div class="flex flex-col items-center">
                    <div class="relative flex items-center justify-center">
                        <div class="size-48 rounded-full border-[12px] border-white flex items-center justify-center relative bg-white/20">
                            <div class="absolute inset-0 rounded-full border-[12px] border-sky-900 border-t-transparent -rotate-45"></div>
                            <div class="flex flex-col items-center">
                                <span class="text-5xl font-black text-sky-900 drop-shadow">85%</span>
                                <span class="text-xs font-bold text-sky-900/80 uppercase">Capacidad</span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-8 grid grid-cols-2 gap-4 w-full max-w-sm">
                        <div class="bg-white/30 p-4 rounded-xl">
                            <p class="text-[10px] font-bold text-sky-900/80 uppercase mb-1">Nivel</p>
                            <p class="text-lg font-bold text-sky-900 drop-shadow">Óptimo</p>
                        </div>
                        <div class="bg-white/30 p-4 rounded-xl">
                            <p class="text-[10px] font-bold text-sky-900/80 uppercase mb-1">Flujo</p>
                            <p class="text-lg font-bold text-sky-900 drop-shadow">Tranquilo</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="px-4">
            <div class="bg-[#ff8200] text-white rounded-2xl p-8 overflow-hidden relative">
                <div class="absolute top-0 right-0 p-8 opacity-30">
                    <span class="material-symbols-outlined !text-8xl text-white">sunny</span>
                </div>
                <h2 class="font-extrabold uppercase tracking-widest text-sm mb-8 text-white drop-shadow">Clima en el Área</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative z-10">
                    <div class="flex items-center gap-4">
                        <div class="size-14 bg-white/20 rounded-2xl flex items-center justify-center">
                            <span class="material-symbols-outlined text-white text-3xl">device_thermostat</span>
                        </div>
                        <div>
                            <p class="text-3xl font-black text-white drop-shadow">28°C</p>
                            <p class="text-xs font-medium text-white/80">Temperatura Actual</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="size-14 bg-white/20 rounded-2xl flex items-center justify-center">
                            <span class="material-symbols-outlined text-white text-3xl">humidity_percentage</span>
                        </div>
                        <div>
                            <p class="text-3xl font-black text-white drop-shadow">65%</p>
                            <p class="text-xs font-medium text-white/80">Humedad Ambiente</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="size-14 bg-white/20 rounded-2xl flex items-center justify-center">
                            <span class="material-symbols-outlined text-white text-3xl">air</span>
                        </div>
                        <div>
                            <p class="text-3xl font-black text-white drop-shadow">12 <span class="text-sm">km/h</span></p>
                            <p class="text-xs font-medium text-white/80">Viento Norte</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="px-4">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-primary font-extrabold uppercase tracking-widest text-sm">Recomendaciones para Turistas</h2>
            </div>
            <div class="space-y-4">
                <div class="bg-white dark:bg-slate-900 p-5 rounded-2xl border border-slate-100 dark:border-slate-800 flex gap-4">
                    <div class="size-12 bg-primary/10 rounded-xl flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-primary">health_and_safety</span>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-800 dark:text-white mb-1">Uso de Guardavidas</h4>
                        <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed">Báñese únicamente en las zonas delimitadas por boyas y bajo supervisión.</p>
                    </div>
                </div>
                <div class="bg-white dark:bg-slate-900 p-5 rounded-2xl border border-slate-100 dark:border-slate-800 flex gap-4">
                    <div class="size-12 bg-primary/10 rounded-xl flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-primary">eco</span>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-800 dark:text-white mb-1">Cuidado del Entorno</h4>
                        <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed">No arroje residuos al río. Utilice los cestos diferenciados en la costa.</p>
                    </div>
                </div>
                <div class="bg-white dark:bg-slate-900 p-5 rounded-2xl border border-slate-100 dark:border-slate-800 flex gap-4">
                    <div class="size-12 bg-primary/10 rounded-xl flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-primary">light_mode</span>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-800 dark:text-white mb-1">Protección Solar</h4>
                        <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed">Evite la exposición directa entre las 11:00 y las 16:00 horas.</p>
                    </div>
                </div>
            </div>
        </section>
        <section class="px-4">
            <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-slate-800">
                <h2 class="text-primary font-extrabold uppercase tracking-widest text-sm mb-6">Ubicación y Acceso</h2>
                <div class="aspect-video w-full rounded-xl bg-slate-100 dark:bg-slate-800 mb-6 flex items-center justify-center overflow-hidden border border-slate-200 dark:border-slate-700">
                    <img src="./mapa.jpg" alt="Mapa del Balneario Rio Las Moras" class="w-full h-full object-cover" style="object-fit: cover;" />
                </div>
                <button class="w-full bg-primary hover:bg-[#e67600] text-white py-4 px-6 rounded-xl flex items-center justify-center gap-3 font-extrabold transition-all active:scale-[0.98] shadow-lg shadow-primary/30">
                <a href="https://maps.app.goo.gl/5Q1M3yGwXjBHFamg7" target="_blank" rel="noopener noreferrer" class="w-full bg-primary hover:bg-[#e67600] text-white py-4 px-6 rounded-xl flex items-center justify-center gap-3 font-extrabold transition-all active:scale-[0.98] shadow-lg shadow-primary/30 no-underline">
                    <span class="material-symbols-outlined">map</span>
                    Cómo llegar en Google Maps
                </a>
            </div>
        </section>
    </main>
    <nav class="fixed bottom-0 left-0 right-0 bg-white/95 dark:bg-slate-900/95 backdrop-blur-xl border-t border-slate-200 dark:border-slate-800 px-8 py-4 flex justify-between items-center z-50">
        <div class="flex flex-col items-center gap-1 text-primary">
            <span class="material-symbols-outlined text-[28px] font-bold">home</span>
            <span class="text-[10px] font-extrabold uppercase tracking-tighter">Inicio</span>
        </div>
        <div class="flex flex-col items-center gap-1 text-slate-400">
            <span class="material-symbols-outlined text-[28px]">explore</span>
            <span class="text-[10px] font-bold uppercase tracking-tighter">Explorar</span>
        </div>
        <div class="flex flex-col items-center gap-1 text-slate-400">
            <span class="material-symbols-outlined text-[28px]">notifications</span>
            <span class="text-[10px] font-bold uppercase tracking-tighter">Alertas</span>
        </div>
        <div class="flex flex-col items-center gap-1 text-slate-400">
            <span class="material-symbols-outlined text-[28px]">person</span>
            <span class="text-[10px] font-bold uppercase tracking-tighter">Perfil</span>
        </div>
    </nav>

</body>

</html>