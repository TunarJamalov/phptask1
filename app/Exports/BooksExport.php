<?php

namespace App\Exports;

use App\Models\Book;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BooksExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        if (auth()->user()->hasRole('admin')) {
            return Book::with(['category', 'user'])->latest()->get();
        }
        return Book::with(['category', 'user'])->where('user_id', auth()->id())->latest()->get();
    }

    public function headings(): array
    {
        return [
            'No:',
            'Kitabın Adı',
            'İstifadəçi',
            'Kateqoriya',
            'Qiymət',
            'Tarix',
            'Taglar',
        ];
    }

    public function map($book): array
    {
        return [
            $book->id,
            $book->title,
            $book->user->name ?? 'Naməlum',
            $book->category->name ?? 'Kateqoriyasız',
            $book->price . ' ₼',
            $book->created_at->format('d.m.Y H:i'),
            $book->tags->pluck('name')->implode(', ') ?? 'Tagsiz',
        ];
    }
}
