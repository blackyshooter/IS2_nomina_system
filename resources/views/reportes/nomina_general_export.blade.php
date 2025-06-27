<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Http\Request;
use App\Http\Controllers\ReporteNominaController;

class ReporteNominaExport_excel implements FromView
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $controller = new ReporteNominaController();
        $response = $controller->index($this->request);
        $data = $response->getData();

        return view('reporte.nomina.excel', [
            'reporteLiquidaciones' => $data->reporteLiquidaciones,
            'periodo' => $data->periodo,
            'montoTotal' => $data->montoTotal,
        ]);
    }
}

