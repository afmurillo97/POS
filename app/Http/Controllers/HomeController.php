<?php

namespace App\Http\Controllers;

use App\Models\IncomeDetail;
use App\Models\Product;
use App\Models\SaleDetail;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $incomes_detail = IncomeDetail::orderBy('id', 'desc')->get();
        $users = User::where('status', 1)->orderBy('name', 'desc')->get();
        $sales_detail = SaleDetail::orderBy('id', 'desc')->get();
        $products = Product::where('status', 1)->orderBy('name', 'desc')->get();

        $total_sales = 0;
        $total_incomes = 0;

        foreach ($incomes_detail as $income) {

            $total_incomes = $total_incomes + ($income->amount * $income->purchase_price);
        }

        foreach ($sales_detail as $sale) {

            $total_sales = $total_sales + ($sale->amount * $sale->sale_price); 
        }

        $total_profit = $total_sales - $total_incomes;

        $percentage_profit = ($total_profit / $total_incomes) * 100;

        $percentage_profit = round($percentage_profit, 2);

        return view('home', [

            'incomes' => $incomes_detail,
            'users' => $users,
            'profit' => $percentage_profit,
            'products' => $products

        ]);
    }
}
