<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.a
     */
    public function index()
    {
        $categories = Category::where('user_id', auth()->id())->latest()->get();
        return view('categories',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        Category::create($data);
        return back()->with('success','Kategoriya yaradildi');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        Gate::authorize('update', $category);
        return view('edit_category', compact('category'));
    }

    public function update(CategoryRequest $request, Category $category)
    {
        Gate::authorize('update', $category);
        $category->update($request->validated());
        return redirect()->route('categories.index')->with('success', 'Kateqoriya adı update olundu');
    }

    public function destroy(Category $category)
    {
        Gate::authorize('delete', $category);
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Kateqoriya ve aid olan butun kitablar silindi');
    }
}
