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
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
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
                            <label for="id" class="form-label">Select Rental</label>
                            <select name="id" id="id" class="form-select" required>
                                <option value="" disabled selected>Select a rental</option>
                                @foreach($rentals as $rental)
                                    <option value="{{ $rental->id }}">
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
