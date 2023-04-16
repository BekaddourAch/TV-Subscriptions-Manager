<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; 

class Subscription extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_subscription';
    
    protected $fillable = [
        'id_service',
        'id_customer',
        'id_user',
        'cost_price',
        'quantity',
        'selling_price',
        'begin_date',
        'end_date',
        'total',
        'notes'
    ];

    public function Service(){
        return $this->belongsTo(Service::class,'id_service');
    }
    
    public function Customer(){
        return $this->belongsTo(Customer::class,'id_customer');
    }
    public function User(){
        return $this->belongsTo(User::class,'id_user');
    }
 
} 