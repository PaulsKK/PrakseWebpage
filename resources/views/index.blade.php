<!-- resources/views/books/index.blade.php -->

@extends('layouts.app')

@section('content')

<h1>Book List</h1>

<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Author</th>
            <th>Published Date</th>
            <th>Category</th>
        </tr>
    </thead>
    <tbody>
        @foreach($books as $book)
            <tr>
                <td>{{ $book->id }}</td>
                <td>{{ $book->title }}</td>
                <td>{{ $book->author }}</td>
                <td>{{ $book->published_date }}</td>
                <td>{{ $book->category }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection
