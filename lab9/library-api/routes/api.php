<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\GenreController;

// API маршруты для книг
Route::get('books', [BookController::class, 'index']); // Получение всех книг
Route::get('books/{id}', [BookController::class, 'show']); // Получение книги по ID
Route::post('books', [BookController::class, 'store']); // Добавление новой книги
Route::put('books/{id}', [BookController::class, 'update']); // Обновление данных книги
Route::delete('books/{id}', [BookController::class, 'destroy']); // Удаление книги

// API маршруты для авторов
Route::get('authors', [AuthorController::class, 'index']); // Получение всех авторов
Route::get('authors/{id}', [AuthorController::class, 'show']); // Получение автора по ID
Route::post('authors', [AuthorController::class, 'store']); // Добавление нового автора
Route::put('authors/{id}', [AuthorController::class, 'update']); // Обновление данных автора
Route::delete('authors/{id}', [AuthorController::class, 'destroy']); // Удаление автора

// API маршруты для жанров
Route::get('genres', [GenreController::class, 'index']); // Получение всех жанров
Route::get('genres/{id}', [GenreController::class, 'show']); // Получение жанра по ID
Route::post('genres', [GenreController::class, 'store']); // Добавление нового жанра
Route::put('genres/{id}', [GenreController::class, 'update']); // Обновление данных жанра
Route::delete('genres/{id}', [GenreController::class, 'destroy']); // Удаление жанра

