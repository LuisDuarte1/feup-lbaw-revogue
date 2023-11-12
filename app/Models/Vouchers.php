<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Vouchers extends Model 
{
    const timestamps = false;

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

     protected $fillable = [
        'code',
        'belongsTo',
        'product',
        'bargainMessage'
     ];

     protected $casts = [
        'belongsTo' => 'integer',
        'product' => 'integer',
        'bargainMessage' => 'integer'
        ];

        /**
        * The attributes that should be cast.
        *
        * @var array<string, string>
        */

        protected $hidden = [
            'code',
            'bargainMessage'
        ];

        public function belongsTo(): BelongsTo
        {
            return $this->belongsTo(User::class, 'belongsTo');
        }

        public function product(): BelongsTo
        {
            return $this->belongsTo(Product::class, 'product');
        }

        public function bargainMessage(): HasOne
        {
            return $this->hasOne(Messages::class, 'bargainMessage');
        }


        protected $table = 'Vouchers';
}