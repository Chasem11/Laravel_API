<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Rent Item</title>
</head>
<body>
@include('navbar')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Rent a Book or Movie</h4>
                </div>
                <div class="card-body">
                    <form action="/rentItem" method="POST">
                        @csrf

                        <!-- Alert Section for Success/Error Messages -->
                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                       
                        <!-- Hidden User ID Field for Logged-in User -->
                        <input type="hidden" name="user_id" value="{{ Auth::user()->user_id }}">

                        <!-- Display User Name -->
                        <div class="mb-3">
                            <label class="form-label">Logged in as:</label>
                            <p class="form-control-plaintext">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</p>
                        </div>

                        <!-- Item Type Select -->
                        <div class="mb-3">
                            <label for="item_type" class="form-label">Item Type</label>
                            <select name="item_type" id="item_type" class="form-select" required>
                                <option value="" disabled selected>Select an item type</option>
                                <option value="book">Book</option>
                                <option value="movie">Movie</option>
                            </select>
                        </div>

                        <!-- Book Select -->
                        <div class="mb-3" id="book_select" style="display: none;">
                            <label for="book_id" class="form-label">Select a Book</label>
                            <select name="book_id" id="book_id" class="form-select">
                                <option value="" disabled selected>Select a book</option>
                                @foreach($books as $book)
                                    <option value="{{ $book->item_id }}">{{ $book->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Movie Select -->
                        <div class="mb-3" id="movie_select" style="display: none;">
                            <label for="movie_id" class="form-label">Select a Movie</label>
                            <select name="movie_id" id="movie_id" class="form-select">
                                <option value="" disabled selected>Select a movie</option>
                                @foreach($movies as $movie)
                                    <option value="{{ $movie->item_id }}">{{ $movie->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Rent Item</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('item_type').addEventListener('change', function() {
        if (this.value === 'book') {
            document.getElementById('book_select').style.display = 'block';
            document.getElementById('movie_select').style.display = 'none';
        } else {
            document.getElementById('book_select').style.display = 'none';
            document.getElementById('movie_select').style.display = 'block';
        }
    });
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

