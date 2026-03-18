<?php

namespace App\Http\Controllers;

use App\Exports\BooksExport;
use App\Http\Requests\BookRequest;
use App\Models\Book;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class BookController extends Controller
{
    public function export()
    {
        return Excel::download(new BooksExport, 'kitablar_siyahisi.xlsx');
    }
    public function index(Request $request)
    {
        $query = Book::with('category','tags')->latest();

        if (!auth()->user()->hasRole('admin')) {
            $query->where('user_id', auth()->id());
        }

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('tag_id')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('tags.id', $request->tag_id);
            });
        }

        $books = $query->paginate(5)->appends($request->all());
        $categories = Category::all();
        $tags = Tag::all();

        return view('books', compact('books', 'categories','tags'));
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

        $book = Book::create($data);

        if ($request->has('tags')) {
            $book->tags()->attach($request->tags);
        }

        return redirect()->back()->with('message','Kitab elave olundu');
    }

    public function edit(Book $book){
        Gate::authorize('update', $book);
        $categories = Category::all();
        $tags = Tag::all();
        return view('edit',compact('book','categories','tags'));
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

        if ($request->has('tags')) {
            $book->tags()->sync($request->tags);
        } else {
            $book->tags()->detach();
        }
        return redirect()->route('books.index')->with('message','kitab update olundu');
    }

    public function destroy(Book $book){
        Gate::authorize('delete', $book);
        $book->delete();
        return redirect()->route('books.index')->with('message','kitab silindi');
    }
}
