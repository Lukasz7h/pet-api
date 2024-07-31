<!DOCTYPE html>
<html>
<head>
    <title>Delete Pet</title>
</head>
<body>
    <h2>Delete pet</h2>
    <form method="POST" action="{{ route('delete') }}">
        @csrf
        @method('DELETE')

        <!-- ID -->
        <label for="id">ID:</label>
        <input type="number" id="id" name="id" required>
        <br>

        <!-- HTML with potential errors -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <button type="submit">Delete Pet</button>
    </form>
</body>
</html>
