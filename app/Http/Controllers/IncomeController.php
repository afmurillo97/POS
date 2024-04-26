<?php

namespace App\Http\Controllers;

use App\Models\Income;
use App\Models\Provider;
use App\Models\IncomeDetail;
use App\Models\Product;
use App\Http\Requests\IncomeFormRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Carbon\Carbon;

class IncomeController extends Controller
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

        $incomesQuery = Income::join('providers', 'incomes.provider_id', '=', 'providers.id')
            ->join('income_detail', 'incomes.id', '=', 'income_detail.income_id')
            ->join('products', 'income_detail.product_id', '=', 'products.id')
            ->select('incomes.*', 'providers.name AS provider', 'products.name AS product')
            ->selectRaw('income_detail.amount * income_detail.purchase_price AS total')

            ->orderBy('incomes.id', 'desc');

        if ($query) {
            $incomesQuery->where(function($queryBuilder) use ($query) {
                $queryBuilder->where('providers.name', 'LIKE', '%'.$query.'%')
                            ->orWhere('incomes.voucher_type', 'LIKE', '%'.$query.'%')
                            ->orWhere('incomes.voucher_number', 'LIKE', '%'.$query.'%')
                            ->orWhere('incomes.date', 'LIKE', '%'.$query.'%')
                            ->orWhere('incomes.tax', 'LIKE', '%'.$query.'%');
            });
        }

        $incomes = $incomesQuery->paginate(5);

        return view('shopping.incomes.index', [
            'incomes' => $incomes,
            'searchText' => $query
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $providers = Provider::where('status', 1)->orderBy('name', 'asc')->get();
        $products = Product::where('status', 1)->orderBy('name', 'asc')->get();
        return view('shopping.incomes.create', [
            'providers' => $providers,
            'products' => $products
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(IncomeFormRequest $request)
    {

        DB::beginTransaction();

        try {

            $income = new Income();
            $income->provider_id = $request->get('provider_id');
            $income->voucher_type = $request->get('voucher_type');
            $income->voucher_number = $request->get('voucher_number') ?? mt_rand(10000, 99999);
            $income->date = Carbon::now()->startOfDay();
            $income->tax = '0.19';
            $income->status = '1';
            $income->save();

            $A = count($request->get('productIds'));
            $B = count($request->get('amounts'));
            $C = count($request->get('purchasePrices'));
            $D = count($request->get('salePrices'));

            if($A === $B && $A === $C && $A === $D){

                foreach ($request->get('productIds') as $key => $product_id) {

                    $income_detail = new IncomeDetail();
                    $income_detail->income_id = $income->id;
                    $income_detail->product_id = $product_id;
                    $income_detail->amount = $request->get('amounts')[$key];
                    $income_detail->purchase_price = $request->get('purchasePrices')[$key];
                    $income_detail->sale_price = $request->get('salePrices')[$key];
                    $income_detail->save();

                    $product = Product::find($product_id);
                    if ($product) {
                        $new_stock = $product->stock + $request->get('amounts')[$key];
                        $product->update(['stock' => $new_stock]);
                    }

                }

            }

            DB::commit();

            return response()->json([
                'status' => true,
                'title' => 'Awsome',
                'message' => 'New income added successfully!!'
            ], 200);

        } catch (\Exception $e) {
            
            DB::rollback();
            Log::error('Error insert incomes: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'title' => 'Oops!!',
                'message' => 'Error insert incomes: ' . $e->getMessage()
            ], 500);

        }
 
    }

    /**
     * Display the specified resource.
     */
    public function show(Income $income): View
    {
        $incomeQuery = Income::join('providers', 'incomes.provider_id', '=', 'providers.id')
            ->select('incomes.*', 'providers.name AS provider')
            ->where('incomes.id', '=', $income->id)

            ->orderBy('incomes.id', 'desc')
            ->first();

        $incomeDetailQuery = IncomeDetail::join('products', 'income_detail.product_id', '=', 'products.id')
            ->select('income_detail.*', 'products.name AS product')
            ->where('income_detail.income_id', '=', $income->id)

            ->get();

        // dd($incomeQuery);

        return view('shopping.incomes.show', [
            'income' => $incomeQuery, 
            'income_detail' => $incomeDetailQuery
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Income $income): View
    {
        $providers = Provider::where('status', 1)->orderBy('name', 'asc')->get();
        return view('shopping.incomes.edit', ['income' => $income, 'providers' => $providers]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(IncomeFormRequest $request, Income $income): RedirectResponse
    {
        $income->provider_id = $request->get('provider_id');
        $income->voucher_type = $request->get('voucher_type');
        $income->date = $request->get('date');
        $income->tax = $request->get('tax');
        $income->status = '1';

        $income->update($request->except('voucher_number'));

        return Redirect::to('shopping/incomes/'. $income->id .'/edit')->with('success', 'Income updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Income $income): RedirectResponse
    {
        $income->delete();

        return Redirect::to('shopping/incomes')->with('success', 'Income '. $income->name .' deleted successfully!!!');
    }

    /**
     * Enable/Disable the specified resource from storage.
     */
    public function toggle(Request $request, Income $income): RedirectResponse
    {
        $income->status = ($income->status === '1') ? '0' : '1';
        $message = ($income->status === '1') ? 'enabled' : 'disabled';
        $income->save();

        $page = $request->input('page');

        return Redirect::to('shopping/incomes?page='. $page)->with('success', 'Income '. $income->name .' '.$message.' successfully!!!');
    }
}
