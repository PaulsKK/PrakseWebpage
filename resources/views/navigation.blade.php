<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Your Laravel App</title>
        <!-- Include Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    </head>
    <body>
        <!-- Include Bootstrap JS and jQuery -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">MajasLapasNosaukums</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Pricing</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Blog</a>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="container mt-4">
            <h2>Tabula</h2>
            <td>
                <a href="{{ url('/pievienot') }}" class="btn btn-primary">Pievienot</a>
            <td>
            <table class="table">
    <thead>
        <tr>
            <th scope="col">Name</th>
            <th scope="col">Published Date</th>
            <th scope="col">Publisher Name</th>
            <th scope="col">Category</th>
            <th scope="col">Author</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $item)
            <tr>
                <th scope="row">{{ $item->name }}</th>
                <td>{{ $item->published_date }}</td>
                <td>{{ $item->publisher_name }}</td>
                <td>{{ $item->category }}</td>
                <td>{{ $item->author }}</td>
                <td>
                    <a href="{{ url('delete/'.$item->name) }}" class="btn btn-danger">Dzest</a>
                    <a href="{{ url('edit/'.$item->name) }}" class="btn btn-success">Rediget</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

        </div>
    </body>
</html>