<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Register</title>
</head>
<body>
@include('navbar') <!-- Include your navbar if needed -->

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0">{{ __('Register') }}</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- First Name Field -->
                        <div class="mb-3 row">
                            <label for="first_name" class="col-md-4 col-form-label text-md-end">First Name</label>
                            <div class="col-md-6">
                                <input id="first_name" type="text" class="form-control" name="first_name" required>
                            </div>
                        </div>

                        <!-- Last Name Field -->
                        <div class="mb-3 row">
                            <label for="last_name" class="col-md-4 col-form-label text-md-end">Last Name</label>
                            <div class="col-md-6">
                                <input id="last_name" type="text" class="form-control" name="last_name" required>
                            </div>
                        </div>

                        <!-- Email Field -->
                        <div class="mb-3 row">
                            <label for="email" class="col-md-4 col-form-label text-md-end">Email Address</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" required>
                            </div>
                        </div>

                        <!-- User Type Field -->
                        <div class="mb-3 row">
                            <label for="user_type" class="col-md-4 col-form-label text-md-end">User Type</label>
                            <div class="col-md-6">
                                <select name="user_type" id="user_type" class="form-select" required>
                                    <option value="">Select User Type</option>
                                    <option value="student">Student</option>
                                    <option value="teacher">Teacher</option>
                                </select>
                            </div>
                        </div>

                        <!-- Grade Level Field (for students) -->
                        <div id="grade_level_group" class="mb-3 row" style="display: none;">
                            <label for="grade_level" class="col-md-4 col-form-label text-md-end">Grade Level</label>
                            <div class="col-md-6">
                                <select name="grade_level" id="grade_level" class="form-select">
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                </select>
                            </div>
                        </div>

                        <!-- Department Field (for teachers) -->
                        <div id="department_group" class="mb-3 row" style="display: none;">
                            <label for="department" class="col-md-4 col-form-label text-md-end">Department</label>
                            <div class="col-md-6">
                                <input id="department" type="text" class="form-control" name="department">
                            </div>
                        </div>

                        <!-- Gender Field -->
                        <div class="mb-3 row">
                            <label for="gender" class="col-md-4 col-form-label text-md-end">Gender</label>
                            <div class="col-md-6">
                                <select name="gender" id="gender" class="form-select" required>
                                    <option value="">Select Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>
                        </div>

                        <!-- Password Field -->
                        <div class="mb-3 row">
                            <label for="password" class="col-md-4 col-form-label text-md-end">Password</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>
                            </div>
                        </div>

                        <!-- Confirm Password Field -->
                        <div class="mb-3 row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">Confirm Password</label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary w-100">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <small>Already have an account? <a href="/login">Login here</a></small>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('user_type').addEventListener('change', function () {
        if (this.value === 'student') {
            document.getElementById('grade_level_group').style.display = 'flex';
            document.getElementById('department_group').style.display = 'none';
        } else if (this.value === 'teacher') {
            document.getElementById('grade_level_group').style.display = 'none';
            document.getElementById('department_group').style.display = 'flex';
        } else {
            document.getElementById('grade_level_group').style.display = 'none';
            document.getElementById('department_group').style.display = 'none';
        }
    });
</script>
</body>
</html>
