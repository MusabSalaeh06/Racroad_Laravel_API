<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarModel extends Model
{
    use HasFactory;
    protected $primaryKey = 'model_id';
    protected $keyType = 'string';
    protected $table = 'models';
    protected $filllable = ['model_id','brand_id','model']; 
}
