<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Added to define Eloquent relationships.
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    // Don't add create and update timestamps in database.
    const CREATED_AT = "creation_date";
    const UPDATED_AT = null;

    protected $primaryKey = 'id';
    protected $fillable = [
        'slug',
        'name',
        

    /**
     * Get the card where the item is included.
     */
    public function card(): BelongsTo
    {
        return $this->belongsTo(Card::class);
    }
}