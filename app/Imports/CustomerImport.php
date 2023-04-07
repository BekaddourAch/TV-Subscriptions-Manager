<?php

namespace App\Imports;

use App\Models\Customer;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CustomerImport implements ToModel , WithHeadingRow
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
        return new Customer([
            'firstname'     => $row['firstname'],
            'lastname' => $row['lastname'],
            'phone1'    => $row['phone1'],
            'phone2'   => $row['phone2'],
            'email' =>  $row['email'],
            'address'     => $row['address'],
            'state' => $row['state'],
            'active'    => $row['active'],
            'notes'   => $row['notes'],
        ]);
    }
}
