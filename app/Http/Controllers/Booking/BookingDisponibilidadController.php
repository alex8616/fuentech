<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BookingDisponibilidadHabitacion;
use App\Models\CategoriaHabitacion; 
use App\Models\TipoHabitacion; 
use Carbon\Carbon;

class BookingDisponibilidadController extends Controller
{
    public function index()
    {
        return view('booking.calendario');
    }

    
}
