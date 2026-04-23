<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>{{ auth()->user()->empresas->NombreEmpresa }}</title>
    <script defer data-api="/stats/api/event" data-domain="preview.tabler.io" src="/stats/js/script.js"></script>
    <meta name="msapplication-TileColor" content="#0054a6"/>
    <meta name="theme-color" content="#0054a6"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="mobile-web-app-capable" content="yes"/>
    <meta name="HandheldFriendly" content="True"/>
    <meta name="MobileOptimized" content="320"/>
    <link rel="icon" href="./favicon.ico" type="image/x-icon"/>
    <link rel="shortcut icon" href="./favicon.ico" type="image/x-icon"/>
    <meta name="description" content="Tabler comes with tons of well-designed components and features. Start your adventure with Tabler and make your dashboard great again. For free!"/>
    <meta name="canonical" content="https://tabler.io/demo/layout-navbar-overlap.html">
    <meta name="twitter:image:src" content="https://tabler.io/demo/static/og.png">
    <meta name="twitter:site" content="@tabler_ui">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="Tabler: Premium and Open Source dashboard template with responsive and high quality UI.">
    <meta name="twitter:description" content="Tabler comes with tons of well-designed components and features. Start your adventure with Tabler and make your dashboard great again. For free!">
    <meta property="og:image" content="https://tabler.io/demo/static/og.png">
    <meta property="og:image:width" content="1280">
    <meta property="og:image:height" content="640">
    <meta property="og:site_name" content="Tabler">
    <meta property="og:type" content="object">
    <meta property="og:title" content="Tabler: Premium and Open Source dashboard template with responsive and high quality UI.">
    <meta property="og:url" content="https://tabler.io/demo/static/og.png">
    <meta property="og:description" content="Tabler comes with tons of well-designed components and features. Start your adventure with Tabler and make your dashboard great again. For free!">
    <!-- CSS files -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link href={{ asset('dashboard/dist/css/tabler.min.css?1692870762') }} rel="stylesheet"/>
    <link href={{ asset('dashboard/dist/css/tabler-flags.min.css?1692870762') }} rel="stylesheet"/>
    <link href={{ asset('dashboard/dist/css/tabler-payments.min.css?1692870762') }} rel="stylesheet"/>
    <link href={{ asset('dashboard/dist/css/tabler-vendors.min.css?1692870762') }} rel="stylesheet"/>
    <link href={{ asset('dashboard/dist/css/demo.min.css?1692870762') }} rel="stylesheet"/>
    <link href={{ asset('utilidades/css/toasty.css') }} rel="stylesheet"/>

    <style>
      @import url('https://rsms.me/inter/inter.css');
      :root {
      	--tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
      }
      body {
      	font-feature-settings: "cv03", "cv04", "cv11";
      }
    </style>
  </head>
  <body >
    <script src="{{ asset('dashboard/dist/js/demo-theme.min.js?1692870762') }}"></script>

    <div class="modal modal-blur fade" id="modal-crear-caja" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Crear Caja</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <input type="text" class="form-control" id="fechainput" readonly>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn me-auto" data-bs-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="btn-registrar-caja">Registrar</button>
          </div>
        </div>
      </div>
    </div>

    <div id="dashboard-container" style="width: 100%;">
      <div class="page" style="width: 100%;">
        <!-- Navbar -->
        <header class="navbar navbar-expand-md navbar-overlap d-print-none"  data-bs-theme="dark">
          <div class="container-xl">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu" aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
              <a href="." style="display: flex; flex-direction: column; align-items: center;">
                  <div>
                      <!--<img src="data:image/png;base64,{{ auth()->user()->empresas->LogoEmpresa }}" width="200px" height="100px" alt="Logo">-->
                  </div>
                  <div>
                  </div>
              </a>
          </h1>

            <div class="navbar-nav flex-row order-md-last">
              <div class="d-none d-md-flex">
                <a href="?theme=dark" class="nav-link px-0 hide-theme-dark" title="Enable dark mode" data-bs-toggle="tooltip"
        data-bs-placement="bottom">
                  <!-- Download SVG icon from http://tabler-icons.io/i/moon -->
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z" /></svg>
                </a>
                <a href="?theme=light" class="nav-link px-0 hide-theme-light" title="Enable light mode" data-bs-toggle="tooltip"
        data-bs-placement="bottom">
                  <!-- Download SVG icon from http://tabler-icons.io/i/sun -->
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7" /></svg>
                </a>
                <div class="nav-item dropdown d-none d-md-flex me-3">
                  <a href="#" class="nav-link px-0" data-bs-toggle="dropdown" tabindex="-1" aria-label="Show notifications">
                    <!-- Download SVG icon from http://tabler-icons.io/i/bell -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 5a2 2 0 1 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" /><path d="M9 17v1a3 3 0 0 0 6 0v-1" /></svg>
                    <span class="badge bg-red"></span>
                  </a>
                  <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-end dropdown-menu-card">
                    <div class="card">
                      <div class="card-header">
                        <h3 class="card-title">Last updates</h3>
                      </div>
                      <div class="list-group list-group-flush list-group-hoverable">
                        <div class="list-group-item">
                          <div class="row align-items-center">
                            <div class="col-auto"><span class="status-dot status-dot-animated bg-red d-block"></span></div>
                            <div class="col text-truncate">
                              <a href="#" class="text-body d-block">Example 1</a>
                              <div class="d-block text-secondary text-truncate mt-n1">
                                Change deprecated html tags to text decoration classes (#29604)
                              </div>
                            </div>
                            <div class="col-auto">
                              <a href="#" class="list-group-item-actions">
                                <!-- Download SVG icon from http://tabler-icons.io/i/star -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon text-muted" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" /></svg>
                              </a>
                            </div>
                          </div>
                        </div>
                        <div class="list-group-item">
                          <div class="row align-items-center">
                            <div class="col-auto"><span class="status-dot d-block"></span></div>
                            <div class="col text-truncate">
                              <a href="#" class="text-body d-block">Example 2</a>
                              <div class="d-block text-secondary text-truncate mt-n1">
                                justify-content:between ⇒ justify-content:space-between (#29734)
                              </div>
                            </div>
                            <div class="col-auto">
                              <a href="#" class="list-group-item-actions show">
                                <!-- Download SVG icon from http://tabler-icons.io/i/star -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon text-yellow" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" /></svg>
                              </a>
                            </div>
                          </div>
                        </div>
                        <div class="list-group-item">
                          <div class="row align-items-center">
                            <div class="col-auto"><span class="status-dot d-block"></span></div>
                            <div class="col text-truncate">
                              <a href="#" class="text-body d-block">Example 3</a>
                              <div class="d-block text-secondary text-truncate mt-n1">
                                Update change-version.js (#29736)
                              </div>
                            </div>
                            <div class="col-auto">
                              <a href="#" class="list-group-item-actions">
                                <!-- Download SVG icon from http://tabler-icons.io/i/star -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon text-muted" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" /></svg>
                              </a>
                            </div>
                          </div>
                        </div>
                        <div class="list-group-item">
                          <div class="row align-items-center">
                            <div class="col-auto"><span class="status-dot status-dot-animated bg-green d-block"></span></div>
                            <div class="col text-truncate">
                              <a href="#" class="text-body d-block">Example 4</a>
                              <div class="d-block text-secondary text-truncate mt-n1">
                                Regenerate package-lock.json (#29730)
                              </div>
                            </div>
                            <div class="col-auto">
                              <a href="#" class="list-group-item-actions">
                                <!-- Download SVG icon from http://tabler-icons.io/i/star -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon text-muted" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" /></svg>
                              </a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="nav-item dropdown">
                <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                  @auth
                      <div class="user-avatar">
                          <span class="avatar avatar-sm">
                              {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}{{ strtoupper(substr(strstr(auth()->user()->name, ' '), 1, 1)) }}
                          </span>
                      </div>
                  @endauth
                  <div class="d-none d-xl-block ps-2">
                    <div>
                      @auth
                          <p>{{ auth()->user()->name }}</p>
                      @endauth
                    </div>
                  </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" data-bs-theme="light">
                  <a class="dropdown-item" style="color: white" href="{{ route('perfil.show', ['id' => Auth::id()]) }}">Perfil</a>

                  <form method="POST" action="{{ route('logout') }}">
                      @csrf
                      <button type="submit" class="dropdown-item" style="color: white">Cerrar Session</button>
                  </form>
                </div>
              </div>
            </div>
            <div class="collapse navbar-collapse" id="navbar-menu">
              <div class="d-flex flex-column flex-md-row flex-fill align-items-stretch align-items-md-center">
                <ul class="navbar-nav">
                  <li class="nav-item {{ request()->routeIs('admin.Hostal.Hostal') ? 'active' : '' }}">
                      <a class="nav-link dashboard" href="{{ route('admin.Hostal.Hostal') }}">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                          <svg fill="#ffffff" width="256px" height="256px" viewBox="0 0 50 50" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M12.691406 0L11.564453 2.3320312L9 2.6386719L10.949219 4.3613281L10.435547 7L12.691406 5.6816406L14.949219 7L14.435547 4.3613281L16.384766 2.6386719L13.820312 2.3320312L12.691406 0 z M 14.949219 7L10.435547 7L9.3007812 7C6.3307812 7 4 9.3307812 4 12.300781L4 45C4 45.55 4.45 46 5 46L22 46L22 36L28 36L28 46L45 46C45.55 46 46 45.55 46 45L46 12.300781C46 9.3307812 43.669219 7 40.699219 7L39.564453 7L35.050781 7L31.359375 7L26.845703 7L23.154297 7L18.640625 7L14.949219 7 z M 18.640625 7L20.896484 5.6816406L23.154297 7L22.640625 4.3613281L24.589844 2.6386719L22.025391 2.3320312L20.896484 0L19.769531 2.3320312L17.205078 2.6386719L19.154297 4.3613281L18.640625 7 z M 26.845703 7L29.103516 5.6816406L31.359375 7L30.845703 4.3613281L32.794922 2.6386719L30.230469 2.3320312L29.103516 0L27.974609 2.3320312L25.410156 2.6386719L27.359375 4.3613281L26.845703 7 z M 35.050781 7L37.308594 5.6816406L39.564453 7L39.050781 4.3613281L41 2.6386719L38.435547 2.3320312L37.308594 0L36.179688 2.3320312L33.615234 2.6386719L35.564453 4.3613281L35.050781 7 z M 10 12L16 12L16 16L10 16L10 12 z M 22 12L28 12L28 16L22 16L22 12 z M 34 12L40 12L40 16L34 16L34 12 z M 10 20L16 20L16 24L10 24L10 20 z M 22 20L28 20L28 24L22 24L22 20 z M 34 20L40 20L40 24L34 24L34 20 z M 10 28L16 28L16 32L10 32L10 28 z M 22 28L28 28L28 32L22 32L22 28 z M 34 28L40 28L40 32L34 32L34 28 z M 10 36L16 36L16 40L10 40L10 36 z M 34 36L40 36L40 40L34 40L34 36 z"></path></g></svg>                        </span><br>
                        </span><br>
                        <span class="nav-link-title">
                          HOSTAL
                        </span>
                      </a>
                  </li>
                  <li class="nav-item {{ request()->routeIs('admin.Restaurante') ? 'active' : '' }}">
                      <a class="nav-link dashboard" href="{{ route('admin.Restaurante') }}">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                          <svg width="256px" height="256px" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" fill="#ffffff" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><title>ionicons-v5-p</title><path d="M57.49,47.74,425.92,416.17a37.28,37.28,0,0,1,0,52.72h0a37.29,37.29,0,0,1-52.72,0l-90-91.55A32,32,0,0,1,274,354.91v-5.53a32,32,0,0,0-9.52-22.78l-11.62-10.73a32,32,0,0,0-29.8-7.44h0A48.53,48.53,0,0,1,176.5,295.8L91.07,210.36C40.39,159.68,21.74,83.15,57.49,47.74Z" style="fill:none;stroke:#ffffff;stroke-linejoin:round;stroke-width:32px"></path><path d="M400,32l-77.25,77.25A64,64,0,0,0,304,154.51v14.86a16,16,0,0,1-4.69,11.32L288,192" style="fill:none;stroke:#ffffff;stroke-linecap:round;stroke-linejoin:round;stroke-width:32px"></path><path d="M320,224l11.31-11.31A16,16,0,0,1,342.63,208h14.86a64,64,0,0,0,45.26-18.75L480,112" style="fill:none;stroke:#ffffff;stroke-linecap:round;stroke-linejoin:round;stroke-width:32px"></path><line x1="440" y1="72" x2="360" y2="152" style="fill:none;stroke:#ffffff;stroke-linecap:round;stroke-linejoin:round;stroke-width:32px"></line><path d="M200,368,100.28,468.28a40,40,0,0,1-56.56,0h0a40,40,0,0,1,0-56.56L128,328" style="fill:none;stroke:#ffffff;stroke-linecap:round;stroke-linejoin:round;stroke-width:32px"></path></g></svg>
                        </span><br>
                        <span class="nav-link-title">
                          RESTAURANTE
                        </span>
                      </a>
                  </li>
                  <li class="nav-item {{ request()->routeIs('admin.Ventas') ? 'active' : '' }}">
                      <a class="nav-link dashboard" href="{{ route('admin.Ventas') }}" >
                      <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                        <svg version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="256px" height="256px" viewBox="0 0 512 512" xml:space="preserve" fill="#ffffff" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <style type="text/css">  .st0{fill:#ffffff;}  </style> <g> <path class="st0" d="M77.609,448h52.781c7.516,0,13.609-6.094,13.609-13.609V315.094c0-7.516-6.094-13.609-13.609-13.609H77.609 c-7.516,0-13.609,6.094-13.609,13.609v119.297C64,441.906,70.094,448,77.609,448z"></path> <path class="st0" d="M197.609,448h52.781c7.516,0,13.609-6.094,13.609-13.609V235.094c0-7.516-6.094-13.609-13.609-13.609h-52.781 c-7.516,0-13.609,6.094-13.609,13.609v199.297C184,441.906,190.094,448,197.609,448z"></path> <path class="st0" d="M317.609,448h52.781c7.516,0,13.609-6.094,13.609-13.609V139.094c0-7.516-6.094-13.609-13.609-13.609h-52.781 c-7.516,0-13.609,6.094-13.609,13.609v295.297C304,441.906,310.094,448,317.609,448z"></path> <path class="st0" d="M437.609,448h52.781c7.516,0,13.609-6.094,13.609-13.609V43.094c0-7.516-6.094-13.609-13.609-13.609h-52.781 c-7.516,0-13.609,6.094-13.609,13.609v391.297C424,441.906,430.094,448,437.609,448z"></path> <path class="st0" d="M498.391,482H45.609C38.094,482,32,475.906,32,468.391V13.609C32,6.094,25.906,0,18.391,0h-4.781 C6.094,0,0,6.094,0,13.609v484.781C0,505.906,6.094,512,13.609,512h484.781c7.516,0,13.609-6.094,13.609-13.609v-2.781 C512,488.094,505.906,482,498.391,482z"></path> </g> </g></svg>
                      </span><br>
                      <span class="nav-link-title">
                      VENTAS
                      </span>
                    </a>
                  </li>
                  <li class="nav-item {{ request()->routeIs('admin.kardex.Kardex') ? 'active' : '' }}">
                      <a class="nav-link dashboard" href="{{ route('admin.kardex.Kardex') }}" >
                      <span class="nav-link-icon d-md-none d-lg-inline-block">
                        <svg fill="#ffffff" height="256px" width="256px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g> <path d="M54.532,211.26c-4.484-4.476-12.484-4.476-16.96,0c-2.244,2.24-3.524,5.32-3.524,8.484c0,3.156,1.28,6.236,3.524,8.476 c2.24,2.244,5.32,3.524,8.476,3.524c3.164,0,6.24-1.284,8.484-3.524c2.244-2.236,3.516-5.32,3.516-8.476 C58.048,216.58,56.776,213.504,54.532,211.26z"></path> </g> </g> <g> <g> <path d="M467.36,211.26c-4.484-4.476-12.484-4.476-16.96,0c-2.244,2.24-3.524,5.32-3.524,8.484c0,3.156,1.28,6.236,3.524,8.476 c2.24,2.244,5.32,3.524,8.476,3.524c3.164,0,6.24-1.284,8.484-3.524c2.244-2.236,3.516-5.32,3.516-8.476 C470.876,216.58,469.604,213.504,467.36,211.26z"></path> </g> </g> <g> <g> <path d="M54.532,403.348c-4.484-4.48-12.484-4.48-16.96,0c-2.244,2.236-3.524,5.32-3.524,8.48c0,3.156,1.284,6.24,3.524,8.48 c2.24,2.24,5.32,3.52,8.476,3.52c3.164,0,6.24-1.284,8.484-3.52c2.244-2.236,3.516-5.324,3.516-8.48 C58.048,408.668,56.776,405.588,54.532,403.348z"></path> </g> </g> <g> <g> <path d="M467.36,407.348c-4.484-4.48-12.484-4.48-16.96,0c-2.244,2.236-3.524,5.32-3.524,8.48c0,3.156,1.284,6.24,3.524,8.48 c2.24,2.24,5.32,3.52,8.476,3.52c3.164,0,6.24-1.284,8.484-3.52c2.244-2.236,3.516-5.324,3.516-8.48 C470.876,412.668,469.604,409.588,467.36,407.348z"></path> </g> </g> <g> <g> <path d="M346.296,146.204c-0.664-1.4-2.068-2.204-3.616-2.204H312V51.86c0-2.212-3.548-3.86-5.756-3.86h-103.9 c-2.212,0-2.344,1.648-2.344,3.86V144h-33.592c-1.548,0-2.956,0.804-3.612,2.204c-0.664,1.4-0.46,2.968,0.516,4.168L251.456,257.9 c0.756,0.924,1.888,1.464,3.092,1.464c1.192,0,2.336-0.524,3.092-1.448l88.132-107.504 C346.748,149.212,346.952,147.604,346.296,146.204z"></path> </g> </g> <g> <g> <path d="M498.624,168h-136l-19.672,24H488v248H24V192h142.14l-19.672-24H10.46C3.836,168,0,173.048,0,179.672v272.132 C0,458.428,3.836,464,10.46,464h488.164c6.632,0,13.376-5.572,13.376-12.196V179.672C512,173.048,505.256,168,498.624,168z"></path> </g> </g> <g> <g> <path d="M459.436,249.056c-18.368,0-33.592-14.812-33.592-33.188c0-2.212-2.072-3.868-4.28-3.868h-95.056l-31.92,38.824 c13.516,14.648,22.124,36.476,22.124,60.98c0,44.104-27.836,79.82-62.164,79.82c-34.336,0-62.164-35.764-62.164-79.872 c0-24.504,8.608-46.276,22.124-60.924L182.584,212H83.36c-2.212,0-4,1.656-4,3.868c0,18.376-13.968,33.252-32.336,33.252 c-2.212,0-3.024,1.724-3.024,3.932V374.42c0,2.212,0.812,4,3.024,4c18.368,0,32.824,15.08,32.824,33.444 c0,2.212,1.3,4.132,3.512,4.132h338.204c2.212,0,4-1.92,4-4.132c0-18.368,15.508-33.376,33.876-33.376 c2.212,0,4.564-1.86,4.564-4.072v-121.36C464,250.844,461.648,249.056,459.436,249.056z M114.64,343.516 c-15.344,0-27.78-12.44-27.78-27.78c0-15.344,12.436-27.78,27.78-27.78s27.78,12.436,27.78,27.78 C142.42,331.076,129.984,343.516,114.64,343.516z M394.248,343.516c-15.336,0-27.78-12.44-27.78-27.78 c0-15.344,12.444-27.78,27.78-27.78c15.344,0,27.78,12.436,27.78,27.78C422.032,331.076,409.592,343.516,394.248,343.516z"></path> </g> </g> <g> <g> <path d="M272,341.04v-13.764c8-6.96,11.556-21.428,11.556-35.868c0-9.68-1.716-16.584-5.02-21.436l-2.48,3.176 c-5.344,6.492-13.164,10.216-21.572,10.216c-8.428,0-16.296-3.74-21.624-10.248l-2.016-2.476c-3.04,4.816-5.36,11.532-5.36,20.772 c0,14.436,6.516,28.908,10.516,35.868v13.764c-16,2.392-36,8.756-36,26.752v25.28L228.548,412h72.664l10.18-43.412 C311.392,350.596,288,343.428,272,341.04z"></path> </g> </g> </g></svg>                        </span><br>
                      <span class="nav-link-title">
                      KARDEX
                      </span>
                    </a>
                  </li>
                  <li class="nav-item dropdown {{ request()->routeIs('admin.ConfiguracionImpresora') ? 'active' : '' }}">
                      <a class="nav-link dropdown-toggle show" href="#" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
                          <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <svg fill="#ffffff" width="256px" height="256px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" data-name="Layer 1"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M13.61 20.81V3.19a2.19 2.19 0 0 0-.28 0l-1.42.25C9.05 4 6.18 4.5 3.31 5c-.25 0-.31.13-.31.38V19Zm-7.89-6.2c.54-1.92 1.09-3.84 1.62-5.77a.34.34 0 0 1 .4-.3h.73c.47 0 .39-.08.52.36l1.56 5.36.38 1.3c-.47 0-.89 0-1.31-.1-.06 0-.14-.11-.16-.19q-.17-.59-.3-1.17a.23.23 0 0 0-.25-.21h-1.6c-.07 0-.17.1-.2.18-.1.34-.19.69-.26 1 0 .19-.13.24-.31.22s-.62-.05-1-.07c.09-.22.13-.44.18-.61Z"></path><path d="M8.13 9.81h-.05l-.67 2.82h1.4c-.23-.96-.45-1.89-.68-2.82ZM17 5.71q-.93-.23-1.83-.48c-.16 0-.22 0-.28.14a4.92 4.92 0 0 0-.68 3.09c0 .23 0 .31.29.33a3.17 3.17 0 0 1 1 6.05 9.87 9.87 0 0 1-1.3.37v1.87a5.65 5.65 0 0 0 .85-.1.36.36 0 0 1 .43.18c.32.44.66.87 1 1.32l1.86-1.1c.05 0 .07-.17.05-.24-.13-.37-.26-.74-.42-1.1s-.19-.58.12-.83a1.29 1.29 0 0 0 .28-.37.28.28 0 0 1 .33-.14c.5.08 1 .13 1.51.21.17 0 .23 0 .27-.19.15-.6.31-1.2.47-1.8 0-.14 0-.22-.12-.28s-.59-.29-.9-.39a.88.88 0 0 1-.71-.94.81.81 0 0 1 .39-.83c.37-.25.72-.54 1.09-.82l-1.03-1.78c-.07-.14-.16-.13-.28-.08-.45.17-.9.35-1.35.5a.42.42 0 0 1-.32-.06c-.21-.14-.38-.33-.59-.47a.29.29 0 0 1-.13-.35c.07-.47.13-1 .2-1.43 0-.15-.03-.24-.2-.28Z"></path><path d="M15.39 12a1.14 1.14 0 0 0-1.17-1.11v2.29A1.15 1.15 0 0 0 15.39 12Z"></path></g></svg>
                          </span><br>
                        <span class="nav-link-title">
                        CAJAS
                        </span>
                      </a>
                      <div class="dropdown-menu" data-bs-popper="static">
                        <div class="dropdown-menu-columns">
                          <div class="dropdown-menu-column" id="get-cajas">
                            ///aqui quiero poner lo que me traiga de esa ruta
                            <a class="dropdown-item">
                              
                            </a>                            
                          </div>
                          <div class="dropdown-menu-column">
                            <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-crear-caja">
                              CREAR CAJA
                            </a>
                            <a class="dropdown-item" href="#" onclick="pedirPin()" style="color: red; background: white; font-weight: bold;">
                                CAJA CHICA
                            </a>
                          </div>
                        </div>
                      </div>
                  </li>
                  <li class="nav-item dropdown {{ request()->routeIs('admin.ConfiguracionImpresora') ? 'active' : '' }}">
                      <a class="nav-link dropdown-toggle show" href="#" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
                          <span class="nav-link-icon d-md-none d-lg-inline-block">
                          <svg xmlns="http://www.w3.org/2000/svg" width="203px" height="203px" viewBox="0 0 24 24" fill="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M0 0h24v24H0z" fill="none"></path><path d="M16.53 11.06L15.47 10l-4.88 4.88-2.12-2.12-1.06 1.06L10.59 17l5.94-5.94zM19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z"></path></g></svg>                          </span><br>
                          </span>
                        <span class="nav-link-title">
                        EVENTOS
                        </span>
                      </a>
                      <div class="dropdown-menu" data-bs-popper="static">
                        <div class="dropdown-menu-columns">
                          <div class="dropdown-menu-column" id="get-cajas">
                            ///aqui quiero poner lo que me traiga de esa ruta
                            <a class="dropdown-item">
                              
                            </a>                            
                          </div>
                          <div class="dropdown-menu-column">
                            <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-crear-evento">
                              CREAR EVENTO
                            </a>
                          </div>
                        </div>
                      </div>
                  </li>
                  <li class="nav-item {{ request()->routeIs('admin.Productos') ? 'active' : '' }}">
                      <a class="nav-link dashboard" href="{{ route('admin.Productos') }}" >
                      <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                        <svg fill="#ffffff" width="256px" height="256px" viewBox="0 0 50 50" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g id="Solid"> <path d="M48,11v4a2.00229,2.00229,0,0,1-2,2H31.1687a14.41249,14.41249,0,0,0-7.11694-3.53516,27.919,27.919,0,0,0-5.05127-.46386c-.333,0-.66675.011-1.00049.02313V11a2.00229,2.00229,0,0,1,2-2H46A2.00229,2.00229,0,0,1,48,11Zm-2,8H32.97949a14.84069,14.84069,0,0,1,2.86475,6.90234A4.98455,4.98455,0,0,1,38,30v4a4.9497,4.9497,0,0,1-.50879,2.19727A5.463,5.463,0,0,1,36,42.72461V45a4.95129,4.95129,0,0,1-1.02557,3H42.125a3.006,3.006,0,0,0,2.99365-2.80664l1.69544-26.27759A3.9983,3.9983,0,0,1,46,19ZM44,3a.99974.99974,0,0,0-1-1H39a.97242.97242,0,0,0-.24268.03027l-16,4A.99972.99972,0,0,0,22,7H44ZM29.90576,36.57617A1,1,0,0,0,29,36H19a1.00013,1.00013,0,0,0-.76807,1.64062l5,6a1.00045,1.00045,0,0,0,1.53614,0l5-6A1.00046,1.00046,0,0,0,29.90576,36.57617ZM33.5,36H31.82141a3.00863,3.00863,0,0,1-.51575,2.91992L29.5722,41H33.5a2.5,2.5,0,0,0,0-5ZM16.69531,38.9209A3.00915,3.00915,0,0,1,16.17871,36H4.5a2.5,2.5,0,0,0,0,5H18.4281ZM27.90552,43l-1.60083,1.9209a3,3,0,0,1-4.60791.001L20.095,43H4v2a3,3,0,0,0,3,3H31a3,3,0,0,0,3-3V43ZM35,30H3a1,1,0,0,0-1,1v2a1,1,0,0,0,1,1H35a1,1,0,0,0,1-1V31A1,1,0,0,0,35,30Zm-1-2H4A13,13,0,0,1,17,15h4A13,13,0,0,1,34,28ZM13,23.5A1.5,1.5,0,1,0,11.5,25,1.50164,1.50164,0,0,0,13,23.5Zm4-3A1.5,1.5,0,1,0,15.5,22,1.50164,1.50164,0,0,0,17,20.5Zm3.5,3A1.5,1.5,0,1,0,19,25,1.50164,1.50164,0,0,0,20.5,23.5Zm3.5-3A1.5,1.5,0,1,0,22.5,22,1.50164,1.50164,0,0,0,24,20.5Zm4,3A1.5,1.5,0,1,0,26.5,25,1.50164,1.50164,0,0,0,28,23.5Z"></path> </g> </g></svg>                        </span><br>
                      <span class="nav-link-title">
                      PRODUCTOS
                      </span>
                    </a>
                  </li>
                  <li class="nav-item {{ request()->routeIs('admin.Hostal.Inventario') ? 'active' : '' }}">
                      <a class="nav-link dashboard" href="{{ route('admin.Hostal.Inventario') }}" >
                      <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                        <svg version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="256px" height="256px" viewBox="0 0 512 512" xml:space="preserve" fill="#ffffff" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <style type="text/css">  .st0{fill:#ffffff;}  </style> <g> <path class="st0" d="M77.609,448h52.781c7.516,0,13.609-6.094,13.609-13.609V315.094c0-7.516-6.094-13.609-13.609-13.609H77.609 c-7.516,0-13.609,6.094-13.609,13.609v119.297C64,441.906,70.094,448,77.609,448z"></path> <path class="st0" d="M197.609,448h52.781c7.516,0,13.609-6.094,13.609-13.609V235.094c0-7.516-6.094-13.609-13.609-13.609h-52.781 c-7.516,0-13.609,6.094-13.609,13.609v199.297C184,441.906,190.094,448,197.609,448z"></path> <path class="st0" d="M317.609,448h52.781c7.516,0,13.609-6.094,13.609-13.609V139.094c0-7.516-6.094-13.609-13.609-13.609h-52.781 c-7.516,0-13.609,6.094-13.609,13.609v295.297C304,441.906,310.094,448,317.609,448z"></path> <path class="st0" d="M437.609,448h52.781c7.516,0,13.609-6.094,13.609-13.609V43.094c0-7.516-6.094-13.609-13.609-13.609h-52.781 c-7.516,0-13.609,6.094-13.609,13.609v391.297C424,441.906,430.094,448,437.609,448z"></path> <path class="st0" d="M498.391,482H45.609C38.094,482,32,475.906,32,468.391V13.609C32,6.094,25.906,0,18.391,0h-4.781 C6.094,0,0,6.094,0,13.609v484.781C0,505.906,6.094,512,13.609,512h484.781c7.516,0,13.609-6.094,13.609-13.609v-2.781 C512,488.094,505.906,482,498.391,482z"></path> </g> </g></svg>
                      </span><br>
                      <span class="nav-link-title">
                      INVENTARIO
                      </span>
                    </a>
                  </li>
                  <li class="nav-item dropdown {{ request()->routeIs('admin.ConfiguracionImpresora') ? 'active' : '' }}">
                      <a class="nav-link dropdown-toggle show" href="#" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
                          <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                            <svg fill="#ffffff" width="256px" height="256px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" data-name="Layer 1"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M13.61 20.81V3.19a2.19 2.19 0 0 0-.28 0l-1.42.25C9.05 4 6.18 4.5 3.31 5c-.25 0-.31.13-.31.38V19Zm-7.89-6.2c.54-1.92 1.09-3.84 1.62-5.77a.34.34 0 0 1 .4-.3h.73c.47 0 .39-.08.52.36l1.56 5.36.38 1.3c-.47 0-.89 0-1.31-.1-.06 0-.14-.11-.16-.19q-.17-.59-.3-1.17a.23.23 0 0 0-.25-.21h-1.6c-.07 0-.17.1-.2.18-.1.34-.19.69-.26 1 0 .19-.13.24-.31.22s-.62-.05-1-.07c.09-.22.13-.44.18-.61Z"></path><path d="M8.13 9.81h-.05l-.67 2.82h1.4c-.23-.96-.45-1.89-.68-2.82ZM17 5.71q-.93-.23-1.83-.48c-.16 0-.22 0-.28.14a4.92 4.92 0 0 0-.68 3.09c0 .23 0 .31.29.33a3.17 3.17 0 0 1 1 6.05 9.87 9.87 0 0 1-1.3.37v1.87a5.65 5.65 0 0 0 .85-.1.36.36 0 0 1 .43.18c.32.44.66.87 1 1.32l1.86-1.1c.05 0 .07-.17.05-.24-.13-.37-.26-.74-.42-1.1s-.19-.58.12-.83a1.29 1.29 0 0 0 .28-.37.28.28 0 0 1 .33-.14c.5.08 1 .13 1.51.21.17 0 .23 0 .27-.19.15-.6.31-1.2.47-1.8 0-.14 0-.22-.12-.28s-.59-.29-.9-.39a.88.88 0 0 1-.71-.94.81.81 0 0 1 .39-.83c.37-.25.72-.54 1.09-.82l-1.03-1.78c-.07-.14-.16-.13-.28-.08-.45.17-.9.35-1.35.5a.42.42 0 0 1-.32-.06c-.21-.14-.38-.33-.59-.47a.29.29 0 0 1-.13-.35c.07-.47.13-1 .2-1.43 0-.15-.03-.24-.2-.28Z"></path><path d="M15.39 12a1.14 1.14 0 0 0-1.17-1.11v2.29A1.15 1.15 0 0 0 15.39 12Z"></path></g></svg>
                          </span><br>
                        <span class="nav-link-title">
                        ADM. RESTAURANTE
                        </span>
                      </a>
                      <div class="dropdown-menu" data-bs-popper="static">
                        <div class="dropdown-menu-columns">
                          <div class="dropdown-menu-column">
                            <a class="dropdown-item" href="{{ route('admin.personal.personal') }}">
                              Planillas / Asistencia
                            </a>
                            <a class="dropdown-item" href="{{ route('admin.ConfiguracionImpresora') }}">
                              Impresora
                              <span class="badge badge-sm bg-green-lt text-uppercase ms-auto">New</span>
                            </a>
                            <a class="dropdown-item" href="{{ route('admin.ambiente.ambientes') }}">
                              Ambientes Restaurante
                            </a>
                            <a class="dropdown-item" href="{{ route('admin.user.usuarios') }}">
                              Usuarios
                            </a>
                            <a class="dropdown-item" href="{{ route('admin.Clientes') }}">
                              Clientes
                            </a>
                            <a class="dropdown-item" href="{{ route('admin.Proveedores') }}">
                              Proveedores
                            </a>
                            <a class="dropdown-item" href="{{ route('admin.menu.online') }}">
                              Menu Online
                            </a>
                          </div>
                        </div>
                      </div>
                  </li>
                  <li class="nav-item dropdown {{ request()->routeIs('admin.ConfiguracionImpresora') ? 'active' : '' }}">
                      <a class="nav-link dropdown-toggle show" href="#" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
                          <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                            <svg fill="#ffffff" width="256px" height="256px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" data-name="Layer 1"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M13.61 20.81V3.19a2.19 2.19 0 0 0-.28 0l-1.42.25C9.05 4 6.18 4.5 3.31 5c-.25 0-.31.13-.31.38V19Zm-7.89-6.2c.54-1.92 1.09-3.84 1.62-5.77a.34.34 0 0 1 .4-.3h.73c.47 0 .39-.08.52.36l1.56 5.36.38 1.3c-.47 0-.89 0-1.31-.1-.06 0-.14-.11-.16-.19q-.17-.59-.3-1.17a.23.23 0 0 0-.25-.21h-1.6c-.07 0-.17.1-.2.18-.1.34-.19.69-.26 1 0 .19-.13.24-.31.22s-.62-.05-1-.07c.09-.22.13-.44.18-.61Z"></path><path d="M8.13 9.81h-.05l-.67 2.82h1.4c-.23-.96-.45-1.89-.68-2.82ZM17 5.71q-.93-.23-1.83-.48c-.16 0-.22 0-.28.14a4.92 4.92 0 0 0-.68 3.09c0 .23 0 .31.29.33a3.17 3.17 0 0 1 1 6.05 9.87 9.87 0 0 1-1.3.37v1.87a5.65 5.65 0 0 0 .85-.1.36.36 0 0 1 .43.18c.32.44.66.87 1 1.32l1.86-1.1c.05 0 .07-.17.05-.24-.13-.37-.26-.74-.42-1.1s-.19-.58.12-.83a1.29 1.29 0 0 0 .28-.37.28.28 0 0 1 .33-.14c.5.08 1 .13 1.51.21.17 0 .23 0 .27-.19.15-.6.31-1.2.47-1.8 0-.14 0-.22-.12-.28s-.59-.29-.9-.39a.88.88 0 0 1-.71-.94.81.81 0 0 1 .39-.83c.37-.25.72-.54 1.09-.82l-1.03-1.78c-.07-.14-.16-.13-.28-.08-.45.17-.9.35-1.35.5a.42.42 0 0 1-.32-.06c-.21-.14-.38-.33-.59-.47a.29.29 0 0 1-.13-.35c.07-.47.13-1 .2-1.43 0-.15-.03-.24-.2-.28Z"></path><path d="M15.39 12a1.14 1.14 0 0 0-1.17-1.11v2.29A1.15 1.15 0 0 0 15.39 12Z"></path></g></svg>
                          </span><br>
                        <span class="nav-link-title">
                        ADM. HOSTAL
                        </span>
                      </a>
                      <div class="dropdown-menu" data-bs-popper="static">
                        <div class="dropdown-menu-columns">
                          <div class="dropdown-menu-column">
                            <a class="dropdown-item" href="{{ route('admin.Hostal.Huespedes') }}">
                              Huespedes
                            </a>
                            <a class="dropdown-item" href="{{ route('admin.Hostal.RegistrarMapaLugares') }}">
                              Registrar - Lugares Turisticos
                            </a>
                            <a class="dropdown-item" href="{{ route('admin.Hostal.MapaLugares') }}">
                              Mapa - Lugares Turisticos
                            </a>
                          </div>
                        </div>
                      </div>
                  </li>
                  <li class="nav-item dropdown {{ request()->routeIs('admin.calendario-disponibilidad') ? 'active' : '' }}">
                    <a class="nav-link dropdown-toggle show" href="#" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
                      <span class="nav-link-icon d-md-none d-lg-inline-block">
                        <svg fill="#ffffff" height="256px" width="256px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 491.526 491.526" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g> <g> <path d="M143.36,102.403c-11.305,0-20.48,9.195-20.48,20.48s9.175,20.48,20.48,20.48c11.305,0,20.48-9.196,20.48-20.48 S154.665,102.403,143.36,102.403z"></path> <path d="M491.52,20.483c0-11.305-9.155-20.48-20.48-20.48H20.48C9.155,0.003,0,9.178,0,20.483v266.24h491.52V20.483z M143.36,184.323c-33.874,0-61.44-27.566-61.44-61.44s27.566-61.44,61.44-61.44c33.874,0,61.44,27.566,61.44,61.44 S177.234,184.323,143.36,184.323z M424.079,96.402l-34.959,34.959v73.441c0,11.305-9.155,20.48-20.48,20.48 s-20.48-9.175-20.48-20.48v-32.481l-67.441,67.441c-3.994,3.994-9.236,6.001-14.479,6.001c-5.243,0-10.486-2.007-14.479-6.001 l-40.96-40.96c-8.008-8.008-8.008-20.951,0-28.959s20.951-8.008,28.959,0l26.481,26.481l52.961-52.961H286.72 c-11.326,0-20.48-9.175-20.48-20.48c0-11.305,9.155-20.48,20.48-20.48h73.441l34.959-34.959c8.008-8.008,20.951-8.008,28.959,0 C432.087,75.451,432.087,88.395,424.079,96.402z"></path> <path d="M0.006,327.683v61.44c0,11.305,9.155,20.48,20.48,20.48h152.453c-1.823,13.107-7.004,27.443-11.796,31.007 l-13.844,10.281c-7.885,5.734-11.162,15.872-8.11,25.19c2.99,9.236,11.469,15.442,21.115,15.442h170.762 c9.626,0,18.104-6.185,21.115-15.38c3.031-9.318-0.205-19.436-7.946-25.108l-13.988-10.424 c-4.772-3.523-9.912-17.879-11.694-31.007h152.494c11.305,0,20.48-9.175,20.48-20.48v-61.44H0.006z M203.229,450.563 c6.042-12.431,9.81-27.197,10.977-40.96h63.099c1.126,13.763,4.895,28.549,10.895,40.96H203.229z"></path> </g> </g> </g> </g></svg>
                      </span><br>
                      <span class="nav-link-title">BOOKING</span>
                    </a>
                    <div class="dropdown-menu" data-bs-popper="static">
                      <div class="dropdown-menu-columns">
                        <div class="dropdown-menu-column">
                          <a class="dropdown-item" href="{{ route('admin.calendario-disponibilidad') }}">
                            CALENDARIO
                          </a>
                        </div>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </header>
        <div class="page-wrapper" style="background: white">
          <div class="page-body" style="width: 98%; margin-left: 1%; margin-right: 1%; margin-top: 1%">
              <main>
                  @yield('content')                
              </main>
          </div>
          <footer class="footer footer-transparent d-print-none">
              <div class="container-xl">
                  <div class="row text-center align-items-center flex-row-reverse">
                  <div class="col-lg-auto ms-lg-auto">
                      <ul class="list-inline list-inline-dots mb-0">
                      <li class="list-inline-item"><a  target="_blank" class="link-secondary" rel="noopener">Contacto</a></li>
                      </ul>
                  </div>
                  <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                      <ul class="list-inline list-inline-dots mb-0">
                      <li class="list-inline-item">
                          Copyright &copy; 2023
                          <a href="." class="link-secondary">Alejandro</a>.
                          All rights reserved.
                      </li>
                      </ul>
                  </div>
                  </div>
              </div>
          </footer>
        </div>
      </div>
    </div>
    <!-- Libs JS -->
    <style>
      .active {
          background-color: #FF0303;
          border-radius: 6px;
      }

      .nav-item {
          display: flex;
          flex-direction: column;
          align-items: center;
          justify-content: center;
          text-align: center;
      }

      .nav-item {
          display: flex;
          flex-direction: column;
          align-items: center;
          justify-content: center;
          text-align: center;
      }

      .nav-link-title {
          text-align: center;
      }

      .nav-link-icon svg {
          width: 60px;
          height: 35px;
          margin-left: -15px;
      }

      .nav-link {
          display: flex;
          flex-direction: column;
          margin: auto;
      }

      .nav-link-icon {
          margin-bottom: 4px;
      }
    </style>
  <!-- script add -->
  <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
  <script src="{{ asset('utilidades/js/toasty-helper.js') }}" defer></script>
  <!-- fin script add -->

  <script src="{{ asset('dashboard/dist/libs/dropzone/dist/dropzone-min.js?1684106062') }}" defer></script>
  <script src="{{ asset('dashboard/dist/libs/apexcharts/dist/apexcharts.min.js?1692870762') }}" defer></script>
  <script src="{{ asset('dashboard/dist/libs/jsvectormap/dist/js/jsvectormap.min.js?1692870762') }}" defer></script>
  <script src="{{ asset('dashboard/dist/libs/jsvectormap/dist/maps/world.js?1692870762') }}" defer></script>
  <script src="{{ asset('dashboard/dist/libs/jsvectormap/dist/maps/world-merc.js?1692870762') }}" defer></script>
  <!-- Tabler Core -->
  <script src="{{ asset('dashboard/dist/js/tabler.min.js?1692870762') }}" defer></script>
  <script src="{{ asset('dashboard/dist/js/demo.min.js? 1692870762') }}" defer></script>
  <script>
    $(document).ready(function() {   
      // Llamar a GetCajas cuando el documento esté listo
      GetCajas();

      // Función para formatear la fecha a "Mes del Año"
      function formatDateToText(dateString) {
        const date = new Date(dateString);
        const meses = [
          'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio',
          'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'
        ];
        const mes = meses[date.getMonth()];
        const anio = date.getFullYear();
        return `${mes} del ${anio}`;
      }

      // Mostrar el mes y año actuales en el modal
      $('#modal-crear-caja').on('shown.bs.modal', function() {
        const hoy = new Date();
        const meses = [
          'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
          'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
        ];
        const mes = meses[hoy.getMonth()];
        const anio = hoy.getFullYear();
        $('#fechainput').val(`${mes} ${anio}`);
      });

      // Registrar una nueva caja al hacer clic
      $('#btn-registrar-caja').on('click', function() {
        const fecha = $('#fechainput').val();
        $.ajax({
          url: '/api/registrar-caja',
          method: 'POST',
          data: {
            _token: '{{ csrf_token() }}',
            fecha: fecha
          },
          success: function(response) {
            MostrarMensaje("Creado Exitosamente", "success");
            $('#modal-crear-caja').modal('hide');
            GetCajas(); 
          },
          error: function(xhr) {
            MostrarMensaje("Ya existe una caja", "error");
          }
        });
      });

      function GetCajas() {
        $.ajax({
          url: '/api/get-cajas',
          method: 'GET',
          success: function(response) {
            $('#get-cajas').empty(); 
            response.forEach(function(caja) {
              const formattedDate = formatDateToText(caja.fecha_registro);
              $('#get-cajas').append(
                `<a class="dropdown-item" href="#" onclick="redirectToCaja(${caja.id}); return false;">
                    ${formattedDate}
                </a>`
              );
            });
          },
          error: function() {
            alert('Error al cargar las cajas');
          }
        });
      }


      // Mostrar el mes y año actuales en el modal
      $('#modal-crear-evento').on('shown.bs.modal', function() {
        alert("gooo")
      });

      // Registrar un nuevo evento caja al hacer clic
      $('#btn-registrar-caja').on('click', function() {
        const fecha = $('#fechainput').val();
        $.ajax({
          url: '/api/registrar-caja',
          method: 'POST',
          data: {
            _token: '{{ csrf_token() }}',
            fecha: fecha
          },
          success: function(response) {
            MostrarMensaje("Creado Exitosamente", "success");
            $('#modal-crear-caja').modal('hide');
            GetCajas(); 
          },
          error: function(xhr) {
            MostrarMensaje("Ya existe una caja", "error");
          }
        });
      });

      // Redirigir a la vista con el ID de la caja
      window.redirectToCaja = function(id) {
        window.location.href = `/api/get-cajas/${id}`;
      };
    });


    //PIN PARA REDIRECCIONAR USAURIO SI LE PERTENECE O NELL
    function pedirPin() {
      var pinCorrecto = "7747"; // Cambia esto por el PIN que desees
      var pinIngresado = prompt("Ingrese su PIN:");

      if (pinIngresado === pinCorrecto) {
          window.location.href = "/api/CajaChica/1";
      } else {
          alert("PIN incorrecto. Acceso denegado.");
      }
  }
  </script>

  </body>
</html>