@extends('layouts.my-dashboard-layout')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="row">
    <div class="col-12 col-sm-7">
        <div class="card">
            <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs nav-fill" data-bs-toggle="tabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <a href="#tabs-salones" class="nav-link active" data-bs-toggle="tab" aria-selected="true" role="tab">SALONES</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a href="#tabs-reservas" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">RESERVAS</a>
                </li>
            </ul>
            </div>
            <div class="card-body">
            <div class="tab-content">
                <div class="tab-pane active show" id="tabs-salones" role="tabpanel">
                    @include('admin.Hostal.SalonesReserva')
                </div>
                <div class="tab-pane" id="tabs-reservas" role="tabpanel" style="width: 100%;">
                    @include('admin.Hostal.SalonesCalendarReserva')
                </div>
            </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-5" style="margin: 0px; padding: 0px;">
        <div class="card" id="form_tabs">
            <div class="card-header">
                <h3 class="card-title">. . .</h3>
            </div>
            <div class="card-body">
                <div class="datagrid">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@livewireStyles
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/locales/es.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function() {              
        function getBaseUrl() {
            var url = window.location.href;
            var baseUrl = url.split('#')[0];
            return baseUrl;
        }

        function updateUrl(tabId) {
            var newUrl = getBaseUrl() + tabId;
            window.history.replaceState(null, null, newUrl);
        }

        $(window).on('load', function() {
            updateUrl('#tabs-mesas');
        });

        $('.nav-tabs .nav-link').on('click', function(e) {
            e.preventDefault();
            var tabId = $(this).attr('href');
            updateUrl(tabId);
        });
    });
</script>
@livewireScripts
