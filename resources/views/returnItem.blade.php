<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Return Item</title>
</head>
<body>
@include('navbar')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Return a Book or Movie</h4>
                </div>
                <div class="card-body">
                    <form action="/returnItem" method="POST">
                        @csrf
                        <!-- Rental Selection -->
                        <div class="mb-3">
                            <label for="rental_id" class="form-label">Select Rental</label>
                            <select name="rental_id" id="rental_id" class="form-select" required>
                                <option value="" disabled selected>Select a rental</option>
                                @foreach($rentals as $rental)
                                    <option value="{{ $rental->rental_id }}">
                                        @if ($rental->book_id)
                                            Book: {{ $rental->books->title }}
                                        @elseif ($rental->movie_id)
                                            Movie: {{ $rental->movies->title }}
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Submit Button -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Return Item</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
