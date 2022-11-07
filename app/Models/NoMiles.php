<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoMiles extends Model
{
    use HasFactory;
    protected $primaryKey = 'nm_id';
    protected $keyType = 'string';
    protected $table = 'no_miles';
    protected $filllable = [
        'nm_id',
        'mycar_id',
        'no_miles',
    ]; 
    
    public function mycar_data()
    {
        return $this->belongsTo(MyCar::class,'mycar_id','mycar_id');
    }
}
