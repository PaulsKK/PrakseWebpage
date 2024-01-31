<!DOCTYPE html>
<html>
<head>
    <title>Your Table</title>
</head>
<body>

    <h1>Tabula</h1>

    <table border="1">
        <thead>
            <tr>
                <th>Name</th>
                <th>Published Date</th>
                <th>Publisher Name</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->published_date }}</td>
                    <td>{{ $item->publisher_name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
