<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\ProductFormRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Illuminate\Support\Str;




class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            
            if (!Gate::allows('Show Products')) {
                abort(403);
            }
    
            return $next($request);
        })->only('index');

        $this->middleware(function ($request, $next) {
            
            if (!Gate::allows('Edit Products')) {
                abort(403);
            }
    
            return $next($request);
        })->only(['edit', 'show']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = strtolower($request->input('searchText'));

        $productsQuery = Product::with('category')
            ->orderBy('id', 'desc');

        if ($query) {
            $productsQuery->where(function($queryBuilder) use ($query) {
                $queryBuilder->where('name', 'LIKE', '%'.$query.'%')
                            ->orWhereHas('category', function($q) use ($query) {
                                $q->where('name', 'LIKE', '%'.$query.'%');
                            })
                            ->orWhere('code', 'LIKE', '%'.$query.'%')
                            ->orWhere('description', 'LIKE', '%'.$query.'%');
            });
        }

        $products = $productsQuery->paginate(5);

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

            try {
                // Asegurarse de que el directorio existe
                $directory = storage_path('app/public/products');
                if (!file_exists($directory)) {
                    mkdir($directory, 0755, true);
                }

                // Mover la imagen directamente
                $destinationPath = $directory . '/' . $imageName;
                $moved = $image->move($directory, $imageName);

                if ($moved) {
                    \Log::info('Imagen movida exitosamente', ['path' => $destinationPath]);
                    $product->image = 'products/' . $imageName;
                } else {
                    \Log::error('Error al mover la imagen');
                    throw new \Exception('No se pudo mover la imagen');
                }
            } catch (\Exception $e) {
                \Log::error('Error al guardar la imagen', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
            }
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
    
        $product = Product::findOrFail($product_id);
        
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

            try {
                // Asegurarse de que el directorio existe
                $directory = storage_path('app/public/products');
                if (!file_exists($directory)) {
                    mkdir($directory, 0755, true);
                }

                // Mover la imagen directamente
                $destinationPath = $directory . '/' . $imageName;
                $moved = $image->move($directory, $imageName);

                if ($moved) {
                    \Log::info('Imagen movida exitosamente', ['path' => $destinationPath]);
                    $product->image = 'products/' . $imageName;
                } else {
                    \Log::error('Error al mover la imagen');
                    throw new \Exception('No se pudo mover la imagen');
                }
            } catch (\Exception $e) {
                \Log::error('Error al guardar la imagen', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
            }
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