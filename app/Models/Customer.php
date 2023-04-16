<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_customer';
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
}
