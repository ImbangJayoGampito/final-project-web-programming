<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    // Use the HasFactory trait if you want to use factories for testing
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    // Optionally, specify fillable fields
    protected $fillable = [
        'name',
        'description',
    ];

    // Define relationships (optional)
    public function posts()
    {
        return $this->belongsToMany(Post::class, 'tags_posts');
    }
}
