<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Report extends Model
{
    use HasFactory;

    const CREATED_AT = 'creation_date';

    const UPDATED_AT = null;

    protected $primaryKey = 'id';

    protected $fillable = [
        'type',
        'is_closed',
        'reason',
        'closed_by',
        'reporter',
        'reported',
        'product',
        'message_thread',
        'user',
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

    public function messageThread(): BelongsTo
    {
        return $this->belongsTo(MessageThread::class, 'message_thread');
    }

    protected $table = 'reports';
}
