<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $primaryKey = 'id_service';
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'cost_price',
        'selling_price',
        'duration_unit',
        'duration',
        'active',
        'notes',
    ];

    public static function getDurationUnits(){
        return [
            1 => "jour",
            2 => "semaine",
            3 => "mois",
            4 => "an",
        ];
    }

    public function getDurationWithUnit(){
        if ($this->duration>1){
            if($this->duration_unit!=3){
                return $this->duration." ".$this->getDurationUnits()[$this->duration_unit]."s";
            }
        }
        return $this->duration." ".$this->getDurationUnits()[$this->duration_unit]; 
    }
}
