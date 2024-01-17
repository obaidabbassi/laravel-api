<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentModel extends Model
{
    protected $table = 'students';
    protected $fillable = [
        'name',
        'email',
        'password',
        'education',
        'address',
        'age',
        'gender',
        'contact',

        'picture'

    ];



    use HasFactory;
}
