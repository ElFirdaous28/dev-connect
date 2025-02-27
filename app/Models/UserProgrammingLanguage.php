<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProgrammingLanguage extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'programming_language_id',
    ];

}
