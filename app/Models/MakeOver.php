<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MakeOver extends Model
{
    use HasFactory;
    protected $primaryKey = 'makeover_id';
    protected $keyType = 'string';
    protected $table = 'make_overs';
    protected $filllable = ['makeover_id','model_id','makeover']; 
}
