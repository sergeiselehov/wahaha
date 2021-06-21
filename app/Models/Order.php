<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'orders';

//    /**
//     * The attributes that are mass assignable.
//     *
//     * @var array
//     */
//    protected $fillable = [
//        'status'
//    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'user_id',
        'updated_at',
    ];

    /**
     * Get the item associated with the order.
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }

    /**
     * Scope a query to only include active categories.
     *
     * @param Builder $query
     * @param User $user
     * @return Builder
     */
    public function scopeUser(Builder $query, User $user)
    {
        return $query->where('user_id', $user->id);
    }

    /**
     * Get the total price.
     *
     * @return string
     */
    public function getTotalPriceAttribute()
    {

        $price = 0;
        foreach($this->items as $item) {
            $price += $item->variant->price;
            foreach($item->options as $item_option) {
                if(empty($item_option->rule_option->default_amount)) {
                    $price += $item_option->amount * $item_option->rule_option->option->price;
                }
            }
        }

        return $price;
    }
}
