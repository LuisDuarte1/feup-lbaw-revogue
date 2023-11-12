<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;


class Messages extends Model
{
    const CREATED_AT = 'sent_date';
    const UPDATED_AT = null;

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'sentDate',
        'message_Type',
        'textContent',
        'imagePath',
        'proposedPrice',
        'bargainStatus',
        'fromUser',
        'toUser',
        'subjectProduct'
    ];


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'sentDate' => 'datetime',
        'proposedPrice' => 'double',
    ];

    public function fromUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'fromUser');
    }

    public function toUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'toUser');
    }

    public function subjectProduct(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'subjectProduct');
    }

    public function voucher(): HasOne
    {
        return $this->hasOne(Vouchers::class, 'bargainMessage');
    }

    public function notification(): HasOne
    {
        return $this->hasOne(Notifications::class, 'message');
    }
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'Messages';

}