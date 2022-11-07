<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberClub extends Model
{
    use HasFactory;
    protected $primaryKey = 'memc_id';
    protected $keyType = 'string';
    protected $table = 'member_clubs';
    protected $filllable = [
        'memc_id',
        'club_id',
        'user_id',
        'role',
        'status',
    ]; 
    
    public function memclub()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function club_detail()
    {
        return $this->belongsTo(Club::class,'club_id','club_id');
    }
}
