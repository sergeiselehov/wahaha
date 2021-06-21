<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class OrderItemOption extends Pivot
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'order_item_options';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'option_id',
        'order_item_id',
        'created_at',
        'updated_at',
    ];

    /**
     * Get the option associated with the order item.
     */
    public function rule_option()
    {
        return $this->hasOne(ProductOption::class, 'id', 'product_option_id');
    }

//    /**
//     * Get the options associated with the product.
//     */
//    public function option()
//    {
//        return $this->belongsToMany(Option::class, 'product_options', 'option_id')
//            ->using(ProductOption::class)
//            ->as('settings')
//            ->withPivot(['default_amount', 'max_amount', 'min_amount', 'required']);
//    }
}
