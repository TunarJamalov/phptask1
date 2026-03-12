<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(){
        $books = Book::with('category')->latest()->paginate(5);
        $categories = Category::all();
        return view('books',compact('books','categories'));
    }

    public function store(Request $request){
        $request->validate([
            'title'=>'required|string|max:255',
            'category_id'=>'required|exists:categories,id',
            'price'=>'required|numeric|min:0',
        ]);

        Book::create([
            'title'=> $request->title,
            'category_id'=> $request->category_id,
            'price'=> $request->price,
        ]);

        return redirect()->back()->with('message','Kitab elave olundu');
    }

    public function edit(Book $book){
        $categories = Category::all();
        return view('edit',compact('book','categories'));
    }

    public function update(Request $request,Book $book){
        $request->validate([
            'title'=>'required|string|max:255',
            'category_id'=>'required|exists:categories,id',
            'price'=>'required|numeric|min:0',
        ]);

        $book->update($request->all());

        return redirect()->route('books.index')->with('message','kitab update olundu');
    }

    public function destroy(Book $book){
        $book->delete();
        return redirect()->route('books.index')->with('message','kitab silindi');
    }
}
