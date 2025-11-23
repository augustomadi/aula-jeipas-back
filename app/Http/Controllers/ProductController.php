<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function registerProduct(Request $request0)
    {
        $validator_products = Validator::make($request0->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        if ($validator_products->fails()) {
            return response()->json(['error' => $validator_products->errors()], 422);
        }

        $product = Product::create([
            'name' => $request0->name,
            'description' => $request0->description,
            'price' => $request0->price,
            'stock' => $request0->stock,
        ]);

        return response()->json([
            'message' => 'Product created successfully',
            'product' => $product,
        ], 201);
    }

    public function index()
    {
        $products = Product::all();

        return response()->json([
            'products' => $products,
        ], 200);
    }
}
