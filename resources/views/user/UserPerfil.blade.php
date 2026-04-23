@extends('layouts.my-dashboard-layout')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="card">
    <div class="row g-0">
        <div class="col-2 d-none d-md-block border-end">
            <div class="card-body">
                <h4 class="subheader">Mi Cuenta ...</h4>
                <div class="list-group list-group-transparent">
                    <ul class="nav nav-tabs flex-column me-3" id="myTab" role="tablist">
                    <li class="list-group-item list-group-item-action d-flex align-items-center" role="presentation">
                        <a href="#tabs-home-5" class="list-group-item list-group-item-action d-flex align-items-center" data-bs-toggle="tab" role="tab" aria-selected="true">Home</a>
                    </li>
                    <li class="list-group-item list-group-item-action d-flex align-items-center" role="presentation">
                        <a href="#tabs-profile-5" class="list-group-item list-group-item-action d-flex align-items-center" data-bs-toggle="tab" role="tab" aria-selected="false">Profile</a>
                    </li>
                    <li class="list-group-item list-group-item-action d-flex align-items-center" role="presentation">
                        <a href="#tabs-activity-5" class="list-group-item list-group-item-action d-flex align-items-center" data-bs-toggle="tab" role="tab" aria-selected="false">Asistencia</a>
                    </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col d-flex flex-column">
            <div class="tab-content flex-grow-1">
            <div class="tab-pane" id="tabs-home-5" role="tabpanel" style="background: white; padding: 20px">
                <h4>Home tab</h4>
                <p>Cursus turpis vestibulum, dui in pharetra vulputate id sed non turpis ultricies fringilla at sed facilisis lacus pellentesque purus nibh</p>
            </div>
            <div class="tab-pane" id="tabs-profile-5" role="tabpanel" style="background: white; padding: 20px">
                <h4>Profile tab</h4>
                <p>Fringilla egestas nunc quis tellus diam rhoncus ultricies tristique enim at diam, sem nunc amet, pellentesque id egestas velit sed</p>
            </div>
            <div class="tab-pane" id="tabs-activity-5" role="tabpanel" style="background: white; padding: 20px">
                @include('user.Asitencia')
            </div>
            </div> 
        </div>
    </div>
</div>
@endsection

@livewireStyles
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@livewireScripts
