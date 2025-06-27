<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Http\Controllers\ReporteNominaController;
use Illuminate\Http\Request;

class ReporteNominaExport implements FromView
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
        $data = $response->getData(true); // fuerza array asociativo

        return view('reportes.nomina_general_pdf', [
            'reporteLiquidaciones' => $data['reporteLiquidaciones'] ?? collect(),
            'periodo' => $data['periodo'] ?? null,
            'montoTotal' => $data['montoTotal'] ?? 0,
        ]);
    }

}
