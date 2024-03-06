<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\CategoryFormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function __construct()
    {
        
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        if ($request) {
            $query = trim($request->get('searchText'));
            $categories = DB::table('categories')->where('category', 'LIKE', '%'.$query.'%')
                ->where('status', '=', 1)
                ->orderBy('id', 'desc')
                ->paginate(3);
            
            return view('depot.categories.index', ['categories' => $categories, 'searchText' => $query]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('depot.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryFormRequest $request): RedirectResponse
    {
        $request->validate([
            'category' => 'required'
        ]);

        $category = new Category();
        $category->category = $request->get('category');
        $category->description = $request->get('description');
        $category->status = 1;
        $category->save();

        return Redirect::to('depot/categories')->with('success', 'New Category added successfully!!!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        return view('depot.categories.show', ['categories' => Category::findOrFail($id)]);        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        return view('depot.categories.edit', ['categories' => Category::findOrFail($id)]);        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryFormRequest $request, $id): RedirectResponse
    {
        $request->validate([
            'category' => 'required'
        ]);

        $category = Category::findOrFail($id);
        $category->category = $request->get('category');
        $category->description = $request->get('description');
        $category->update();

        return Redirect::to('depot/categories')->with('success', 'Category updated successfully!!!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse
    {
        $category = Category::findOrFail($id);
        $category->status = '0';
        $category->update();

        return Redirect::to('depot/categories')->with('success', 'Category disabled successfully!!!');
    }
}
