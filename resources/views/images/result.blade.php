@extends('layouts.my-dashboard-layout')

@section('content')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<div class="container">
    <h1>Resultados del análisis</h1>

    @if(!empty($results))
        @foreach($results as $result)
            <div class="card mb-3">
                <div class="card-header">
                    {{ $result['name'] }}
                </div>
                <div class="card-body">
                    <p>{{ $result['text'] }}</p>
                </div>
            </div>
        @endforeach
    @else
        <p>No se procesaron imágenes.</p>
    @endif

    <a href="{{ route('images.index') }}" class="btn btn-secondary">Volver</a>
</div>
@endsection
