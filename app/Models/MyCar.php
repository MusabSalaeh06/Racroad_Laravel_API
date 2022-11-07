<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MyCar extends Model
{
    use HasFactory;
    protected $primaryKey = 'mycar_id';
    protected $keyType = 'string';
    protected $table = 'my_cars';
    protected $filllable = [
        'mycar_id',
        'user_id',
        'car_id',
        'profile_car',
    ]; 
        
    public function car_data()
    {
        return $this->belongsTo(CarData::class,'car_id','car_id');
    }
    public function user_data()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
