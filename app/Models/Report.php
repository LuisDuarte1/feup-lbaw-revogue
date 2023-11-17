<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Report extends Model
{
    use HasFactory;
    
    const CREATED_AT = 'creation_date';

    const UPDATED_AT = null;

    protected $primaryKey = 'id';

    protected $fillable = [
        'type',
        'is_closed',
    ];

    protected $casts = [
        'creation_date' => 'datetime',
        'is_closed' => 'boolean',
    ];

    public function closedBy(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'closed_by');
    }

    public function reporter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reporter');
    }

    public function reported(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reported');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product');
    }

    public function message(): HasOne
    {
        return $this->HasOne(Message::class, 'message');
    }

    protected $table = 'reports';
}
