<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Technician extends Model
{
    use HasFactory;
    protected $primaryKey = 'tnc_id';
    protected $keyType = 'string';
    protected $table = 'technicians';
    protected $filllable = [
        'tnc_id',
        'tnc_name',
        'user_id',
        'address',
        'tel1',
        'tel2',
        'std_history',
        'service_zone',
        'service_time',
        'service_type',
        'work_history',
        'status',
        'sp_admin'
    ]; 
    
    public function user_data()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
