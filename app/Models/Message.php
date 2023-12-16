<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Message extends Model
{
    use HasFactory;

    const CREATED_AT = 'sent_date';

    const UPDATED_AT = null;
    protected $dateFormat = 'Y-m-d H:i:s.u';

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'message_type',
        'text_content',
        'image_path',
        'proposed_price',
        'bargain_status',
        'to_user',
        'message_thread'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'sent_date' => 'datetime',
        'proposed_price' => 'float',
        'image_path' => 'array'
    ];

    public function fromUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'from_user');
    }

    public function toUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'to_user');
    }

    public function voucher(): HasOne
    {
        return $this->hasOne(Voucher::class, 'bargain_message');
    }

    public function notification(): HasOne
    {
        return $this->hasOne(Notification::class, 'message');
    }

    public function messageReport(): BelongsTo
    {
        return $this->belongsTo(Report::class, 'message');
    }

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'messages';
}
