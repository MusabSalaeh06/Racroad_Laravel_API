<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UpgradeCar extends Model
{
    use HasFactory;
    protected $primaryKey = 'upgc_id';
    protected $keyType = 'string';
    protected $table = 'upgrade_cars';
    protected $filllable = [
        'upgc_id',
        'mycar_id',
        'type',
        'date',
    ]; 
    
    public function mycar_data()
    {
        return $this->belongsTo(MyCar::class,'mycar_id','mycar_id');
    }
}
