<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Compra;
use App\Models\CompraItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportesController extends Controller
{
    public function index()
    {
        return view('admin.reportes.index');
    }

    public function informe_ventas () 
    {
        $compras = DB::table('compra')
            ->join('users','compra.id_user','=','users.id')
            ->join('tiposuario','users.tipo','=','tiposuario.id')
            ->select('compra.*','users.name','tiposuario.tipo')
            ->distinct('compra.id')
            ->get();

        return view('admin.reportes.informe-ventas', compact('compras'));
    }

    public function ventas_by_anio( Request $request )
    {
        $month = 0;
        if ($request->month == 'enero') {
            $month = 1;
        } elseif ($request->month == 'febrero'){
            $month = 2;
        } elseif ($request->month == 'marzo'){
            $month = 3;
        } elseif ($request->month == 'abril'){
            $month = 4;
        } elseif ($request->month == 'mayo'){
            $month = 5;
        } elseif ($request->month == 'junio'){
            $month = 6;
        } elseif ($request->month == 'julio'){
            $month = 7;
        } elseif ($request->month == 'agosto'){
            $month = 8;
        } elseif ($request->month == 'septiembre'){
            $month = 9;
        } elseif ($request->month == 'octubre'){
            $month = 10;
        } elseif ($request->month == 'noviembre'){
            $month = 11;
        } elseif ($request->month == 'diciembre'){
            $month = 12;
        } else {
            $month = 0;
        }

        if ($month != 0) {
            $compras = Compra::select('preciototal', 'created_at')
            ->whereYear('created_at', '=', $request->anio)
            ->whereMonth('created_at', '=', $month)
            ->get()
            ->groupBy(function($date) {
                return Carbon::parse($date->created_at)->format('m');
            });
        } else {
            $compras = Compra::select('preciototal', 'created_at')
            ->whereYear('created_at', '=', $request->anio)
            ->get()
            ->groupBy(function($date) {
                return Carbon::parse($date->created_at)->format('m');
            });
        }

        $total_01 = 0;
        $total_02 = 0;
        $total_03 = 0;
        $total_04 = 0;
        $total_05 = 0;
        $total_06 = 0;
        $total_07 = 0;
        $total_08 = 0;
        $total_09 = 0;
        $total_10 = 0;
        $total_11 = 0;
        $total_12 = 0;
        foreach ($compras as $key => $items) {
            if ($key == "01") {
                foreach ($items as $item) {
                    $total_01 = $total_01 + $item->preciototal;
                }
            }
            if ($key == "02") {
                foreach ($items as $item) {
                    $total_02 = $total_02 + $item->preciototal;
                }
            }
            if ($key == "03") {
                foreach ($items as $item) {
                    $total_03 = $total_03 + $item->preciototal;
                }
            }
            if ($key == "04") {
                foreach ($items as $item) {
                    $total_04 = $total_04 + $item->preciototal;
                }
            }
            if ($key == "05") {
                foreach ($items as $item) {
                    $total_05 = $total_05 + $item->preciototal;
                }
            }
            if ($key == "06") {
                foreach ($items as $item) {
                    $total_06 = $total_06 + $item->preciototal;
                }
            }
            if ($key == "07") {
                foreach ($items as $item) {
                    $total_07 = $total_07 + $item->preciototal;
                }
            }
            if ($key == "08") {
                foreach ($items as $item) {
                    $total_08 = $total_08 + $item->preciototal;
                }
            }
            if ($key == "09") {
                foreach ($items as $item) {
                    $total_09 = $total_09 + $item->preciototal;
                }
            }
            if ($key == "10") {
                foreach ($items as $item) {
                    $total_10 = $total_10 + $item->preciototal;
                }
            }
            if ($key == "11") {
                foreach ($items as $item) {
                    $total_11 = $total_11 + $item->preciototal;
                }
            }
            if ($key == "12") {
                foreach ($items as $item) {
                    $total_12 = $total_12 + $item->preciototal;
                }
            }
        }
        
        $meses   = [];
        $valores = [];

        if ($total_01 != 0) {
            array_push($meses, "Enero");
            array_push($valores, $total_01);
        }

        if ($total_02 != 0) {
            array_push($meses, "Febrero");
            array_push($valores, $total_02);
        }

        if ($total_03 != 0) {
            array_push($meses, "Marzo");
            array_push($valores, $total_03);
        }

        if ($total_04 != 0) {
            array_push($meses, "Abril");
            array_push($valores, $total_04);
        }

        if ($total_05 != 0) {
            array_push($meses, "Mayo");
            array_push($valores, $total_05);
        }

        if ($total_06 != 0) {
            array_push($meses, "Junio");
            array_push($valores, $total_06);
        }

        if ($total_07 != 0) {
            array_push($meses, "Julio");
            array_push($valores, $total_07);
        }

        if ($total_08 != 0) {
            array_push($meses, "Agosto");
            array_push($valores, $total_08);
        }

        if ($total_09 != 0) {
            array_push($meses, "Septiembre");
            array_push($valores, $total_09);
        }

        if ($total_10 != 0) {
            array_push($meses, "Octubre");
            array_push($valores, $total_10);
        }

        if ($total_11 != 0) {
            array_push($meses, "Noviembre");
            array_push($valores, $total_11);
        }

        if ($total_12 != 0) {
            array_push($meses, "Diciembre");
            array_push($valores, $total_12);
        }

        $total = $total_01 + $total_02 + $total_03 + $total_04 + $total_05 + $total_06 + $total_07 + $total_08 + $total_09 + $total_10 + $total_11 + $total_12;
        
        $compras_all = Compra::select('preciototal')->get();
        $total_all = $compras_all->sum('preciototal');

        return response()->json([
            'meses'     => $meses,
            'valores'   => $valores,
            'total'     => $total,
            'total_all' => $total_all
        ]);
    }

    public function mas_vendidos() 
    {
        $mas_vendidos = CompraItem::selectRaw('productos.nombre, sum(compra_item.cantidad) AS cantidad')
            ->join('productos', 'compra_item.id_producto', '=', 'productos.id')
            ->orderByRaw('sum(compra_item.cantidad) DESC')
            ->groupBy('productos.nombre')
            ->limit(5)
            ->get();

        return response()->json([
            'productos' => $mas_vendidos
        ]);
    }

    public function get_results( Request $request ) 
    {
        $fecha_ini = $request->fecha_ini . '00:00:00';
        $fecha_fin = $request->fecha_fin . '23:59:59';

        $compras = Compra::whereBetween('created_at', [$fecha_ini, $fecha_fin])->get();
        $total = $compras->sum('preciototal');

        return redirect()->route('reportes.index', compact('compras', 'total'));
    }
}
