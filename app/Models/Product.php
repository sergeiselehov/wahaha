<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'image',
        'category_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'pivot',
        'created_at',
        'updated_at',
    ];

    /**
     * Get the category associated with the product.
     */
    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    /**
     * Get the variants associated with the product.
     */
    public function variants()
    {
        return $this->hasMany(Variant::class, 'product_id', 'id');
    }

    /**
     * Get the options associated with the product.
     */
    public function options()
    {
        return $this->belongsToMany(Option::class, 'product_options')
            ->using(ProductOption::class)
            ->as('settings')
            ->withPivot(['default_amount', 'max_amount', 'min_amount', 'required']);
    }

    /**
     * Get the options associated with the product.
     */
    public function relations()
    {
        return $this->belongsToMany(Product::class, 'product_relations', 'product_id', 'related_product_id')
            ->using(ProductRelation::class);
    }

    /**
     * Scope a query to only include active categories.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    /**
     * Scope a query to only include products of a given category.
     *
     * @param Builder $query
     * @param Category $category
     * @return Builder
     */
    public function scopeOfCategory($query, Category $category)
    {
        return $query->where('category_id', $category->id);
    }
}
