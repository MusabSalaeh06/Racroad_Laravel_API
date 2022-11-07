<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubVersion extends Model
{
    use HasFactory;
    protected $primaryKey = 'subversion_id';
    protected $keyType = 'string';
    protected $table = 'sub_versions';
    protected $filllable = ['subversion_id','makeover_id','subversion']; 
}
