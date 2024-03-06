<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\ProductFormRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;




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
            ->select('products.*', 'categories.category AS category')
            
            ->orderBy('products.id', 'desc');

        if ($query) {
            $productsQuery->where(function($queryBuilder) use ($query) {
                $queryBuilder->where('products.name', 'LIKE', '%'.$query.'%')
                            ->orWhere('categories.category', 'LIKE', '%'.$query.'%')
                            ->orWhere('products.code', 'LIKE', '%'.$query.'%')
                            ->orWhere('products.description', 'LIKE', '%'.$query.'%');
            });
        }

        $products = $productsQuery->paginate(10);

        $categories = Category::where('status', 1)->orderBy('category', 'asc')->get();

        // dd($products);
        
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
    public function show(Product $product): View
    {
        return view('depot.products.show', ['product' => $product]);
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

    public function export(Request $request)
    {
        $exportType = $request->input('export_type', 'csv');

        $products = Product::join('categories', 'products.category_id', '=', 'categories.id')
        ->select('products.id', 'products.name', 'categories.category AS category', 'products.code', 'products.stock', 'products.description', 'products.image')
        ->get();

        if ($exportType === 'csv') {

            $csv = \League\Csv\Writer::createFromString('');
            $csv->insertOne(['Id', 'Name', 'Category', 'Code', 'Stock', 'Description', 'Url_image']); // Cabecera

            foreach ($products as $product) {
                $csv->insertOne([
                    $product->id, 
                    $product->name, 
                    $product->category, 
                    $product->code, 
                    $product->stock, 
                    $product->description, 
                    $product->image
                ]);
            }

            $filename = 'products.csv';

            return response($csv->toString(), 200, [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="'.$filename.'"',
            ]);

        } elseif ($exportType === 'excel') {

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
    
            // Agregar encabezados
            $sheet->fromArray(['Id', 'Name', 'Category', 'Code', 'Stock', 'Description', 'Url_image'], NULL, 'A1');
    
            // Agregar datos de productos
            $products = $products->toArray();
            $sheet->fromArray($products, NULL, 'A2');
    
            $filename = 'products.xlsx';
    
            // Crear el objeto Writer y guardar el archivo Excel
            $writer = new Xlsx($spreadsheet);
    
            // Enviar la respuesta al navegador
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="'. $filename .'"');
            header('Cache-Control: max-age=0');
    
            $writer->save('php://output');
            exit();

        } elseif ($exportType === 'pdf') {
            // Generate PDF
        } else {
            // Action not valid
        }
        
    }
}