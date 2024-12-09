<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connect Book - Landing Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"/>
    <?php linkCSS("assets/style.css"); ?>
</head>
<body>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="text-center mb-4">
                <h1>VU Alumni Connect Book</h1>
                <p>Connect with VU Alumni and Students around you on Connect Book.</p>
            </div>
            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="card-title text-center mb-4">Sign In</h2>
                    <form id="loginForm">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                    </form>
                    <hr>
                    <div class="text-center">
                        <p>Don't have an account? <a href="#" data-bs-toggle="modal" data-bs-target="#registerModal">Sign Up</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Registration Modal -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registerModalLabel">Sign Up for Connect Book</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs" id="registrationTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="alumni-tab" data-bs-toggle="tab" data-bs-target="#alumni" type="button" role="tab" aria-controls="alumni" aria-selected="true">Alumni</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="student-tab" data-bs-toggle="tab" data-bs-target="#student" type="button" role="tab" aria-controls="student" aria-selected="false">Student</button>
                    </li>
                </ul>
                <div class="tab-content mt-3" id="registrationTabsContent">
                    <div class="tab-pane fade show active" id="alumni" role="tabpanel" aria-labelledby="alumni-tab">
                        <form id="alumniRegistrationForm">
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
                                <input type="password" class="form-control" id="alumniPassword" name="alumniPassword" placeholder="Enter your password" required>
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
                                <button type="submit" class="btn btn-primary">Sign Up</button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="student" role="tabpanel" aria-labelledby="student-tab">
                        <form id="studentRegistrationForm">
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
                                <input type="password" class="form-control" id="studentPassword" name="studentPassword" placeholder="Enter your password" required>
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
                                <button type="submit" class="btn btn-primary">Sign Up</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    const URL = '<?php echo BASE_URL?>';

    $(document).ready(function () {

        // login form submission
        $('#loginForm').on('submit', function(e) {
            e.preventDefault();
            var formData = $(this).serialize();

            $.ajax({
                url: URL + 'home/login',
                type: 'POST',
                dataType: 'json',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        if(response.user === 'Admin'){
                            window.location.href = URL + 'admin/index';
                        }else{
                            window.location.href = URL + 'home/main';
                        }
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

        //Alumni registration
        $('#alumniRegistrationForm').on('submit', function(e) {
            e.preventDefault();

            var formData = $(this).serialize();

            $.ajax({
                url: URL + 'home/register',
                type: 'POST',
                dataType: 'json',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        setTimeout(function (){
                            location.reload();
                        },2000);
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

        //Student registration
        $('#studentRegistrationForm').on('submit', function(e) {
            e.preventDefault();

            var formData = $(this).serialize();

            $.ajax({
                url: URL + 'home/register',
                type: 'POST',
                dataType: 'json',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        setTimeout(function (){
                            location.reload();
                        },2000);
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

</body>
</html>
