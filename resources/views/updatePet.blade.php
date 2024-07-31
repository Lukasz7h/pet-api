<!DOCTYPE html>
<html>
<head>
    <title>Update Pet</title>
</head>
<body>
    <h2>Update pet</h2>
    <form action="{{ route('update') }}" method="POST">
        @csrf

        <!-- ID -->
        <label for="id">ID:</label>
        <input type="number" id="id" name="id" required>
        <br>

        <!-- Category -->
        <label for="category_id">Category ID:</label>
        <input type="number" id="category" name="category[0][id]">
        <br>

        <label for="category_name">Category Name:</label>
        <input type="text" id="category_name" name="category[0][name]">
        <br>

        <!-- Name -->
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        <br>

        <!-- Photo's urls -->
        <label for="photo_urls">Photo URLs (comma-separated):</label>
        <input type="text" id="photo_urls" name="photoUrls" placeholder="Image place">
        <br>

        <!-- Tags -->
        <div id="tags-container">
            <label>Tags:</label>
            <div class="tag">
                <label for="tag_id_1">Tag ID:</label>
                <input type="number" id="tag_id_1" name="tags[0][id]">
                <br>

                <label for="tag_name_1">Tag Name:</label>
                <input type="text" id="tag_name_1" name="tags[0][name]">
                <br>
            </div>
        </div>

        <!-- Status -->
        <label for="status">Status:</label>
        <select id="status" name="status" required>
            <option value="available">Available</option>
            <option value="pending">Pending</option>
            <option value="sold">Sold</option>
        </select>
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
        <button type="submit">Update Pet</button>
    </form>
</body>
</html>
