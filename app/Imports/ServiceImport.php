<?php

namespace App\Imports;

use App\Models\Service;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ServiceImport implements ToModel , WithHeadingRow
{
    /**
     * Class constructor.
     */

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Service([
            'name'     => $row['nom'],
            'description' => $row['description'],
            'cost_price'    => $row["cost_price"],
            'selling_price'   => $row['selling_price'],
            'duration' =>  $row['duration'],
            'duration_unit' =>  array_search($row['duration_unit'], Service::getDurationUnits()),
            'active'     => $row['active'],
            'notes' => $row['notes'],
        ]);
    }
}
