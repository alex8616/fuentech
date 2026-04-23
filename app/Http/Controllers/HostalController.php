<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HostalController extends Controller
{
    public function Hostal(){
        return view('admin.Hostal.Hostal');
    }

    public function Salones(){
        return view('admin.Hostal.Salones');
    }

    public function Huespedes(){
        return view('admin.Hostal.Huespedes');
    }

    public function Inventario(){
        return view('admin.Hostal.Inventario');
    }

    public function MapaLugares(){
        return view('admin.Hostal.MapaLugares');
    }

    public function ViewMapaLugares(){
        return view('admin.Hostal.RegistrarMapaLugares');
    }
}
