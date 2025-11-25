<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function registerProduct(Request $request)
    {
        $validator_products = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        if ($validator_products->fails()) {
            return response()->json(['error' => $validator_products->errors()], 422);
        }

        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
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


    public function update(Request $request, $id)
    {
        Log::info('Update product request', ['id' => $id, 'data' => $request->all()]);
        
        // Busca o produto pelo ID
        $product = Product::find($id);

        if(!$product){
            Log::warning('Product not found', ['id' => $id]);
            return response()->json([
                'error' => true, 
                'message' => 'Produto não encontrado'
            ], 404);
        }

        // Validação - campos opcionais para atualização parcial
        $validator_products = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'price' => 'sometimes|numeric|min:0',
            'stock' => 'sometimes|integer|min:0',
        ]);

        if ($validator_products->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator_products->errors()
            ], 422);
        }

        // Prepara os dados para atualização
        $update_data = [];

        if($request->has('name')){
            $update_data['name'] = $request->name;
        }

        if($request->has('description')){
            $update_data['description'] = $request->description;
        }

        if($request->has('price')){
            $update_data['price'] = $request->price;
        }

        if($request->has('stock')){
            $update_data['stock'] = $request->stock;
        }

        // Atualiza o produto
        $product->update($update_data);
        
        Log::info('Product updated successfully', ['id' => $id, 'updated_data' => $update_data]);

        // Recarrega o produto atualizado
        $product->refresh();

        return response()->json([
            'success' => true,
            'message' => 'Produto atualizado com sucesso',
            'product' => $product,
        ], 200);
    }

    public function delete(Request $request, $id)
    {
    Log::info('Delete product request', ['id' => $id]);

    // Busca o produto pelo ID
    $product = Product::find($id);

    if (!$product) {
        Log::warning('Product not found', ['id' => $id]);
        return response()->json([
            'error' => true,
            'message' => 'Produto não encontrado'
        ], 404);
    }

    // Tenta deletar o produto
    try {
        $product->delete();

        Log::info('Product deleted successfully', ['id' => $id]);

        return response()->json([
            'success' => true,
            'message' => 'Produto deletado com sucesso'
        ], 200);

    } catch (\Exception $e) {
        Log::error('Error deleting product', ['id' => $id, 'error' => $e->getMessage()]);

        return response()->json([
            'error' => true,
            'message' => 'Erro ao tentar deletar o produto'
        ], 500);
        }
    }
}

