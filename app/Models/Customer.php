<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = [
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

    public static function countCustomers($beginDate = null, $endDate = null)
    {
        $query = self::query();

        if ($beginDate && $endDate) {
            $beginDate = Carbon::parse($beginDate)->startOfDay();
            $endDate = Carbon::parse($endDate)->endOfDay();
            $query->whereRaw ("created_at >= '".$beginDate."'");
            $query->whereRaw ("created_at <= '".$endDate."'");
        }

        return $query->count();
    }
}
