<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\ProductFormRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Support\Str;




class ProductController extends Controller
{
    public function __construct()
    {

    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = strtolower($request->input('searchText'));

        $productsQuery = Product::join('categories', 'products.category_id', '=', 'categories.id')
            ->select('products.*', 'categories.name AS category')
            
            ->orderBy('products.id', 'desc');

        if ($query) {
            $productsQuery->where(function($queryBuilder) use ($query) {
                $queryBuilder->where('products.name', 'LIKE', '%'.$query.'%')
                            ->orWhere('categories.name', 'LIKE', '%'.$query.'%')
                            ->orWhere('products.code', 'LIKE', '%'.$query.'%')
                            ->orWhere('products.description', 'LIKE', '%'.$query.'%');
            });
        }

        $products = $productsQuery->paginate(10);

        $categories = Category::where('status', 1)->orderBy('name', 'asc')->get();
        
        return view('depot.products.index', [
            'products' => $products, 
            'categories' => $categories, 
            'searchText' => $query
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $categories = Category::where('status', 1)->get();
        return view('depot.products.create', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductFormRequest $request): RedirectResponse
    {
        $product = new Product();
        $product->category_id = $request->get('category_id');
        $product->code = $request->get('code');
        $product->name = $request->get('name');
        $product->stock = $request->get('stock');
        $product->description = $request->get('description');
        $product->status = '1';

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = Str::slug($request->name) . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('public/products', $imageName);

            $product->image = 'storage/' . str_replace('public/', '', $imagePath);
        }

        $product->save();

        return Redirect::to('depot/products')->with('success', 'New Product added successfully!!!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $product_id = $request->get('product_id');
    
        $product = Product::join('categories', 'products.category_id', '=', 'categories.id')
            ->select('products.*', 'categories.name AS category')
            ->where('products.id', '=', $product_id)

            ->first();
        
        if (!$product) {
            return response()->json([
                'status' => false,
                'title' => 'Error Searching',
                'message' => 'Product not found.'
            ], 404);
        }

        $last_sale_price = DB::table('income_detail')
        ->where('product_id', $product_id)
        ->latest('created_at')
        ->value('sale_price');

        $product->sale_price = $last_sale_price;

        return response()->json([
            'status' => true,
            'product' => $product
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product): View
    {
        $categories = Category::where('status', 1)->get();
        return view('depot.products.edit', ['product' => $product, 'categories' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductFormRequest $request, Product $product): RedirectResponse
    {
        $product->category_id = $request->get('category_id');
        $product->code = $request->get('code');
        $product->name = $request->get('name');
        $product->stock = $request->get('stock');
        $product->description = $request->get('description');
        $product->status = '1';

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = Str::slug($request->name) . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('public/products', $imageName);

            $product->image = 'storage/' . str_replace('public/', '', $imagePath);
        }

        $product->update();

        return Redirect::to('depot/products/'. $product->id .'/edit')->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return Redirect::to('depot/products')->with('success', 'Product '. $product->name .' deleted successfully!!!');
    }

    /**
     * Enable/Disable the specified resource from storage.
     */
    public function toggle(Request $request, Product $product): RedirectResponse
    {
        $product->status = ($product->status == '1') ? '0' : '1';
        $message = ($product->status == '1') ? 'enabled' : 'disabled';
        $product->save();

        $page = $request->input('page');

        return Redirect::to('depot/products?page='. $page)->with('success', 'Product '. $product->name .' '.$message.' successfully!!!');
    }

}