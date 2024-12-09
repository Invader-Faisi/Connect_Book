
    <div class="card shadow-sm">
        <div class="card-body d-flex align-items-center <?php echo ($_SESSION['user_type'] == 'Student') ? 'justify-content-center' : 'justify-content-between'; ?>">
        <h3 class="card-title fw-bold mb-0" style="color: #640D5F;">Job and Internship Offerings</h3>
            <?php if($_SESSION['user_type'] != 'Student'):?>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#jobInternshipModal">Post a Job/Internship</button>
            <?php endif;?>
        </div>
    </div>

    <!-- Job Listings -->
    <div class="mt-2" id="jobInternship"></div>

    <!-- Post Job/Internship Form Modal -->
    <div class="modal fade" id="jobInternshipModal" tabindex="-1" aria-labelledby="jobInternshipModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="jobInternshipModalLabel">Job/Internship Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="jobInternshipForm">
                        <div class="mb-2">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="mb-2">
                            <label for="company" class="form-label">Company</label>
                            <input type="text" class="form-control" id="company" name="company" required>
                        </div>
                        <div class="mb-3">
                            <label for="location" class="form-label">Location</label>
                            <input type="text" class="form-control" id="location" name="location" required>
                        </div>
                        <div class="mb-2">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                        </div>
                        <div class="mb-2">
                            <label for="requirements" class="form-label">Requirements</label>
                            <textarea class="form-control" id="requirements" name="requirements" rows="3" required></textarea>
                        </div>
                        <div class="mb-2">
                            <label for="salary" class="form-label">Salary</label>
                            <input type="number" class="form-control" id="salary" name="salary" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Apply for Job/Internship Modal-->
    <div class="modal fade" id="applyJobInternshipModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="jobInternshipModalLabel">Job/Internship Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="applyJobInternshipForm">
                        <input type="hidden" name="user" value="Student">
                        <div class="mb-3">
                            <label for="studentName" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="studentName" name="studentName" placeholder="Enter your full name" required>
                        </div>
                        <div class="mb-3">
                            <label for="studentEmail"="form-label">Email address</label>
                            <input type="email" class="form-control" id="studentEmail" name="studentEmail" placeholder="Enter your email" required>
                        </div>
                        <div class="mb-3">
                            <label for="studentCurrentCourse" class="form-label">Current Course</label>
                            <input type="text" class="form-control" id="studentCurrentCourse" name="studentCurrentCourse" placeholder="Enter your current course" required>
                        </div>
                        <div class="mb-3">
                            <label for="studentYearOfStudy" class="form-label">Year of Study</label>
                            <input type="number" class="form-control" id="studentYearOfStudy" name="studentYearOfStudy" placeholder="Enter your year of study" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success">Apply for Job</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let job_id;
        $(document).ready(function() {
            loadJobInternship();

            $('#jobInternshipForm').on('submit', function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    url: BASE_URL + 'job/postJobInternship',
                    type: 'POST',
                    dataType: 'json',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message);
                            loadJobInternship();
                        }
                        $('#jobInternshipModal').modal('hide');
                    },
                    error: function(xhr, status, error) {
                        try { const response = JSON.parse(xhr.responseText);
                            toastr.error(response.message);
                        } catch (e) {
                            toastr.error('An error occurred while processing your request. Please try again.');
                        }
                    }
                });
                this.reset();
            });

            // Apply for job
            $('#applyJobInternshipForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: BASE_URL + 'job/applyJobInternship',
                    type: 'POST',
                    dataType: 'json',
                    data: {studentId:user_id, jobId: job_id},
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message);
                            loadJobInternship();
                        } else {
                            toastr.error("You have already applied for this Job / Internship");
                        }
                        loadProfile();
                        $('#applyJobInternshipModal').modal('hide');
                    },
                    error: function(xhr, status, error) {
                        try { const response = JSON.parse(xhr.responseText);
                            toastr.error(response.message);
                        } catch (e) {
                            toastr.error('An error occurred while processing your request. Please try again.');
                        }
                    }
                });
                this.reset();
            });

            // loading JobInternship
            function loadJobInternship(){
                $.ajax({
                    url: BASE_URL + 'job/getJobInternships',
                    type: 'GET',
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            $('#jobInternship').empty();

                            let latestJobs = response.data.reverse();

                            latestJobs.forEach(function (job) {
                                let card = `
                                        <div class="card shadow-sm mb-3">
                                            <div class="card-body">
                                                <div class="d-flex w-100 justify-content-between">
                                                    <h6 class="card-title mb-1"><span class="text-secondary fw-bold">Position</span> : ${job.title}</h6>
                                                    <small><span class="text-secondary fw-bold">Salary</span> : ${job.salary}</small>
                                                </div>
                                                <p class="card-subtitle mb-2 text-muted"><span class="text-secondary fw-bold">Compay</span> : ${job.company}</p>
                                                <p class="card-text">${job.description}</p>`;
                                                if(user_type === 'Student'){
                                                    card += `<button class="btn btn-primary btn-sm apply-btn" data-id="${job.id}">Apply</button>`;
                                                  }
                                        card += `
                                            </div>
                                        </div> `;
                                $('#jobInternship').append(card);
                            });

                            $('.apply-btn').click(function () {
                                job_id = $(this).data('id');
                                $('#applyJobInternshipModal').modal('show');
                                loadProfile();
                            });
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

            function loadProfile(){
                $.ajax({
                    url: BASE_URL + 'profile/getStudentProfileById/' + user_id,
                    type: 'GET',
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            let data = response.data;
                            if (user_type === 'Student') {
                                $('#studentName').val(data.name);
                                $('#studentEmail').val(data.email);
                                $('#studentPassword').val(data.password);
                                $('#studentCurrentCourse').val(data.course);
                                $('#studentYearOfStudy').val(data.yearOfStudy);
                                $('#studentInterests').val(data.interests);
                            } else {
                                console.log('Unknown user type:', user_type);
                            }
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

                $.ajax({
                    url: BASE_URL + 'job/getMyJobInternship/' + user_id,
                    type: 'GET',
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            $('#myJobList').empty();

                            let myJobs = response.data.reverse();

                            myJobs.forEach(function (job) {
                                let listItem = `
                    <li class="list-group-item">
                        <h5 class="text-primary">${job.title}</h5>
                        <span class="text-muted">${job.description}</span>
                    </li>
                `;
                                $('#myJobList').append(listItem);
                            });
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





        });
    </script>