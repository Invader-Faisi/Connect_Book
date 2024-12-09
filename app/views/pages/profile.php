    <div class="card shadow-sm">
        <div class="card-body">
            <h3 class="card-title text-center fw-bold " style="color: #640D5F;"> <?php echo $_SESSION['user_type'];?> Profile</h3>
                <div class="tab-content mt-3" id="registrationTabsContent">
                        <?php if($_SESSION['user_type'] == 'Alumni'):?>
                        <form id="alumniForm">
                            <input type="hidden" name="user" value="Alumni">
                            <div class="mb-3">
                                <label for="alumniName" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="alumniName" name="alumniName" placeholder="Enter your full name" required>
                            </div>
                            <div class="mb-3">
                                <label for="alumniEmail" class="form-label">Email address</label>
                                <input type="email" class="form-control" id="alumniEmail" name="alumniEmail" placeholder="Enter your email" required>
                            </div>
                            <div class="mb-3">
                                <label for="alumniPassword" class="form-label">Password</label>
                                <input type="text" class="form-control" id="alumniPassword" name="alumniPassword" placeholder="Enter your password" required>
                            </div>
                            <div class="mb-3">
                                <label for="alumniGraduationYear" class="form-label">Graduation Year</label>
                                <input type="number" class="form-control" id="alumniGraduationYear" name="alumniGraduationYear" placeholder="Enter your graduation year" required>
                            </div>
                            <div class="mb-3">
                                <label for="alumniDegree" class="form-label">Degree</label>
                                <input type="text" class="form-control" id="alumniDegree" name="alumniDegree" placeholder="Enter your degree" required>
                            </div>
                            <div class="mb-3">
                                <label for="alumniOccupation" class="form-label">Current Occupation</label>
                                <input type="text" class="form-control" id="alumniOccupation" name="alumniOccupation" placeholder="Enter your current occupation" required>
                            </div>
                            <div class="mb-3">
                                <label for="alumniContact" class="form-label">Contact Details</label>
                                <input type="number" class="form-control" id="alumniContact" name="alumniContact" placeholder="Enter your mobile number" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-success">Update</button>
                            </div>
                        </form>
                        <?php endif?>
                        <?php if($_SESSION['user_type'] == 'Student'):?>
                        <form id="studentForm">
                            <input type="hidden" name="user" value="Student">
                            <div class="mb-3">
                                <label for="studentName" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="studentName" name="studentName" placeholder="Enter your full name" required>
                            </div>
                            <div class="mb-3">
                                <label for="studentEmail" class="form-label">Email address</label>
                                <input type="email" class="form-control" id="studentEmail" name="studentEmail" placeholder="Enter your email" required>
                            </div>
                            <div class="mb-3">
                                <label for="studentPassword" class="form-label">Password</label>
                                <input type="text" class="form-control" id="studentPassword" name="studentPassword" placeholder="Enter your password" required>
                            </div>
                            <div class="mb-3">
                                <label for="studentCurrentCourse" class="form-label">Current Course</label>
                                <input type="text" class="form-control" id="studentCurrentCourse" name="studentCurrentCourse" placeholder="Enter your current course" required>
                            </div>
                            <div class="mb-3">
                                <label for="studentYearOfStudy" class="form-label">Year of Study</label>
                                <input type="number" class="form-control" id="studentYearOfStudy" name="studentYearOfStudy" placeholder="Enter your year of study" required>
                            </div>
                            <div class="mb-3">
                                <label for="studentInterests" class="form-label">Interests</label>
                                <input type="text" class="form-control" id="studentInterests" name="studentInterests" placeholder="Enter your interests" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-success">Update</button>
                            </div>
                        </form>
                        <?php endif?>
                </div>
        </div>
    </div>

    <script>

        let URL = '';
        if(user_type == 'Alumni'){
            URL = BASE_URL + 'profile/getAlumniProfileById/' + user_id;
        }else{
            URL = BASE_URL + 'profile/getStudentProfileById/' + user_id;
        }

        // Getting user profile base in user type
        $(document).ready(function() {

            loadProfile();

            function loadProfile(){
                $.ajax({
                    url: URL,
                    type: 'GET',
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            let data = response.data;
                            if (user_type === 'Alumni') {
                                $('#alumniName').val(data.name);
                                $('#alumniEmail').val(data.email);
                                $('#alumniPassword').val(data.password);
                                $('#alumniGraduationYear').val(data.graduationYear);
                                $('#alumniDegree').val(data.degree);
                                $('#alumniOccupation').val(data.occupation);
                                $('#alumniContact').val(data.contact);
                            } else if (user_type === 'Student') {
                                $('#studentName').val(data.name);
                                $('#studentEmail').val(data.email);
                                $('#studentPassword').val(data.password);
                                $('#studentCurrentCourse').val(data.course);
                                $('#studentYearOfStudy').val(data.yearOfStudy);
                                $('#studentInterests').val(data.interests);
                            } else {
                                console.log('Unknown user type:', user_type);
                            }
                        } else {
                            toastr.error('Failed to fetch data.');
                        }
                    },
                    error: function (xhr, status, error) {
                        try {
                            const response = JSON.parse(xhr.responseText);
                            toastr.error(response.message);
                        } catch (e) {
                            toastr.error('An error occurred while processing your request. Please try again.');
                        }
                    }
                });
            }

            //updating alumni profile
            $('#alumniForm').on('submit', function(e) {
                e.preventDefault();

                var formData = $(this).serialize();
                $.ajax({
                    url: BASE_URL + 'profile/updateAlumniProfile/' + user_id,
                    type: 'POST',
                    dataType: 'json',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message);
                            loadProfile();
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        try { const response = JSON.parse(xhr.responseText);
                            toastr.error(response.message);
                        } catch (e) {
                            toastr.error('An error occurred while processing your request. Please try again.');
                        }
                    }
                });
            });


            //updating student profile
            $('#studentForm').on('submit', function(e) {
                e.preventDefault();

                var formData = $(this).serialize();
                $.ajax({
                    url: BASE_URL + 'profile/updateStudentProfile/' + user_id,
                    type: 'POST',
                    dataType: 'json',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message);
                            loadProfile();
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        try {
                            const response = JSON.parse(xhr.responseText);
                            toastr.error(response.message);
                        } catch (e) {
                            toastr.error('An error occurred while processing your request. Please try again.');
                        }
                    }
                });
            });
        });
    </script>