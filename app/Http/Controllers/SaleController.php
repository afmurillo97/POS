<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Client;
use App\Models\SaleDetail;
use App\Models\Product;
use App\Http\Requests\SaleFormRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;

class SaleController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            
            if (!Gate::allows('Show Sales')) {
                abort(403);
            }
    
            return $next($request);
        })->only(['index', 'show']);

        $this->middleware(function ($request, $next) {
            
            if (!Gate::allows('Create Sales')) {
                abort(403);
            }
    
            return $next($request);
        })->only('create');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = strtolower($request->input('searchText'));

        $salesQuery = Sale::join('clients', 'sales.client_id', '=', 'clients.id')
            ->join('sale_detail', 'sales.id', '=', 'sale_detail.sale_id')
            ->join('products', 'sale_detail.product_id', '=', 'products.id')
            ->select('sales.*', 'clients.name AS client', 'products.name AS product')

            ->orderBy('sales.id', 'desc');

        if ($query) {
            $salesQuery->where(function($queryBuilder) use ($query) {
                $queryBuilder->where('clients.name', 'LIKE', '%'.$query.'%')
                            ->orWhere('sales.voucher_type', 'LIKE', '%'.$query.'%')
                            ->orWhere('sales.voucher_number', 'LIKE', '%'.$query.'%')
                            ->orWhere('sales.date', 'LIKE', '%'.$query.'%')
                            ->orWhere('sales.tax', 'LIKE', '%'.$query.'%')
                            ->orWhere('sales.total', 'LIKE', '%'.$query.'%')
                            ->orWhere('products.name', 'LIKE', '%'.$query.'%');
            });
        }

        $sales = $salesQuery->paginate(5);

        return view('sales.sales.index', [
            'sales' => $sales,
            'searchText' => $query
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $clients = Client::where('status', 1)->orderBy('name', 'asc')->get();
        $products = Product::where('status', 1)->orderBy('name', 'asc')->get();
        return view('sales.sales.create', [
            'clients' => $clients,
            'products' => $products
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SaleFormRequest $request)
    {

        DB::beginTransaction();

        try {

            $sale = new Sale();
            $sale->client_id = $request->get('client_id');
            $sale->voucher_type = $request->get('voucher_type');
            $sale->voucher_number = $request->get('voucher_number') ?? mt_rand(10000, 99999);
            $sale->date = Carbon::now()->startOfDay();
            $sale->tax = '0.19';
            $sale->total = $request->get('total');
            $sale->status = '1';
            $sale->save();

            $A = count($request->get('productIds'));
            $B = count($request->get('amounts'));
            $C = count($request->get('salePrices'));
            $D = count($request->get('discounts'));

            if($A === $B && $A === $C && $A === $D){

                foreach ($request->get('productIds') as $key => $product_id) {

                    $sale_detail = new SaleDetail();
                    $sale_detail->sale_id = $sale->id;
                    $sale_detail->product_id = $product_id;
                    $sale_detail->amount = $request->get('amounts')[$key];
                    $sale_detail->sale_price = $request->get('salePrices')[$key];
                    $sale_detail->discount = $request->get('discounts')[$key];
                    $sale_detail->save();

                    $product = Product::find($product_id);
                    if ($product) {
                        $new_stock = $product->stock - $request->get('amounts')[$key];

                        if ($new_stock < 0) {
                            throw new \Exception('The quantity sold is greater than the available stock.');
                        }
                        $product->update(['stock' => $new_stock]);
                    }

                }

            } else {
                throw new \Exception('The arrays dont have the same size.');
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'title' => 'Awsome',
                'message' => 'New sale added successfully!!'
            ], 200);

        } catch (\Exception $e) {
            
            DB::rollback();
            Log::error('Error insert sales: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'title' => 'Oops!!',
                'message' => 'Error insert sales: ' . $e->getMessage()
            ], 500);

        }
 
    }

    /**
     * Display the specified resource.
     */
    public function show(Sale $sale): View
    {
        $saleQuery = Sale::join('clients', 'sales.client_id', '=', 'clients.id')
            ->select('sales.*', 'clients.name AS client')
            ->where('sales.id', '=', $sale->id)

            ->orderBy('sales.id', 'desc')
            ->first();

        $saleDetailQuery = SaleDetail::join('products', 'sale_detail.product_id', '=', 'products.id')
            ->select('sale_detail.*', 'products.name AS product')
            ->where('sale_detail.sale_id', '=', $sale->id)

            ->get();

        // dd($saleQuery);

        return view('sales.sales.show', [
            'sale' => $saleQuery, 
            'sale_detail' => $saleDetailQuery
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sale $sale): bool
    {
        return false;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SaleFormRequest $request, Sale $sale): RedirectResponse
    {
        $sale->client_id = $request->get('client_id');
        $sale->voucher_type = $request->get('voucher_type');
        $sale->date = $request->get('date');
        $sale->tax = $request->get('tax');
        $sale->status = '1';

        $sale->update($request->except('voucher_number'));

        return Redirect::to('sales/sales/'. $sale->id .'/edit')->with('success', 'Sale updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale): RedirectResponse
    {
        $sale->delete();

        return Redirect::to('sales/sales')->with('success', 'Sale '. $sale->name .' deleted successfully!!!');
    }

    /**
     * Enable/Disable the specified resource from storage.
     */
    public function toggle(Request $request, Sale $sale): RedirectResponse
    {
        $sale->status = ($sale->status === '1') ? '0' : '1';
        $message = ($sale->status === '1') ? 'enabled' : 'disabled';
        $sale->save();

        $page = $request->input('page');

        return Redirect::to('sales/sales?page='. $page)->with('success', 'Sale '. $sale->name .' '.$message.' successfully!!!');
    }
}
