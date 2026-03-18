<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            $books = Book::with(['user', 'category', 'tags'])->get();
        } else {
            $books = Book::with(['user', 'category', 'tags'])->where('user_id', $user->id)->get();
        }

        return BookResource::collection($books);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'=>'required|string|max:255',
            'price'=>'required|numeric',
            'category_id'=>'required|exists:categories,id',
            'tags'=>'nullable|array',
            'tags.*'=>'exists:tags,id',
            ]);

        $validated['user_id'] = auth()->id();
        $book = Book::create($validated);

        if($request->has('tags')){
            $book->tags()->attach($request->tags);
        }

        return new BookResource($book);
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        $book->load(['user', 'category', 'tags']);
        return new BookResource($book);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title'=>'sometimes|string|max:255',
            'price'=>'sometimes|numeric',
            'category_id'=>'sometimes|exists:categories,id',
            'tags'=>'nullable|array',
            'tags.*'=>'exists:tags,id',
        ]);

        $book->update($validated);

        if($request->has('tags')){
            $book->tags()->sync($request->tags);
        }
        return new BookResource($book);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $book->delete();

    return response()->json([
        'status'=>'success',
        'message'=>'Book deleted'
    ]);
    }
}
