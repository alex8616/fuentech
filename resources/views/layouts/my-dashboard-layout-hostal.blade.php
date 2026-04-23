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
                  <a href="#" class="dropdown-item" style="color: white">Status</a>
                  <a href="./profile.html" class="dropdown-item" style="color: white">Profile</a>
                  <a href="#" class="dropdown-item" style="color: white">Feedback</a>
                  <div class="dropdown-divider"></div>
                  <form method="POST" action="{{ route('logout') }}">
                      @csrf
                      <button type="submit" class="dropdown-item" style="color: white">Log Out</button>
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
                  <li class="nav-item {{ request()->routeIs('admin.Hostal.Huespedes') ? 'active' : '' }}">
                      <a class="nav-link dashboard" href="{{ route('admin.Hostal.Huespedes') }}" >
                      <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                        <svg fill="#ffffff" height="256px" width="256px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512.00 512.00" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g> <path d="M156.683,411.479h-22.274v-19.652c0-8.907-7.246-16.153-16.153-16.153H82.367c-8.907,0-16.153,7.246-16.153,16.153v19.652 H43.941c-6.244,0-11.307,5.063-11.307,11.307v77.906c0,6.245,5.063,11.307,11.307,11.307h112.741 c6.244,0,11.307-5.063,11.307-11.307v-77.906C167.989,416.541,162.927,411.479,156.683,411.479z M116.845,411.479h-0.001H83.78 v-18.24h33.065V411.479z"></path> </g> </g> <g> <g> <circle cx="259.839" cy="42.141" r="42.141"></circle> </g> </g> <g> <g> <path d="M467.168,326.163h-9.066v-54.005h7.442c2.221,0,4.022-1.801,4.022-4.022v-13.406c0-2.221-1.801-4.022-4.022-4.022H412.71 c2.989-8.683-0.201-18.595-8.286-23.747l-41.732-26.595l-0.331-54.776c-0.133-26.399-21.718-47.876-48.118-47.876 c-11.299,0-97.821,0-109.159,0c-26.4,0-47.985,21.477-48.118,47.876l-0.751,149.38c-0.057,11.23,9.001,20.379,20.23,20.435 c0.036,0,0.07,0,0.104,0c11.181,0,20.275-9.037,20.331-20.23l0.751-149.38c0.011-2.166,1.772-3.913,3.936-3.908 c2.165,0.006,3.915,1.762,3.915,3.926l0.009,341.787c0,13.476,10.924,24.4,24.4,24.4c13.476,0,24.4-10.924,24.4-24.4V292.57 h10.534v195.029c0,13.476,10.924,24.4,24.4,24.4c13.476,0,24.4-10.924,24.4-24.4c0-318.415-0.432-143.909-0.443-341.647 c0-2.323,1.863-4.217,4.186-4.256c2.323-0.038,4.249,1.794,4.324,4.116c0,0,0,0.001,0,0.002l0.398,65.869 c0.041,6.903,3.582,13.314,9.405,17.024l45.98,29.302v10.125c0,2.221,1.801,4.022,4.022,4.022h7.442v54.005h-9.066 c-6.738,0-12.199,5.462-12.199,12.199v139.941c0,6.738,5.462,12.199,12.199,12.199h9.066v13.177c0,4.595,3.726,8.321,8.321,8.321 c4.595,0,8.321-3.726,8.321-8.321v-13.177h35.877v13.177c0,4.595,3.726,8.321,8.321,8.321c4.595,0,8.321-3.726,8.321-8.321 v-13.177h9.065c6.738,0,12.199-5.462,12.199-12.199v-139.94C479.366,331.624,473.906,326.163,467.168,326.163z M441.46,326.163 h-35.873v-54.005h35.873V326.163z"></path> </g> </g> </g></svg>
                      </span><br>
                      <span class="nav-link-title">
                      HUESPEDES
                      </span>
                    </a>
                  </li>
                  <li class="nav-item {{ request()->routeIs('admin.Ventas') ? 'active' : '' }}">
                      <a class="nav-link dashboard" href="{{ route('admin.Ventas') }}" >
                      <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                        <svg width="256px" height="256px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M11 6L21 6.00072M11 12L21 12.0007M11 18L21 18.0007M3 11.9444L4.53846 13.5L8 10M3 5.94444L4.53846 7.5L8 4M4.5 18H4.51M5 18C5 18.2761 4.77614 18.5 4.5 18.5C4.22386 18.5 4 18.2761 4 18C4 17.7239 4.22386 17.5 4.5 17.5C4.77614 17.5 5 17.7239 5 18Z" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                      </span><br>
                      <span class="nav-link-title">
                      LISTAS
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
                  <li class="nav-item {{ request()->routeIs('admin.Ventas') ? 'active' : '' }}">
                      <a class="nav-link dashboard" href="{{ route('admin.Ventas') }}" >
                      <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                        <svg version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="256px" height="256px" viewBox="0 0 512 512" xml:space="preserve" fill="#ffffff" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <style type="text/css">  .st0{fill:#ffffff;}  </style> <g> <path class="st0" d="M77.609,448h52.781c7.516,0,13.609-6.094,13.609-13.609V315.094c0-7.516-6.094-13.609-13.609-13.609H77.609 c-7.516,0-13.609,6.094-13.609,13.609v119.297C64,441.906,70.094,448,77.609,448z"></path> <path class="st0" d="M197.609,448h52.781c7.516,0,13.609-6.094,13.609-13.609V235.094c0-7.516-6.094-13.609-13.609-13.609h-52.781 c-7.516,0-13.609,6.094-13.609,13.609v199.297C184,441.906,190.094,448,197.609,448z"></path> <path class="st0" d="M317.609,448h52.781c7.516,0,13.609-6.094,13.609-13.609V139.094c0-7.516-6.094-13.609-13.609-13.609h-52.781 c-7.516,0-13.609,6.094-13.609,13.609v295.297C304,441.906,310.094,448,317.609,448z"></path> <path class="st0" d="M437.609,448h52.781c7.516,0,13.609-6.094,13.609-13.609V43.094c0-7.516-6.094-13.609-13.609-13.609h-52.781 c-7.516,0-13.609,6.094-13.609,13.609v391.297C424,441.906,430.094,448,437.609,448z"></path> <path class="st0" d="M498.391,482H45.609C38.094,482,32,475.906,32,468.391V13.609C32,6.094,25.906,0,18.391,0h-4.781 C6.094,0,0,6.094,0,13.609v484.781C0,505.906,6.094,512,13.609,512h484.781c7.516,0,13.609-6.094,13.609-13.609v-2.781 C512,488.094,505.906,482,498.391,482z"></path> </g> </g></svg>
                      </span><br>
                      <span class="nav-link-title">
                      REPORTES
                      </span>
                    </a>
                  </li>
                  <li class="nav-item dropdown {{ request()->routeIs('admin.ConfiguracionImpresora') ? 'active' : '' }}">
                      <a class="nav-link dropdown-toggle show" href="#" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
                          <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                            <svg fill="#ffffff" width="256px" height="256px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" data-name="Layer 1"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M13.61 20.81V3.19a2.19 2.19 0 0 0-.28 0l-1.42.25C9.05 4 6.18 4.5 3.31 5c-.25 0-.31.13-.31.38V19Zm-7.89-6.2c.54-1.92 1.09-3.84 1.62-5.77a.34.34 0 0 1 .4-.3h.73c.47 0 .39-.08.52.36l1.56 5.36.38 1.3c-.47 0-.89 0-1.31-.1-.06 0-.14-.11-.16-.19q-.17-.59-.3-1.17a.23.23 0 0 0-.25-.21h-1.6c-.07 0-.17.1-.2.18-.1.34-.19.69-.26 1 0 .19-.13.24-.31.22s-.62-.05-1-.07c.09-.22.13-.44.18-.61Z"></path><path d="M8.13 9.81h-.05l-.67 2.82h1.4c-.23-.96-.45-1.89-.68-2.82ZM17 5.71q-.93-.23-1.83-.48c-.16 0-.22 0-.28.14a4.92 4.92 0 0 0-.68 3.09c0 .23 0 .31.29.33a3.17 3.17 0 0 1 1 6.05 9.87 9.87 0 0 1-1.3.37v1.87a5.65 5.65 0 0 0 .85-.1.36.36 0 0 1 .43.18c.32.44.66.87 1 1.32l1.86-1.1c.05 0 .07-.17.05-.24-.13-.37-.26-.74-.42-1.1s-.19-.58.12-.83a1.29 1.29 0 0 0 .28-.37.28.28 0 0 1 .33-.14c.5.08 1 .13 1.51.21.17 0 .23 0 .27-.19.15-.6.31-1.2.47-1.8 0-.14 0-.22-.12-.28s-.59-.29-.9-.39a.88.88 0 0 1-.71-.94.81.81 0 0 1 .39-.83c.37-.25.72-.54 1.09-.82l-1.03-1.78c-.07-.14-.16-.13-.28-.08-.45.17-.9.35-1.35.5a.42.42 0 0 1-.32-.06c-.21-.14-.38-.33-.59-.47a.29.29 0 0 1-.13-.35c.07-.47.13-1 .2-1.43 0-.15-.03-.24-.2-.28Z"></path><path d="M15.39 12a1.14 1.14 0 0 0-1.17-1.11v2.29A1.15 1.15 0 0 0 15.39 12Z"></path></g></svg>
                          </span><br>
                        <span class="nav-link-title">
                        ADMINISTRACION
                        </span>
                      </a>
                      <div class="dropdown-menu" data-bs-popper="static">
                        <div class="dropdown-menu-columns">
                          <div class="dropdown-menu-column">
                            <a class="dropdown-item" href="{{ route('admin.ConfiguracionImpresora') }}">
                              Impresora
                              <span class="badge badge-sm bg-green-lt text-uppercase ms-auto">New</span>
                            </a>
                            <a class="dropdown-item" href="{{ route('admin.ConfiguracionImpresora') }}">
                              Ambientes Restaurante
                            </a>
                            <a class="dropdown-item" href="{{ route('admin.ConfiguracionImpresora') }}">
                              Personal
                            </a>
                            <a class="dropdown-item" href="{{ route('admin.ConfiguracionImpresora') }}">
                              Usuarios
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
  <script src="{{ asset('dashboard/dist/js/demo.min.js?1692870762') }}" defer></script>
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

      // Redirigir a la vista con el ID de la caja
      window.redirectToCaja = function(id) {
        window.location.href = `/api/get-cajas/${id}`;
      };
    });
  </script>

  </body>
</html>