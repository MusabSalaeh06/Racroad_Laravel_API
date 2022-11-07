<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarData extends Model
{
    use HasFactory;
    protected $primaryKey = 'car_id';
    protected $keyType = 'string';
    protected $table = 'car_data';
    protected $filllable = [
        'car_id',
        'brand',
        'model',
        'makeover',
        'subversion',
        'fuel',
    ]; 
}
