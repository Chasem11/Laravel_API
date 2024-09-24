<html>
    <form action="/createUser"  method="POST">
        @csrf <!-- CSRF protection -->

        <label for="first_name">First Name:</label>
        <input type="text" name="first_name" id="first_name" required>

        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" id="last_name" required>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>

        <label for="user_type">User Type:</label>
        <select name="user_type" id="user_type" required>
            <option value="student">Student</option>
            <option value="teacher">Teacher</option>
        </select>

        <!-- Conditional fields for grade level and department -->
        <div id="grade_level_group" style="display: none;">
            <label for="grade_level">Grade Level:</label>
            <select name="grade_level" id="grade_level">
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
            </select>
        </div>

        <div id="department_group" style="display: none;">
            <label for="department">Department:</label>
            <input type="text" name="department" id="department">
        </div>

        <label for="gender">Gender:</label>
        <select name="gender" id="gender" required>
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="other">Other</option>
        </select>

        <button type="submit">Create User</button>
    </form>
</html>

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


