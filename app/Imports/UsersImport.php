<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel , WithHeadingRow
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
        return new User([
            'name'     => $row['name'],
            'username' => $row['username'],
            'email'    => $row['email'],
            'mobile'   => $row['mobile'],
            'password' => Hash::make($row['password']),
        ]);
    }
}
