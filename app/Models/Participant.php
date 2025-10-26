<?php

namespace App\Models;

use App\Models\Category;
use App\Models\Winner;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Participant extends Model
{
    use HasFactory;

    protected $fillable = ['bib_number', 'name', 'is_winner', 'priority', 'priority_category_id'];

    /**
     * The category for which this participant is prioritized (nullable).
     */
    public function priorityCategory()
    {
        return $this->belongsTo(Category::class, 'priority_category_id');
    }

    public function winners()
    {
        return $this->hasMany(Winner::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
