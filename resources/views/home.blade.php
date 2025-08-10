@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0">Dashboard</h4>
                </div>
                <div class="card-body text-center">
                    <h5>Welcome, {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}!</h5>
                    <p class="text-muted mb-4">You are logged in as a {{ ucfirst(Auth::user()->user_type) }}.</p>

                    <div class="list-group mb-4">
                        <a href="{{ url('/displayBooksView') }}" class="list-group-item list-group-item-action">View Available Books</a>
                        <a href="{{ url('/displayMoviesView') }}" class="list-group-item list-group-item-action">View Available Movies</a>
                        <a href="{{ url('/displayRentView') }}" class="list-group-item list-group-item-action">Rent Item</a>
                        <a href="{{ url('/displayReturnView') }}" class="list-group-item list-group-item-action">Return Item</a>
                    </div>

                    <!-- Button to open Chatbot modal -->
                    <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#chatbotModal">
                        Chat with Assistant
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chatbot Modal -->
<div class="modal fade" id="chatbotModal" tabindex="-1" aria-labelledby="chatbotModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg"> <!-- Use modal-lg for a larger modal -->
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="chatbotModalLabel">Chat with Assistant</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                @include('chatbot') <!-- Embed chatbot view directly here -->
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
@endsection
