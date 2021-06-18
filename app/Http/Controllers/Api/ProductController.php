<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(Category $category)
    {
        $products = Product::active()
            ->ofCategory($category)
            ->get();
        return $this->sendResponse($products);
    }

    /**
     * Display the specified resource.
     *
     * @param Product $product
     * @return JsonResponse
     */
    public function show(Product $product)
    {
        $product->variants = $this->variantsProduct($product);
        $product->options = $this->optionsProduct($product);
        $product->relations = $product->relations()
            ->select('name', 'image')
            ->get();

        return $this->sendResponse($product);
    }

    /**
     * @param Product $product
     * @return \Illuminate\Database\Eloquent\Collection|mixed
     */
    public function variantsProduct(Product $product)
    {
        $product->variants = $product->variants()
            ->select('name', 'price', 'unit_id')
            ->get();

        foreach($product->variants as $variant) {
            $name = $variant->unit->name;
            unset($variant['unit']);
            $variant->unit = $name;
        }

        return $product->variants;
    }

    /**
     * @param Product $product
     * @return mixed
     */
    public function optionsProduct(Product $product)
    {
        $product->options = $product->options()
            ->active()
            ->select('name', 'price')
            ->get();

        foreach($product->options as $option) {
            foreach($option->settings->toArray() as $key => $value) {
                $option->setAttribute($key, $value);
            }
            unset($option['settings']);
        }

        return $product->options;
    }
}
