<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::where('user_id', auth()->id())->with('category')->latest();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $books = $query->paginate(5)->appends($request->all());
        $categories = Category::where('user_id', auth()->id())->get();

        return view('books', compact('books', 'categories'));
    }

    public function store(BookRequest $request){
        $data = $request->validated();
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('covers', $filename, 'public');
            $data['image'] = $filename;
        }

        $data['user_id'] = auth()->id();

        Book::create($data);

        return redirect()->back()->with('message','Kitab elave olundu');
    }

    public function edit(Book $book){
        Gate::authorize('update', $book);
        $categories = Category::where('user_id', auth()->id())->get();
        return view('edit',compact('book','categories'));
    }

    public function update(BookRequest $request,Book $book){
        Gate::authorize('update', $book);
        $data = $request->validated();
        if ($request->hasFile('image')) {

            if ($book->image) {
                Storage::disk('public')->delete('covers/' . $book->image);
            }

            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('covers', $filename, 'public');

            $data['image'] = $filename;
        }
        $book->update($data);
        return redirect()->route('books.index')->with('message','kitab update olundu');
    }

    public function destroy(Book $book){
        Gate::authorize('delete', $book);
        $book->delete();
        return redirect()->route('books.index')->with('message','kitab silindi');
    }
}
