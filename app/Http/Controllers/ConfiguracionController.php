<?php

namespace App\Http\Controllers;

use App\Models\Configuracion;
use Illuminate\Http\Request;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printers\Printer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ConfiguracionController extends Controller
{

    public function listarImpresoras() {
        $sistema_operativo = php_uname('s');
        $impresoras = [];
    
        if (strpos($sistema_operativo, 'Windows') !== false) {
            exec('wmic printer get name, status, location, drivername, portname', $output);
            foreach ($output as $line) {
                $line = trim($line);
                if (!empty($line) && $line !== 'Name' && $line !== 'Status' && $line !== 'Location' && $line !== 'DriverName' && $line !== 'PortName') {
                    // Utiliza explode para dividir la línea y toma solo la primera parte (el nombre de la impresora)
                    $printerName = explode(' ', $line)[0];
                    $impresoras[] = [
                        'name' => $printerName,
                        'status' => null,
                        'location' => null,
                        'driver' => null,
                        'port' => null,
                        'configuration' => []
                    ];
                } elseif (strpos($line, 'Status') !== false) {
                    $impresoras[count($impresoras) - 1]['status'] = trim(substr($line, strpos($line, 'Status') + strlen('Status')));
                } elseif (strpos($line, 'Location') !== false) {
                    $impresoras[count($impresoras) - 1]['location'] = trim(substr($line, strpos($line, 'Location') + strlen('Location')));
                } elseif (strpos($line, 'DriverName') !== false) {
                    $impresoras[count($impresoras) - 1]['driver'] = trim(substr($line, strpos($line, 'DriverName') + strlen('DriverName')));
                } elseif (strpos($line, 'PortName') !== false) {
                    $impresoras[count($impresoras) - 1]['port'] = trim(substr($line, strpos($line, 'PortName') + strlen('PortName')));
                }
            }
            // Obtener configuración de impresora
            foreach ($impresoras as &$impresora) {
                exec('wmic printerconfig where name="' . $impresora['name'] . '" get /value', $config_output);
                foreach ($config_output as $config_line) {
                    $config_line = trim($config_line);
                    if (!empty($config_line)) {
                        list($key, $value) = explode("=", $config_line);
                        $impresora['configuration'][$key] = $value;
                    }
                }
            }
        } elseif (strpos($sistema_operativo, 'Darwin') !== false) {
            exec('lpstat -p -l', $output);
            foreach ($output as $line) {
                $line = trim($line);
                if (!empty($line) && strpos($line, 'printer ') === 0) {
                    $printer_name = substr($line, strlen('printer '));
                    $impresoras[] = [
                        'name' => $printer_name,
                        'status' => null,
                        'location' => null,
                        'driver' => null,
                        'port' => null,
                        'configuration' => []
                    ];
                    exec('lpoptions -p ' . $printer_name . ' -l', $options_output);
                    foreach ($options_output as $option_line) {
                        $option_line = trim($option_line);
                        if (!empty($option_line)) {
                            $impresoras[count($impresoras) - 1]['configuration'][] = $option_line;
                        }
                    }
                } elseif (strpos($line, 'is idle') !== false) {
                    $printer_status = trim(substr($line, 0, strpos($line, ' is idle')));
                    $impresoras[count($impresoras) - 1]['status'] = $printer_status;
                } elseif (strpos($line, 'Location:') !== false) {
                    $printer_location = trim(substr($line, strpos($line, 'Location:') + strlen('Location:')));
                    $impresoras[count($impresoras) - 1]['location'] = $printer_location;
                }
            }
        } else {
            response("NOCE DETECTO EL SISTEMA OPERATIVO");
        }
    
        return response()->json($impresoras);
    }
    
    public function RegistrarImpresora(Request $request){
        $user = Auth::user(); 

        if ($user) {
            $Impresora = Configuracion::create([
                'NombreImpresora' => $request->nombreImpresora,
                'empresa_id' => $user->empresa_id,
            ]);
            return response()->json($Impresora);
        } else {
            return response()->json("user No INICIADO SESSION");
        }        
        
    }

    public function eliminarImpresora($id){
        $impresora = Configuracion::find($id);
        if ($impresora) {
            $impresora->delete();
            return response()->json(['success' => true, 'message' => 'Impresora eliminada correctamente']);
        } else {
            return response()->json(['success' => false, 'message' => 'No se encontró la impresora']);
        }
    }

    public function obtenerCountImpresoras(){
        $user = Auth::user();
        $CountImpresora = Configuracion::where('empresa_id',$user->empresa_id)->get();
        return response()->json($CountImpresora);
    }

    public function ImpresionDate($id){
        $impresora = Configuracion::find($id);
        return response()->json($impresora);
    }

}
