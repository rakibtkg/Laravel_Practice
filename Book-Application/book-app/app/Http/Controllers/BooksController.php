<?php

namespace App\Http\Controllers;

use App\Models\Books;
use Illuminate\Http\Request;

class BooksController extends Controller
{

    public function index(Request $request)
    {
        // Support searching via ?q=term across title, author, and genre
        $q = $request->query('q');

        if ($q) {
            $books = Books::where('title', 'like', "%{$q}%")
                ->orWhere('author', 'like', "%{$q}%")
                ->orWhere('genre', 'like', "%{$q}%")
                ->orderBy('id', 'desc')
                ->get();
        } else {
            $books = Books::orderBy('id', 'desc')->get();
        }

        return view('BookShow', compact('books', 'q'));
    }


    public function create()
    {
        return view('BookEnter', ['book' => null]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'published_date' => 'required|date',
            'genre' => 'required|string|max:100',
        ]);

        Books::create($data);

        return redirect()->route('books.index')->with('status', 'Book created successfully.');
    }

    public function edit($id)
    {
        $book = Books::findOrFail($id);
        return view('BookEnter', compact('book'));
    }

    public function update(Request $request, $id)
    {
        $book = Books::findOrFail($id);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'published_date' => 'nullable|date',
            'genre' => 'nullable|string|max:100',
        ]);

        $book->update($data);

        return redirect()->route('books.index')->with('status', 'Book updated successfully.');
    }

    public function destroy($id)
    {
        $book = Books::findOrFail($id);
        $book->delete();

        return redirect()->route('books.index')->with('status', 'Book deleted successfully.');
    }
}
