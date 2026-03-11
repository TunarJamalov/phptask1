<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(){
        $books = Book::latest()->get();
        return view('books',compact('books'));
    }

    public function store(Request $request){
        $request->validate([
            'title'=>'required|string|max:255',
            'category'=>'required|string|max:255',
            'price'=>'required|numeric|min:0',
        ]);

        Book::create([
            'title'=> $request->title,
            'category'=> $request->category,
            'price'=> $request->price,
        ]);

        return redirect()->back()->with('message','Kitab elave olundu');
    }

    public function edit(Book $book){
        return view('edit',compact('book'));
    }

    public function update(Request $request,Book $book){
        $request->validate([
            'title'=>'required|string|max:255',
            'category'=>'required|string|max:255',
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
