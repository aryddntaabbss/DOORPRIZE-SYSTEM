<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'total_winners'];

    public function winners()
    {
        return $this->hasMany(Winner::class);
    }
    public function participants()
    {
        return $this->hasMany(Participant::class);
    }
}
