<div class="card shadow-sm mb-3">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="admin-card-title fw-bold" style="color: #640D5F;">Jobs / Internship</h4>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#jobInternshipModal">
                Add New Job/Internship
            </button>
        </div>
        <table class="table table-bordered mt-2">
            <thead class="table-dark">
            <tr>
                <th>Title</th>
                <th>Company</th>
                <th>Location</th>
                <th>Requirements</th>
                <th>Salary</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody id="jobsTableBody">
            <!-- Dynamic data can be appended here -->
            </tbody>
        </table>

    </div>

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
                        <button type="submit" class="btn btn-primary" id="submitBtn">Save Job</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this Job?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        let jobId;
        loadJobs();

        function loadJobs() {
            $.ajax({
                url: URL + 'job/getJobInternships',
                type: 'POST',
                dataType: 'JSON',
                success: function(response) {
                    if (response.success) {
                        // Clear existing table data
                        $('#jobsTableBody').empty();

                        // Iterate over the jobs data and populate the table
                        response.data.forEach(function(job) {
                            const row = `
                    <tr>
                        <td>${job.title}</td>
                        <td>${job.company}</td>
                        <td>${job.location}</td>
                        <td>${job.requirements}</td>
                        <td>${job.salary}</td>
                        <td>
                            <button class="btn btn-primary btn-sm edit-btn" data-id="${job.id}"><i class="bi bi-pencil"></i></button>
                            <button class="btn btn-danger btn-sm delete-btn" data-id="${job.id}"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                `;
                            $('#jobsTableBody').append(row);
                        });

                        // Attach click handlers for the newly added buttons
                        $('.edit-btn').click(function() {
                            jobId = $(this).data('id');
                            $('#jobInternshipModalLabel').text('Update Job');
                            $('#submitBtn').text('Update');
                            editJob(jobId);
                        });

                        $('.delete-btn').click(function() {
                            jobId = $(this).data('id');
                            $('#deleteConfirmationModal').modal('show');
                        });

                    } else {
                        toastr.error('Failed to load jobs.');
                    }
                },
                error: function(xhr, status, error) {
                    toastr.error('An error occurred while loading the jobs. Please try again.');
                }
            });

        }

        // Showing Modal to update
        function editJob(jobId) {
            $.ajax({
                url: URL + 'job/getJobById/' + jobId,
                type: 'GET',
                dataType: 'JSON',
                success: function(response) {
                    if (response.success) {
                        data = response.data[0];
                        $('#title').val(data.title);
                        $('#company').val(data.company);
                        $('#location').val(data.location);
                        $('#description').val(data.description);
                        $('#requirements').val(data.requirements);
                        $('#salary').val(data.salary);
                        $('#jobInternshipModal').modal('show');

                    } else {
                        toastr.error('Failed to load job data.');
                    }
                },
                error: function(xhr, status, error) {
                    toastr.error('An error occurred while loading the job data. Please try again.');
                }
            });
        }

        // Form submission for adding/updating jobs
        $('#jobInternshipForm').on('submit', function(e) {
            e.preventDefault();
            const formData = $(this).serialize();

            const actionUrl = $('#submitBtn').text() === 'Update' ? URL + 'job/postJobInternship/' + jobId : URL + 'job/postJobInternship/';

            $.ajax({
                url: actionUrl,
                type: 'POST',
                data: formData,
                dataType: 'JSON',
                success: function(response) {
                    if (response.success) {
                        toastr.success('Job saved successfully!');
                        $('#jobInternshipModal').modal('hide');
                        loadJobs();
                    } else {
                        toastr.error('Failed to save job.');
                    }
                },
                error: function(xhr, status, error) {
                    toastr.error('An error occurred while saving the job. Please try again.');
                }
            });
        });

        // Delete confirmation
        $('#confirmDeleteBtn').click(function () {
            deleteJob(jobId);
            $('#deleteConfirmationModal').modal('hide');
        });

        // Deleting job
        function deleteJob(jobId){
            $.ajax({
                url: URL + 'job/deleteJobInternship/' + jobId,
                dataType: 'JSON',
                type: 'DELETE',
                success: function (response) {
                    if (response.success) {
                        toastr.success(response.message);
                        loadJobs();
                    } else {
                        toastr.error('Failed to delete Job.');
                    }
                },
                error: function (xhr, status, error) {
                    toastr.error('An error occurred while deleting the job. Please try again.');
                }
            });
        }

        // Button click handler to reset the form for adding new event
        $('button[data-bs-target="#jobInternshipModal"]').click(function() {
            $('#submitBtn').text('Save Job');
            $('#jobInternshipModalLabel').text('Job/Internship Details');
            $('#jobInternshipForm')[0].reset();
        });

    });
</script>