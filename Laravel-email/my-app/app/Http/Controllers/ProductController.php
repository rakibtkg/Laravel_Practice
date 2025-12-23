<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Excel;

class ProductController extends Controller
{
    
    public function index(): JsonResponse
    {
        $products = Product::orderBy('created_at', 'desc')->get();
        
        return response()->json([
            'success' => true,
            'message' => 'Products retrieved successfully',
            'data' => $products
        ], 200);
    }




    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $product = Product::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Product created successfully',
            'data' => $product
        ], 201);
    }

   
    public function show(string $id): JsonResponse
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Product retrieved successfully',
            'data' => $product
        ], 200);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'sometimes|required|numeric|min:0',
            'stock' => 'sometimes|required|integer|min:0',
        ]);

        $product->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Product updated successfully',
            'data' => $product
        ], 200);
    }

 
    public function destroy(string $id): JsonResponse
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }

        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully'
        ], 200);
    }


    public function indexPage()
    {
        $products = Product::orderBy('created_at', 'desc')->get();
        return view('products.index', compact('products'));
    }

    public function report()
    {
        $products = Product::orderBy('created_at', 'desc')->get();
        return view('products.report', compact('products'));
    }

    public function exportExcel()
    {
        $products = Product::orderBy('created_at', 'desc')->get();
        
        // Prepare data for Excel
        $data = [
            ['ID', 'Name', 'Description', 'Price', 'Stock', 'Created At', 'Updated At']
        ];
        
        foreach ($products as $product) {
            $data[] = [
                $product->id,
                $product->name,
                $product->description,
                $product->price,
                $product->stock,
                $product->created_at->format('Y-m-d H:i:s'),
                $product->updated_at->format('Y-m-d H:i:s'),
            ];
        }
        
        // Create Excel file
        Excel::create('Products_' . date('Y-m-d_His'), function($excel) use ($data) {
            $excel->sheet('Products', function($sheet) use ($data) {
                $sheet->fromArray($data, null, 'A1', false, false);
                
                // Style the header row
                $sheet->row(1, function($row) {
                    $row->setFontWeight('bold');
                    $row->setBackground('#4CAF50');
                    $row->setFontColor('#ffffff');
                });
                
                // Auto-size columns
                $sheet->setAutoSize(true);
            });
        })->export('xlsx');
    }
}
