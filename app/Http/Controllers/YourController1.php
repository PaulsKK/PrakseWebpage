<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;

class YourController1 extends Controller
{
    public function showPievienotPage()
    {
        return view('pievienot');
    }

    public function index()
    {
        $data = Author::all();
        return view('navigation', compact('data'));
    }

    public function processPievienot(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('pievienot');
        } elseif ($request->isMethod('post')) {
            $request->validate([
                'name' => 'required|string',
                'published_date' => 'required|date',
                'publisher_name' => 'required|string',
                'category' => 'required|string',
                'author' => 'required|string',
            ]);

            $author = new Author([
                'name' => $request->input('name'),
                'published_date' => $request->input('published_date'),
                'publisher_name' => $request->input('publisher_name'),
                'category' => $request->input('category'),
                'author' => $request->input('author'),
            ]);

            $author->save();

            return redirect('/')->with('success', 'Author added successfully!');
        } else {
            abort(405, 'Method Not Allowed');
        }
    }

    // Add the remove method to delete an Author by name
    public function remove($name)
    {
        $author = Author::where('name', $name)->first();

        if (!$author) {
            return redirect('/')->with('error', 'Author not found!');
        }

        $author->delete();

        return redirect('/')->with('status', 'Author deleted successfully!');
    }

    // Add the edit method to edit an Author by name
    public function edit($name)
    {
        $author = Author::where('name', $name)->first();

        if (!$author) {
            return redirect('/')->with('error', 'Author not found!');
        }

        return view('edit', compact('author'));
    }

    // Add the processEdit method to update an Author by name
    public function processEdit(Request $request, $name)
    {
        $author = Author::where('name', $name)->first();

        if (!$author) {
            return redirect('/')->with('error', 'Author not found!');
        }

        $request->validate([
            'name' => 'required|string',
            'published_date' => 'required|date',
            'publisher_name' => 'required|string',
            'category' => 'required|string',
            'author' => 'required|string',
        ]);

        $author->update([
            'name' => $request->input('name'),
            'published_date' => $request->input('published_date'),
            'publisher_name' => $request->input('publisher_name'),
            'category' => $request->input('category'),
            'author' => $request->input('author'),
        ]);

        return redirect('/')->with('success', 'Author updated successfully!');
    }
}


