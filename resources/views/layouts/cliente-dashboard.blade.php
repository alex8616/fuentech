<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Makalu</title>
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
    <link href={{ asset('dashboard/dist/css/tabler.min.css?1692870762') }} rel="stylesheet"/>
    <link href={{ asset('dashboard/dist/css/tabler-flags.min.css?1692870762') }} rel="stylesheet"/>
    <link href={{ asset('dashboard/dist/css/tabler-payments.min.css?1692870762') }} rel="stylesheet"/>
    <link href={{ asset('dashboard/dist/css/tabler-vendors.min.css?1692870762') }} rel="stylesheet"/>
    <link href={{ asset('dashboard/dist/css/demo.min.css?1692870762') }} rel="stylesheet"/>

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
    <div class="page">
      <!-- Navbar -->
      <header class="navbar navbar-expand-md navbar-overlap d-print-none"  data-bs-theme="dark">
        <div class="container-xl">
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu" aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
            <a href="." style="display: flex; flex-direction: column; align-items: center;">
                <div>
                    <img src="/dashboard/static/a.png" width="100" height="52" alt="Tabler">
                </div>
                
            </a>
        </h1>
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
                        <a href="." class="link-secondary">Alejandro Ventura Fuentes</a>.
                        All rights reserved.
                    </li>
                    </ul>
                </div>
                </div>
            </div>
        </footer>
      </div>
    </div>
    <!-- Libs JS -->

    <script src="{{ asset('dashboard/dist/libs/dropzone/dist/dropzone-min.js?1684106062') }}" defer></script>
    <script src="{{ asset('dashboard/dist/libs/apexcharts/dist/apexcharts.min.js?1692870762') }}" defer></script>
    <script src="{{ asset('dashboard/dist/libs/jsvectormap/dist/js/jsvectormap.min.js?1692870762') }}" defer></script>
    <script src="{{ asset('dashboard/dist/libs/jsvectormap/dist/maps/world.js?1692870762') }}" defer></script>
    <script src="{{ asset('dashboard/dist/libs/jsvectormap/dist/maps/world-merc.js?1692870762') }}" defer></script>
    <!-- Tabler Core -->
    <script src="{{ asset('dashboard/dist/js/tabler.min.js?1692870762') }}" defer></script>
    <script src="{{ asset('dashboard/dist/js/demo.min.js?1692870762') }}" defer></script>
  </body>
</html>
