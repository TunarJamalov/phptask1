<?php

namespace App\Observers;

use App\Models\ActivityLog;
use App\Models\Book;

class BookObserver
{
    /**
     * Handle the Book "created" event.
     */
    public function created(Book $book): void
    {
        ActivityLog::create([
            'user_id' => auth()->id() ?? $book->user_id,
            'action' => 'Yaratdı',
            'model_type' => 'Kitab',
            'details' => "'{$book->title}' adlı kitab əlavə edildi."
        ]);
    }

    /**
     * Handle the Book "updated" event.
     */
    public function updated(Book $book): void
    {
        ActivityLog::create([
            'user_id' => auth()->id() ?? $book->user_id,
            'action' => 'Yenilədi',
            'model_type' => 'Kitab',
            'details' => "'{$book->title}' adlı kitabın məlumatları dəyişdirildi."
        ]);
    }

    /**
     * Handle the Book "deleted" event.
     */
    public function deleted(Book $book): void
    {
        ActivityLog::create([
            'user_id' => auth()->id() ?? $book->user_id,
            'action' => 'Sildi',
            'model_type' => 'Kitab',
            'details' => "'{$book->title}' adlı kitab bazadan silindi."
        ]);
    }

    /**
     * Handle the Book "restored" event.
     */
    public function restored(Book $book): void
    {
        //
    }

    /**
     * Handle the Book "force deleted" event.
     */
    public function forceDeleted(Book $book): void
    {
        //
    }
}
