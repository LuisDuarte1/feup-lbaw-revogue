<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Report extends Model
{
    const CREATED_AT = 'creationDate';

    const UPDATED_AT = null;

    protected $primaryKey = 'id';

    protected $fillable = [
        'type',
        'isClosed',
    ];

    protected $casts = [
        'creationDate' => 'datetime',
        'isClosed' => 'boolean',
    ];

    public function closedBy(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'closedBy');
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

    protected $table = 'Reports';
}
