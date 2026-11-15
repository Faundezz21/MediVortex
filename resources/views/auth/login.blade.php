<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediVortex - Iniciar Sesión</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="icon" type="image/svg+xml" href="{{ asset('images/favicon.svg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;600&display=swap" rel="stylesheet">

    <script>
        (function () {
            try {
                var saved = localStorage.getItem('das-theme');
                var prefers = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
                if (saved === 'dark' || (!saved && prefers)) document.documentElement.classList.add('dark');
            } catch (e) {}
        })();
    </script>
    <link rel="stylesheet" href="{{ asset('css/dark-mode.css') }}?v={{ @filemtime(public_path('css/dark-mode.css')) }}">

    <!-- sweetalert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    .swal2-container {
        z-index: 9999999 !important;
    }
    .swal2-popup {
        font-family: 'Plus Jakarta Sans', sans-serif !important;
        border-radius: 18px !important;
    }
    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    .mono {
        font-family: 'JetBrains Mono', monospace;
    }
    input::-ms-reveal,
    input::-ms-clear {
        display: none;
    }

    input[type="password"]::-webkit-credentials-auto-fill-button,
    input[type="password"]::-webkit-contacts-auto-fill-button {
        visibility: hidden;
        display: none !important;
        pointer-events: none;
        position: absolute;
        right: 0;
    }

    /* panel de marca: tinta violeta con grilla tipo plano de bodega */
    .mv-hero {
        background-color: #120F24;
        background-image:
            radial-gradient(70% 55% at 15% 10%, rgba(124, 58, 237, 0.55), transparent 70%),
            radial-gradient(60% 50% at 95% 95%, rgba(91, 33, 182, 0.45), transparent 70%),
            linear-gradient(rgba(255, 255, 255, 0.045) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255, 255, 255, 0.045) 1px, transparent 1px);
        background-size: auto, auto, 32px 32px, 32px 32px;
    }

    /* ruta animada entre los nodos del mapa */
    .mv-route {
        stroke-dasharray: 6 8;
        animation: mv-dash 1.6s linear infinite;
    }
    @keyframes mv-dash {
        to { stroke-dashoffset: -28; }
    }
    @media (prefers-reduced-motion: reduce) {
        .mv-route { animation: none; }
    }
</style>
</head>

