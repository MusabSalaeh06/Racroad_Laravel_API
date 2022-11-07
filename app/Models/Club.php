<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    use HasFactory;
    protected $primaryKey = 'club_id';
    protected $keyType = 'string';
    protected $table = 'clubs';
    protected $filllable = [
        'club_id',
        'user_id',
        'club_name',
        'club_zone',
        'description',
        'status',
        'sp_admin'
    ]; 
    
    public function admin()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
