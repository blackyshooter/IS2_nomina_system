<?php
namespace App\Exports;

use App\Models\Empleado;
use App\Services\NominaService;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class NominaExport implements FromCollection, WithHeadings
{
    protected $service;

    public function __construct(NominaService $service)
    {
        $this->service = $service;
    }

    public function collection()
    {
        return Empleado::with('persona')->get()->map(fn($e) => collect($this->service->calcularNominaEmpleado($e)));
    }

    public function headings(): array
    {
        return ['Nombre', 'Sueldo Base', 'Bonificación', 'IPS', 'Salario Neto'];
    }
}
