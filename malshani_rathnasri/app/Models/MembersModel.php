<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MembersModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'members';
    protected $fillable = [
        'firstName',
        'lastName',
        'dob',
        'ds_division_id',
        'summary'
    ];

    protected $dates = ['deleted_at'];
}
