<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $primarykey = 'id';

    protected $fillable = [
        'name'
    ];

    function parentCategory() : BelongsTo{
        return $this->belongsTo(Category::class, 'parent_category');
    }

    function childrenCategory(): HasMany{
        return $this->hasMany(Category::class, 'parent_category');
    }

    protected $table = "categories";
}
