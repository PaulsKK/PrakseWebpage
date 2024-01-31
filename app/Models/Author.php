<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $table = 'author';

    protected $fillable = [
        'id',
        'name',
        'published_date',
        'publisher_name',
        'category',
        'author',

    ];
}
