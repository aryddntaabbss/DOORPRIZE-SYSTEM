<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Participant extends Model
{
    use HasFactory;

    protected $fillable = ['bib_number', 'name', 'is_winner'];

    public function winners()
    {
        return $this->hasMany(Winner::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
