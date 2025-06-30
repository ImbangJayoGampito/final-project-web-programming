<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // If your table name is not the plural "categories", specify it:
    protected $table = 'categories';

    // Optionally, specify fillable fields
    protected $fillable = [
        'name',
        'description',
    ];
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
