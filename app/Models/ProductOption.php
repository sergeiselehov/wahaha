<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductOption extends Pivot
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'product_options';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'default_amount',
        'max_amount',
        'min_amount',
        'required'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'product_id',
        'option_id',
        'created_at',
        'updated_at',
    ];

    /**
     * Get the options associated with the order item.
     */
    public function option()
    {
        return $this->hasOne(Option::class, 'id', 'option_id');
    }
}
