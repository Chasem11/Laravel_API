<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ url('/displayHomeView') }}">Home</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/displayBooksView') }}">Books</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/displayMoviesView') }}">Movies</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/displayUserView') }}">Create User</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/displayRentView') }}">Rent Item</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
