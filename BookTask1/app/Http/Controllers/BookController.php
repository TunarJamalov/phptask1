<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::with('category')->latest();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $books = $query->paginate(5)->appends($request->all());

        $categories = Category::all();

        return view('books', compact('books', 'categories'));
    }

    public function store(BookRequest $request){
        Book::create($request->all());
        return redirect()->back()->with('message','Kitab elave olundu');
    }

    public function edit(Book $book){
        $categories = Category::all();
        return view('edit',compact('book','categories'));
    }

    public function update(BookRequest $request,Book $book){
        $book->update($request->all());
        return redirect()->route('books.index')->with('message','kitab update olundu');
    }

    public function destroy(Book $book){
        $book->delete();
        return redirect()->route('books.index')->with('message','kitab silindi');
    }
}