<body class="min-h-screen flex items-center justify-center p-4 sm:p-6 lg:p-8 bg-[#F6F5FB]"
    style="background-image: radial-gradient(circle at 100% 0, rgba(124,58,237,0.10), transparent 40%), radial-gradient(circle at 0 100%, rgba(124,58,237,0.08), transparent 40%);">

    <div
        class="w-full max-w-md lg:max-w-6xl bg-white rounded-[28px] shadow-[0_30px_80px_-30px_rgba(46,16,101,0.45)] ring-1 ring-slate-200/70 flex flex-col lg:flex-row overflow-hidden lg:min-h-[78vh]">

        <!-- en movil se muestra una franja de marca -->
        <div class="mv-hero block lg:hidden w-full px-6 py-7">
            <x-brand-logo size="md" />
        </div>

        <!-- panel izquierdo, solo en escritorio -->
        <div class="mv-hero hidden lg:flex w-[46%] relative flex-col justify-between p-12 text-white">

            <x-brand-logo size="lg" />

            <div class="my-10">
                <span class="inline-flex items-center gap-2 rounded-full bg-white/10 ring-1 ring-white/15 px-3 py-1 text-[11px] font-semibold tracking-wide text-brand-200">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                    Plataforma de gestión logística
                </span>
                <h1 class="mt-5 text-[32px] xl:text-[40px] font-extrabold leading-[1.1] tracking-tight text-balance">
                    Tu bodega, del muelle al cliente, <span class="bg-gradient-to-r from-brand-300 to-fuchsia-300 bg-clip-text text-transparent">en un solo flujo.</span>
                </h1>
                <p class="mt-4 max-w-md text-[15px] leading-relaxed text-white/65">
                    Recibe mercancía, ubícala en pasillos y estanterías, prepara pedidos de sucursales y sigue cada lote de punta a punta.
                </p>
            </div>

            <!-- mini mapa de la red de distribucion -->
            <div class="relative rounded-2xl bg-white/[0.04] ring-1 ring-white/10 p-5">
                <svg viewBox="0 0 360 120" class="w-full h-auto" fill="none" aria-hidden="true">
                    <path class="mv-route" d="M40 84 C 110 84, 110 36, 180 36 S 250 84, 320 84" stroke="#A78BFA" stroke-width="2" stroke-linecap="round" />
                    <g>
                        <circle cx="40" cy="84" r="16" fill="#7C3AED" fill-opacity="0.25" />
                        <circle cx="40" cy="84" r="7" fill="#A78BFA" />
                        <circle cx="180" cy="36" r="18" fill="#7C3AED" fill-opacity="0.3" />
                        <rect x="171" y="27" width="18" height="18" rx="4" fill="#C4B5FD" />
                        <circle cx="320" cy="84" r="16" fill="#7C3AED" fill-opacity="0.25" />
                        <circle cx="320" cy="84" r="7" fill="#A78BFA" />
                    </g>
                    <text x="40" y="114" text-anchor="middle" fill="rgba(255,255,255,0.55)" font-size="11" font-family="Plus Jakarta Sans, sans-serif">Proveedor</text>
                    <text x="180" y="72" text-anchor="middle" fill="rgba(255,255,255,0.8)" font-size="11" font-weight="700" font-family="Plus Jakarta Sans, sans-serif">Centro de Distribución</text>
                    <text x="320" y="114" text-anchor="middle" fill="rgba(255,255,255,0.55)" font-size="11" font-family="Plus Jakarta Sans, sans-serif">Sucursal</text>
                </svg>

                <div class="mt-4 grid grid-cols-3 gap-3">
                    <div class="rounded-xl bg-white/[0.05] px-3 py-2.5">
                        <p class="mono text-[18px] font-semibold text-white">FEFO</p>
                        <p class="text-[11px] text-white/50 mt-0.5">Rotación por lote</p>
                    </div>
                    <div class="rounded-xl bg-white/[0.05] px-3 py-2.5">
                        <p class="mono text-[18px] font-semibold text-white">QR</p>
                        <p class="text-[11px] text-white/50 mt-0.5">Ubicación al instante</p>
                    </div>
                    <div class="rounded-xl bg-white/[0.05] px-3 py-2.5">
                        <p class="mono text-[18px] font-semibold text-white">3D</p>
                        <p class="text-[11px] text-white/50 mt-0.5">Mapa de bodega</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- panel derecho con el formulario de login -->
        <div class="w-full lg:w-[54%] flex flex-col justify-center items-center p-6 sm:p-10 lg:p-16 relative">
            <div class="w-full max-w-md">

                <p class="text-[12px] font-bold uppercase tracking-[0.18em] text-brand-600 mb-3 text-center lg:text-left">Acceso al sistema</p>
                <h2 class="text-[28px] sm:text-[32px] font-extrabold tracking-tight text-slate-900 mb-2 text-center lg:text-left">
                    Bienvenido de nuevo
                </h2>
                <p class="text-sm sm:text-base text-slate-500 mb-7 sm:mb-9 text-center lg:text-left">
                    Ingresa con tu cuenta para continuar en <span class="font-semibold text-slate-800">MediVortex</span>
                </p>

                <form method="POST" action="{{ route('login') }}" class="space-y-4 sm:space-y-5">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">
                            Correo electrónico
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                class="block w-full pl-10 pr-3 py-2.5 sm:py-3 bg-white border border-slate-200 rounded-xl focus:ring-brand-500 focus:border-brand-500 text-slate-900 placeholder-slate-400 text-sm sm:text-base @error('email') border-red-500 @enderror"
                                placeholder="admin@medivortex.cl">
                        </div>
                        @error('email')
                            <span class="text-sm text-red-600 mt-1 font-medium block">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">
                            Contraseña
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                    </path>
                                </svg>
                            </div>
                            <input type="password" name="password" id="login_password" required minlength="8"
                                maxlength="64" autocomplete="current-password"
                                oninvalid="this.setCustomValidity('La contraseña debe tener entre 8 y 64 caracteres.')"
                                oninput="this.setCustomValidity('')"
                                class="block w-full pl-10 pr-12 py-2.5 sm:py-3 bg-white border border-slate-200 rounded-xl focus:ring-brand-500 focus:border-brand-500 text-slate-900 placeholder-slate-400 text-sm sm:text-base @error('password') border-red-500 @enderror"
                                placeholder="Mínimo 8 caracteres">
                            <button type="button" id="btn_toggle_password" onclick="togglePassword()"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-700 transition-colors"
                                aria-label="Mostrar u ocultar contraseña" tabindex="-1">
                                <svg id="eye_open" class="h-5 w-5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                    </path>
                                </svg>
                                <svg id="eye_closed" class="h-5 w-5 hidden" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21">
                                    </path>
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <span class="text-sm text-red-600 mt-1 font-medium block">
                                {{ $message }}
                            </span>
                        @enderror
                        <div id="caps_lock_warning" class="hidden mt-1.5 flex items-center gap-1.5 text-xs font-semibold text-amber-600">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            <span>Bloq Mayús (Caps Lock) está activado</span>
                        </div>
                        <div class="flex items-center justify-between mt-3">
                            <label class="inline-flex items-center gap-2 cursor-pointer select-none">
                                <input type="checkbox" name="remember" value="1" class="w-4 h-4 rounded border-slate-300 text-brand-600 focus:ring-brand-500">
                                <span class="text-xs sm:text-sm text-slate-600 font-medium">Recordarme</span>
                            </label>
                            <a href="#" onclick="abrirModalRecuperacion(event)"
                                class="text-xs sm:text-sm text-brand-600 hover:text-brand-800 font-medium">
                                ¿Olvidó su contraseña?
                            </a>
                        </div>
                    </div>

                    <button type="submit" id="btn_submit_login"
                        class="w-full flex justify-center items-center gap-2 py-3.5 px-4 rounded-xl shadow-[0_12px_24px_-10px_rgba(124,58,237,0.7)] text-sm font-bold text-white bg-gradient-to-r from-brand-600 to-brand-800 hover:from-brand-700 hover:to-brand-900 transition-all cursor-pointer disabled:opacity-70 disabled:cursor-not-allowed">
                        <span id="btn_submit_text">Iniciar sesión</span>
                        <svg id="btn_submit_arrow" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                        <svg id="btn_submit_spinner" class="hidden w-4 h-4 animate-spin text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                        </svg>
                    </button>
                </form>

                <p class="mt-6 sm:mt-8 text-center text-xs sm:text-sm text-slate-600">
                    ¿No tiene una cuenta?
                    <button type="button" onclick="contactarAdministrador()"
                        class="font-semibold text-brand-700 hover:text-brand-900 underline-offset-2 hover:underline focus:outline-none cursor-pointer">
                        Contacte al administrador
                    </button>
                </p>

            </div>

            <div class="mt-8 lg:absolute lg:bottom-8 w-full text-center">
                <p class="text-[11px] sm:text-xs text-slate-400">
                    &copy; {{ date('Y') }} MediVortex · Proyecto demostrativo de gestión logística.
                </p>
                <p class="mt-1 text-[11px] sm:text-xs text-slate-400">
                    Desarrollado por
                    <a href="https://github.com/Faundezz21" target="_blank" rel="noopener noreferrer"
                        class="font-semibold text-brand-600 hover:text-brand-800 hover:underline underline-offset-2">Faundezz21</a>
                </p>
            </div>
        </div>
    </div>

    <!-- modal de recuperar contrasena -->
    <div id="forgotPasswordModal"
        class="hidden fixed inset-0 z-50 overflow-y-auto bg-slate-900/70 backdrop-blur-sm flex items-center justify-center p-3 sm:p-4 transition-all"
        onclick="if(event.target === this) cerrarModalRecuperacion()">
        <div class="bg-white rounded-2xl shadow-2xl border border-slate-200 w-full max-w-md max-h-[92vh] flex flex-col overflow-hidden my-auto transform transition-all">
            <div class="px-6 py-5 bg-gradient-to-r from-slate-900 to-brand-950 text-white flex items-center justify-between shrink-0">
                <div class="flex items-center gap-3.5">
                    <div class="w-11 h-11 rounded-xl bg-brand-500/20 border border-brand-400/30 flex items-center justify-center text-brand-300 shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base sm:text-lg font-bold text-white leading-tight">Recuperar Contraseña</h3>
                        <p class="text-xs text-brand-200/80 mt-0.5">Solicitud interna de restablecimiento de clave</p>
                    </div>
                </div>
                <button type="button" onclick="cerrarModalRecuperacion()"
                    class="text-slate-400 hover:text-white p-1.5 rounded-xl bg-white/10 hover:bg-white/20 transition-colors cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- cuerpo del modal (formulario) -->
            <div id="forgotFormView" class="p-6 space-y-5 overflow-y-auto flex-1">
                <!-- explicacion del flujo en 3 pasos -->
                <div class="bg-slate-50 border border-slate-200/80 rounded-xl p-3.5 space-y-2">
                    <p class="text-[11px] font-bold uppercase tracking-wider text-slate-500">¿Cómo funciona?</p>
                    <div class="space-y-1.5 text-xs text-slate-600">
                        <div class="flex items-start gap-2">
                            <span class="w-4 h-4 rounded-full bg-brand-100 text-brand-700 font-bold text-[10px] flex items-center justify-center shrink-0 mt-0.5">1</span>
                            <span>Ingrese el correo institucional registrado en su cuenta.</span>
                        </div>
                        <div class="flex items-start gap-2">
                            <span class="w-4 h-4 rounded-full bg-brand-100 text-brand-700 font-bold text-[10px] flex items-center justify-center shrink-0 mt-0.5">2</span>
                            <span>El <strong>Administrador</strong> recibirá una alerta inmediata en el panel de Usuarios.</span>
                        </div>
                        <div class="flex items-start gap-2">
                            <span class="w-4 h-4 rounded-full bg-brand-100 text-brand-700 font-bold text-[10px] flex items-center justify-center shrink-0 mt-0.5">3</span>
                            <span>Se le asignará una nueva contraseña segura (mínimo 8 caracteres).</span>
                        </div>
                    </div>
                </div>

                <form id="forgotPasswordForm" onsubmit="enviarSolicitudRecuperacion(event)" class="space-y-4" novalidate>
                    <div>
                        <label for="recovery_email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Correo Electrónico Registrado <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                            <input type="email" id="recovery_email" required placeholder="ejemplo@medivortex.cl"
                                class="w-full pl-10 pr-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-600 transition-all">
                        </div>
                        <div id="recovery_error_box" class="hidden mt-2 p-2.5 rounded-lg bg-red-50 border border-red-200 flex items-start gap-2 text-xs text-red-700 font-medium">
                            <svg class="w-4 h-4 text-red-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span id="recovery_error_text"></span>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-2.5 pt-2 border-t border-slate-100">
                        <button type="button" onclick="cerrarModalRecuperacion()"
                            class="px-4 py-2.5 rounded-xl text-xs font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 transition-colors cursor-pointer">
                            Cancelar
                        </button>
                        <button type="submit" id="btn_recovery_submit"
                            class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-brand-700 hover:bg-brand-800 shadow-sm transition-all cursor-pointer disabled:opacity-60">
                            <span id="btn_recovery_text">Enviar solicitud</span>
                            <svg id="btn_recovery_spinner" class="hidden w-4 h-4 animate-spin text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>

            <!-- vista de exito -->
            <div id="forgotSuccessView" class="hidden p-6 text-center space-y-4">
                <div class="w-14 h-14 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-600 flex items-center justify-center mx-auto shadow-xs">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div>
                    <h4 class="text-base font-extrabold text-slate-900">¡Solicitud registrada con éxito!</h4>
                    <p class="text-xs text-slate-600 mt-1 leading-relaxed">
                        Notificamos al administrador sobre la cuenta <strong id="recovery_success_email" class="text-slate-800"></strong>. Pronto se actualizará su clave de acceso.
                    </p>
                </div>
                <div class="pt-2">
                    <button type="button" onclick="cerrarModalRecuperacion()"
                        class="w-full py-2.5 px-4 rounded-xl text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 transition-colors cursor-pointer shadow-sm">
                        Entendido
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- modal de contacto con el administrador -->
    <div id="contactAdminModal"
        class="hidden fixed inset-0 z-50 overflow-y-auto bg-slate-900/70 backdrop-blur-sm flex items-center justify-center p-3 sm:p-4 transition-all"
        onclick="if(event.target === this) cerrarModalContacto()">
        <div class="bg-white rounded-2xl shadow-2xl border border-slate-200 w-full max-w-md max-h-[92vh] flex flex-col overflow-hidden my-auto transform transition-all">
            <div class="px-6 py-5 bg-gradient-to-r from-slate-900 to-brand-950 text-white flex items-center justify-between shrink-0">
                <div class="flex items-center gap-3.5">
                    <div class="w-11 h-11 rounded-xl bg-teal-500/20 border border-teal-400/30 flex items-center justify-center text-teal-300 shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base sm:text-lg font-bold text-white leading-tight">Solicitar Cuenta de Acceso</h3>
                        <p class="text-xs text-brand-200/80 mt-0.5">Administración Central MediVortex</p>
                    </div>
                </div>
                <button type="button" onclick="cerrarModalContacto()"
                    class="text-slate-400 hover:text-white p-1.5 rounded-xl bg-white/10 hover:bg-white/20 transition-colors cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <div class="p-6 space-y-4 overflow-y-auto flex-1">
                <p class="text-xs text-slate-600 leading-relaxed">
                    El acceso a la plataforma es exclusivo para personal autorizado de la Central de Abastecimiento y clientes de la red de distribución. Comuníquese con el administrador para habilitar su perfil:
                </p>

                <!-- correo con boton para copiarlo -->
                <div class="bg-slate-50 border border-slate-200 rounded-xl p-3.5 flex items-center justify-between gap-2">
                    <div class="min-w-0">
                        <span class="block text-[10px] font-bold uppercase tracking-wider text-slate-400">Correo de Administración</span>
                        <p id="admin_email_text" class="text-xs sm:text-sm font-bold text-slate-800 truncate mt-0.5">soporte@medivortex.cl</p>
                    </div>
                    <button type="button" onclick="copiarCorreoAdmin()" id="btn_copy_admin_email"
                        class="shrink-0 inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold text-brand-700 bg-brand-50 hover:bg-brand-100 border border-brand-200 transition-colors cursor-pointer">
                        <svg id="copy_icon_default" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z">
                            </path>
                        </svg>
                        <svg id="copy_icon_check" class="hidden w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span id="copy_btn_label">Copiar</span>
                    </button>
                </div>

                <!-- datos opcionales para armar el correo -->
                <div class="space-y-3 pt-1">
                    <div>
                        <label for="contact_name" class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">
                            Su Nombre y Apellido <span class="text-slate-400 font-normal normal-case">(opcional)</span>
                        </label>
                        <input type="text" id="contact_name" placeholder="Ej. Ana Pérez"
                            class="w-full px-3.5 py-2 bg-white border border-slate-300 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-600">
                    </div>
                    <div>
                        <label for="contact_unit" class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">
                            Cliente / Unidad <span class="text-slate-400 font-normal normal-case">(opcional)</span>
                        </label>
                        <input type="text" id="contact_unit" placeholder="Ej. Sucursal Centro / Bodega"
                            class="w-full px-3.5 py-2 bg-white border border-slate-300 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-600">
                    </div>
                </div>

                <!-- botones de accion -->
                <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-slate-100 shrink-0">
                    <button type="button" onclick="cerrarModalContacto()"
                        class="px-4 py-2.5 rounded-xl text-xs font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 transition-colors cursor-pointer">
                        Cerrar
                    </button>
                    <button type="button" onclick="abrirClienteCorreoAdmin()"
                        class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold text-white bg-brand-700 hover:bg-brand-800 shadow-sm transition-all cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                        Redactar Correo
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // mostrar/ocultar contrasena
        function togglePassword() {
            const input = document.getElementById('login_password');
            const eyeOpen = document.getElementById('eye_open');
            const eyeClosed = document.getElementById('eye_closed');

            if (input.type === 'password') {
                input.type = 'text';
                eyeOpen.classList.add('hidden');
                eyeClosed.classList.remove('hidden');
            } else {
                input.type = 'password';
                eyeOpen.classList.remove('hidden');
                eyeClosed.classList.add('hidden');
            }
        }

        // avisa si el bloqueo de mayusculas esta activado
        const loginPassInput = document.getElementById('login_password');
        const capsWarning = document.getElementById('caps_lock_warning');
        if (loginPassInput && capsWarning) {
            const checkCaps = (e) => {
                if (typeof e.getModifierState === 'function') {
                    capsWarning.classList.toggle('hidden', !e.getModifierState('CapsLock'));
                }
            };
            loginPassInput.addEventListener('keyup', checkCaps);
            loginPassInput.addEventListener('keydown', checkCaps);
            loginPassInput.addEventListener('blur', () => capsWarning.classList.add('hidden'));
        }

        // validaciones basicas en cliente antes de enviar
        document.getElementById('login_password').closest('form').addEventListener('submit', function(e) {
            const email = this.querySelector('input[name="email"]').value.trim();
            const password = document.getElementById('login_password').value;

            if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Correo inválido',
                    text: 'Ingrese un correo electrónico válido.',
                    confirmButtonColor: '#2563eb'
                });
                return;
            }

            if (password.length < 8 || password.length > 64) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Contraseña inválida',
                    text: 'La contraseña debe tener entre 8 y 64 caracteres.',
                    confirmButtonColor: '#2563eb'
                });
                return;
            }

            // estado de carga para evitar doble envio
            const submitBtn = document.getElementById('btn_submit_login');
            const submitText = document.getElementById('btn_submit_text');
            const submitArrow = document.getElementById('btn_submit_arrow');
            const submitSpinner = document.getElementById('btn_submit_spinner');
            if (submitBtn) {
                submitBtn.disabled = true;
                if (submitText) submitText.textContent = 'Verificando acceso...';
                if (submitArrow) submitArrow.classList.add('hidden');
                if (submitSpinner) submitSpinner.classList.remove('hidden');
            }

            // si en 10 segundos no redirige, se vuelve a habilitar el boton
            setTimeout(resetLoginButton, 10000);
        });

        // restaurar estado del boton de inicio de sesion
        function resetLoginButton() {
            const submitBtn = document.getElementById('btn_submit_login');
            const submitText = document.getElementById('btn_submit_text');
            const submitArrow = document.getElementById('btn_submit_arrow');
            const submitSpinner = document.getElementById('btn_submit_spinner');
            if (submitBtn) {
                submitBtn.disabled = false;
                if (submitText) submitText.textContent = 'Iniciar sesión';
                if (submitArrow) submitArrow.classList.remove('hidden');
                if (submitSpinner) submitSpinner.classList.add('hidden');
            }
        }

        // manejar retroceso en el navegador (bfcache / back button)
        window.addEventListener('pageshow', function(event) {
            resetLoginButton();

            // si la pagina fue restaurada desde el historial o bfcache tras iniciar sesion
            const navEntries = (window.performance && typeof performance.getEntriesByType === 'function')
                ? performance.getEntriesByType('navigation')
                : [];
            const isBackForward = event.persisted ||
                (navEntries.length > 0 && navEntries[0].type === 'back_forward') ||
                (window.performance && window.performance.navigation && window.performance.navigation.type === 2);

            if (isBackForward) {
                // se recarga para que el servidor revise la sesion y redirija al modulo que corresponda
                window.location.reload();
            }
        });
        // modal de recuperar contrasena
        function abrirModalRecuperacion(event) {
            if (event) event.preventDefault();
            const modal = document.getElementById('forgotPasswordModal');
            const formView = document.getElementById('forgotFormView');
            const successView = document.getElementById('forgotSuccessView');
            const errorBox = document.getElementById('recovery_error_box');
            const emailInput = document.getElementById('recovery_email');
            const loginEmail = (document.querySelector('input[name="email"]')?.value || '').trim();

            if (formView) formView.classList.remove('hidden');
            if (successView) successView.classList.add('hidden');
            if (errorBox) errorBox.classList.add('hidden');

            if (emailInput) {
                emailInput.value = loginEmail;
                setTimeout(() => emailInput.focus(), 80);
            }

            if (modal) modal.classList.remove('hidden');
        }

        function cerrarModalRecuperacion() {
            const modal = document.getElementById('forgotPasswordModal');
            if (modal) modal.classList.add('hidden');
        }

        async function enviarSolicitudRecuperacion(event) {
            event.preventDefault();
            const emailInput = document.getElementById('recovery_email');
            const errorBox = document.getElementById('recovery_error_box');
            const errorText = document.getElementById('recovery_error_text');
            const submitBtn = document.getElementById('btn_recovery_submit');
            const submitText = document.getElementById('btn_recovery_text');
            const submitSpinner = document.getElementById('btn_recovery_spinner');

            const email = (emailInput?.value || '').trim();

            const mostrarError = (msg) => {
                if (errorText) errorText.textContent = msg;
                if (errorBox) errorBox.classList.remove('hidden');
            };

            if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                mostrarError('Por favor, ingresa un correo electrónico válido.');
                emailInput?.focus();
                return;
            }

            if (errorBox) errorBox.classList.add('hidden');
            if (submitBtn) submitBtn.disabled = true;
            if (submitText) submitText.textContent = 'Enviando...';
            if (submitSpinner) submitSpinner.classList.remove('hidden');

            try {
                const response = await fetch("{{ route('password.request.store') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ email })
                });

                const contentType = response.headers.get('content-type') || '';
                const data = contentType.includes('application/json') ? await response.json() : {};

                if (!response.ok) {
                    if (response.status === 429 || (data.message && data.message.includes('Too Many Attempts'))) {
                        throw new Error('Demasiados intentos. Por favor, espera un minuto antes de reintentar.');
                    }
                    const validationMsg = data.errors?.email?.[0] || data.message || 'El correo electrónico no se encuentra registrado en el sistema.';
                    throw new Error(validationMsg);
                }

                // mostrar vista de exito dentro del modal
                document.getElementById('recovery_success_email').textContent = email;
                document.getElementById('forgotFormView').classList.add('hidden');
                document.getElementById('forgotSuccessView').classList.remove('hidden');
            } catch (err) {
                mostrarError(err.message || 'No se pudo procesar la solicitud.');
            } finally {
                if (submitBtn) submitBtn.disabled = false;
                if (submitText) submitText.textContent = 'Enviar solicitud';
                if (submitSpinner) submitSpinner.classList.add('hidden');
            }
        }

        // modal de contacto con el administrador
        function contactarAdministrador() {
            const modal = document.getElementById('contactAdminModal');
            if (modal) modal.classList.remove('hidden');
        }

        function cerrarModalContacto() {
            const modal = document.getElementById('contactAdminModal');
            if (modal) modal.classList.add('hidden');
        }

        function copiarCorreoAdmin() {
            const email = 'soporte@medivortex.cl';
            const label = document.getElementById('copy_btn_label');
            const iconDefault = document.getElementById('copy_icon_default');
            const iconCheck = document.getElementById('copy_icon_check');

            if (navigator.clipboard) {
                navigator.clipboard.writeText(email);
            }

            if (label) label.textContent = '¡Copiado!';
            if (iconDefault) iconDefault.classList.add('hidden');
            if (iconCheck) iconCheck.classList.remove('hidden');

            setTimeout(() => {
                if (label) label.textContent = 'Copiar';
                if (iconDefault) iconDefault.classList.remove('hidden');
                if (iconCheck) iconCheck.classList.add('hidden');
            }, 2200);
        }

        function abrirClienteCorreoAdmin() {
            const nombre = (document.getElementById('contact_name')?.value || '').trim();
            const unidad = (document.getElementById('contact_unit')?.value || '').trim();

            const subject = encodeURIComponent('Solicitud de Creación de Cuenta - MediVortex');
            let bodyLines = [
                'Estimado/a Administrador/a de MediVortex,',
                '',
                'Junto con saludar, solicito la creación y habilitación de una cuenta de acceso en la plataforma.',
            ];

            if (nombre) bodyLines.push(`- Nombre: ${nombre}`);
            if (unidad) bodyLines.push(`- Cliente / Unidad: ${unidad}`);

            bodyLines.push('', 'Quedo atento/a a sus comentarios.', 'Saludos cordiales.');

            const body = encodeURIComponent(bodyLines.join('\n'));
            window.location.href = `mailto:soporte@medivortex.cl?subject=${subject}&body=${body}`;
        }

        // cerrar modales con tecla escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                cerrarModalRecuperacion();
                cerrarModalContacto();
            }
        });
    </script>
<button type="button" onclick="toggleTheme()" class="theme-toggle login-theme-toggle cursor-pointer"
        title="Cambiar modo claro / oscuro" aria-label="Cambiar modo claro / oscuro">
        <svg class="theme-icon-moon w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
        </svg>
        <svg class="theme-icon-sun w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
        </svg>
    </button>
    <script>
        function toggleTheme() {
            const isDark = document.documentElement.classList.toggle('dark');
            try { localStorage.setItem('das-theme', isDark ? 'dark' : 'light'); } catch (e) {}
        }
    </script>
</body>

</html>
