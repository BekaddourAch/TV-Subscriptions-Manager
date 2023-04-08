<?php

namespace App\Exports;

use App\Models\Customer; 
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CustomerExport implements FromCollection , WithHeadings , WithMapping , ShouldAutoSize , WithEvents
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
            return Customer::whereIn('id', $this->selected_rows)->orderBy('name', 'asc')
            ->get();
        } else {
            return Customer::query()
            ->where('firstname', 'like', '%'.$this->search.'%')
            ->orWhere('lastname', 'like', '%'.$this->search.'%')
            ->orWhere('phone1', 'like', '%'.$this->search.'%')
            ->orWhere('email', 'like', '%'.$this->search.'%')
            ->orderBy('id', 'asc')
            ->get();
        }
    }

    public function map($customer) : array {
        return [
            $customer->id,
            $customer->firstname,
            $customer->lastname,
            $customer->phone1,
            $customer->phone2,
            $customer->email,
            $customer->address,
            $customer->state,
            $customer->active,
            $customer->notes,
        ] ;
    }

    public function headings(): array
    {
        return [
            'id',
            'firstname', 
            'lastname', 
            'phone1', 
            'phone2', 
            'email', 
            'address', 
            'state', 
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
