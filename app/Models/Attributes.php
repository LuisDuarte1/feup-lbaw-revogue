<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;



class Attributes extends Model  {

    use HasFactory;

    const timestamps = false;

    protected $primarykey = 'id';

    protected $fillable = [
        'text',
        'value'
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class,'ProductAttributes', 'product_id' , 'attribute_id');	
    }


    // unique key missing 

    protected $table = 'Attributes';


}