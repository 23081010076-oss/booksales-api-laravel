<!DOCTYPE html>
<html>
<head>
    <title>Data Genre dan Author</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { border-collapse: collapse; width: 45%; margin-bottom: 30px; }
        th, td { border: 1px solid #333; padding: 8px 12px; text-align: left; }
        th { background-color: #f2f2f2; }
        h2 { color: #333; }
    </style>
</head>
<body>

    <h2>Daftar Genre</h2>
    <table>
        <tr><th>ID</th><th>Nama Genre</th></tr>
        @foreach($genres as $genre)
            <tr>
                <td>{{ $genre['id'] }}</td>
                <td>{{ $genre['name'] }}</td>
            </tr>
        @endforeach
    </table>

    <h2>Daftar Author</h2>
    <table>
        <tr><th>ID</th><th>Nama Author</th></tr>
        @foreach($authors as $author)
            <tr>
                <td>{{ $author['id'] }}</td>
                <td>{{ $author['name'] }}</td>
            </tr>
        @endforeach
    </table>

</body>
</html>
