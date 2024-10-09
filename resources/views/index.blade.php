<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Available Media</title>
</head>
<body>

<div class="container mt-5">
    <h1 class="mb-4">Available Media</h1>

    <div class="list-group">
        <a href="{{ url('/displayBooksView') }}" class="list-group-item list-group-item-action">View Available Books</a>
        <a href="{{ url('/displayMoviesView') }}" class="list-group-item list-group-item-action">View Available Movies</a>
        <a href="{{ url('/displayRentView') }}" class="list-group-item list-group-item-action">Rent Item</a> 
        <a href="{{ url('/displayReturnView') }}" class="list-group-item list-group-item-action">Return Item</a> 
    </div>
</div>

<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#chatbotModal">
    Chat with Assistant
</button>

@include('chatbot')

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

