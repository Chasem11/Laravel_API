<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
@include('navbar')
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h3>Create New User</h3>
            </div>
            <div class="card-body">
                <form action="/createUser" method="POST">
                    @csrf 

                    <div class="mb-3">
                        <label for="first_name" class="form-label">First Name:</label>
                        <input type="text" name="first_name" id="first_name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="last_name" class="form-label">Last Name:</label>
                        <input type="text" name="last_name" id="last_name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="user_type" class="form-label">User Type:</label>
                        <select name="user_type" id="user_type" class="form-select" required>
                            <option></option>
                            <option value="student">Student</option>
                            <option value="teacher">Teacher</option>
                        </select>
                    </div>

                    <!-- Conditional fields for grade level and department -->
                    <div id="grade_level_group" class="mb-3" style="display: none;">
                        <label for="grade_level" class="form-label">Grade Level:</label>
                        <select name="grade_level" id="grade_level" class="form-select">
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                        </select>
                    </div>

                    <div id="department_group" class="mb-3" style="display: none;">
                        <label for="department" class="form-label">Department:</label>
                        <input type="text" name="department" id="department" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="gender" class="form-label">Gender:</label>
                        <select name="gender" id="gender" class="form-select" required>
                            <option></option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Create User</button>
                </form>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.getElementById('user_type').addEventListener('change', function() {
            var userType = this.value;
            if (userType === 'student') {
                document.getElementById('grade_level_group').style.display = 'block';
                document.getElementById('department_group').style.display = 'none';
            } else if (userType === 'teacher') {
                document.getElementById('grade_level_group').style.display = 'none';
                document.getElementById('department_group').style.display = 'block';
            } else {
                document.getElementById('grade_level_group').style.display = 'none';
                document.getElementById('department_group').style.display = 'none';
            }
        });
    </script>
</body>
</html>


