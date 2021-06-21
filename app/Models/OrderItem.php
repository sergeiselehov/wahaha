<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class OrderItem extends Pivot
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'order_items';
    protected $with = ['product', 'variant'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'variant_id',
        'product_id',
        'order_id',
        'created_at',
        'updated_at',
    ];

    /**
     * Get the options associated with the order item.
     */
    public function options()
    {
        return $this->hasMany(OrderItemOption::class, 'order_item_id', 'id');
    }

    /**
     * Get the product associated with the order.
     */
    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    /**
     * Get the variant associated with the order.
     */
    public function variant()
    {
        return $this->hasOne(Variant::class, 'id', 'variant_id');
    }
}
