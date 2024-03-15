<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\CategoryFormRequest;
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
        $query = strtolower($request->input('searchText'));

        $categoriesQuery = Category::orderBy('id', 'desc');

        // Aplica la búsqueda si se proporciona un término de búsqueda
        if ($query) {
            $categoriesQuery->where(function($queryBuilder) use ($query) {
                $queryBuilder->where('category', 'LIKE', '%'.$query.'%')
                            ->orWhere('description', 'LIKE', '%'.$query.'%');
            });
        }

        $categories = $categoriesQuery->paginate(5);

        return view('depot.categories.index', ['categories' => $categories, 'searchText' => $query]);
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

        $category = new Category();
        $category->name = $request->get('name');
        $category->description = $request->get('description');
        $category->status = 1;
        $category->save();

        return Redirect::to('depot/categories')->with('success', 'New Category added successfully!!!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category): View
    {
        return view('depot.categories.show', ['category' => $category]);        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category): View
    {
        return view('depot.categories.edit', ['category' => $category]);        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryFormRequest $request, Category $category): RedirectResponse
    {

        $category->name = $request->get('name');
        $category->description = $request->get('description');
        $category->update();

        return Redirect::to('depot/categories/'. $category->id .'/edit')->with('success', 'Category updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();

        return Redirect::to('depot/categories')->with('success', 'Category deleted successfully!!!');
    }

    /**
     * Enable/Disable the specified resource from storage.
     */
    public function toggle(Request $request, Category $category): RedirectResponse
    {
        $category->status = ($category->status == '1') ? '0' : '1';
        $message = ($category->status == '1') ? 'enabled' : 'disabled';
        $category->save();

        $page = $request->input('page');

        return Redirect::to('depot/categories?page='. $page)->with('success', 'Category '. $category->name .' '.$message.' successfully!!!');
    }
}
