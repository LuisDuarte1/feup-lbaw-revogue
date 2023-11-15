<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// Added to define Eloquent relationships.
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    const CREATED_AT = 'creationDate';

    const UPDATED_AT = null;

    /**
     * The primary key associated with the table.
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'displayName',
        'email',
        'password',
        'settings',
        'profileImagePath',
        'bio',
        'accountStatus',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'settings',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'creationDate' => 'datetime',
        'password' => 'hashed',
        'settings' => 'array',
    ];

    public function messagesFrom(): HasMany
    {
        return $this->hasMany(Message::class, 'fromUser');
    }

    public function messagesTo(): HasMany
    {
        return $this->hasMany(Message::class, 'toUser');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'soldBy');
    }

    public function voucher(): HasOne
    {

        return $this->hasOne(Voucher::class, 'belongsTo');
    }

    public function reviewing(): HasMany
    {
        return $this->hasMany(Review::class, 'reviewer');
    }

    public function reviewed(): HasMany
    {
        return $this->hasMany(Review::class, 'reviewed');
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class, 'belongsTo');
    }

    public function reporter(): HasMany
    {
        return $this->hasMany(Report::class, 'reporter');
    }

    public function reported(): HasMany
    {
        return $this->hasMany(Report::class, 'reported');
    }

    public function cart(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)->using(CartProduct::class);
    }

    /*
    public function wishlist(): HasOne
    {
        return $this->hasOne(ProductWishlist::class, 'belongsTo');
    }
    */
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'Users';
}
