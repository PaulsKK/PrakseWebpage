<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2 class="mb-4">Edit Data</h2>
        <form action="{{ route('process.edit', ['name' => $author->name]) }}" method="post">
            @csrf
            @method('PUT') {{-- Use PUT method for updating --}}
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" name="name" class="form-control" value="{{ $author->name }}" required>
            </div>
            <div class="form-group">
                <label for="published_date">Publish Date:</label>
                <input type="date" name="published_date" class="form-control" value="{{ $author->published_date }}" required>
            </div>
            <div class="form-group">
                <label for="publisher_name">Publisher Name:</label>
                <input type="text" name="publisher_name" class="form-control" value="{{ $author->publisher_name }}" required>
            </div>
            <div class="form-group">
                <label for="category">Category:</label>
                <input type="text" name="category" class="form-control" value="{{ $author->category }}" required>
            </div>
            <div class="form-group">
                <label for="author">Authors:</label>
                <input type="text" name="author" class="form-control" value="{{ $author->author }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Rediget</button>
        </form>
    </div>

    <!-- Include Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
