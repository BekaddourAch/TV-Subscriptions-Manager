<?php

namespace App\Exports;

use App\Models\Service;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ServiceExport implements FromCollection , WithHeadings , WithMapping , ShouldAutoSize , WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $search;
    protected $selected_rows;

    function __construct($search,$selectedRows) {
        $this->search = $search;
        $this->selected_rows = $selectedRows;
    }

    public function collection()
    {
        //dd($this->search,$this->selected_rows);
        // return User::all();
        if ($this->selected_rows) {
            return Service::whereIn('id', $this->selected_rows)->orderBy('name', 'asc')
            ->get();
        } else {
            return Service::query()
            ->where('name', 'like', '%'.$this->search.'%')
            ->orWhere('description', 'like', '%'.$this->search.'%')
            ->orderBy('id', 'asc')
            ->get();
        }
    }

    public function map($service) : array {
        return [
            $service->id,
            $service->name,
            $service->description,
            $service->cost_price,
            $service->selling_price,
            $service->duration,
            Service::getDurationUnits()[$service->duration_unit],
            $service->active,
            $service->notes,
        ] ;
    }

    public function headings(): array
    {
        return [
            'id',
            'nom',
            'description',
            "cost_price",
            'selling_price',
            'duration',
            'duration_unit',
            'active',
            'notes',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:J1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
                $event->sheet->getDelegate()->getStyle($cellRange)->applyFromArray(
                    array(
                       'font'  => array(
                           'bold'  =>  true,
                       )
                    )
                  );
            },
        ];
    }
}
