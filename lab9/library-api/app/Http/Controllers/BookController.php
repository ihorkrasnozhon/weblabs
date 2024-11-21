<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    // Отримання списку всіх книг
    public function index()
    {
        $books = Book::all();
        return response()->json($books);
    }

    // Отримання інформації про конкретну книгу
    public function show($id)
    {
        $book = Book::find($id);
        if (!$book) {
            return response()->json(['message' => 'Книга не знайдена'], 404);
        }
        return response()->json($book);
    }

    // Додавання нової книги
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'publication_year' => 'required|integer',
            'price' => 'required|numeric',
            'author_id' => 'required|exists:authors,id',
            'genre_id' => 'required|exists:genres,id',
        ]);

        $book = Book::create($validated);
        return response()->json($book, 201);
    }

    // Оновлення даних книги
    public function update(Request $request, $id)
    {
        $book = Book::find($id);
        if (!$book) {
            return response()->json(['message' => 'Книга не знайдена'], 404);
        }

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'publication_year' => 'sometimes|required|integer',
            'price' => 'sometimes|required|numeric',
            'author_id' => 'sometimes|required|exists:authors,id',
            'genre_id' => 'sometimes|required|exists:genres,id',
        ]);

        $book->update($validated);
        return response()->json($book);
    }

    // Видалення книги
    public function destroy($id)
    {
        $book = Book::find($id);
        if (!$book) {
            return response()->json(['message' => 'Книга не знайдена'], 404);
        }

        $book->delete();
        return response()->json(['message' => 'Книга видалена']);
    }
}
