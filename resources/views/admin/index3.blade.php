@extends('layouts.my-dashboard-layout')

@section('content')
    <div class="row" style="background: orange;">
        <div class="col-12 col-sm-12">
            <div id='list-calendar'></div>
            <h1>3</h1>
        </div>
        <div class="col-12 col-sm-12">
            <br><br>
            <div id='calendar'></div>
            <h1>3</h1>
        </div>
    </div>
@endsection

<link rel="stylesheet" href="https://unpkg.com/fullcalendar-scheduler@5.8.0/main.min.css">
<link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css' rel='stylesheet' />
<style>

</style>
@livewireStyles

<script src='https://unpkg.com/fullcalendar-scheduler@5.8.0/main.min.js'></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.8.0/locales-all.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@livewireScripts
