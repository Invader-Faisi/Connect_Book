<div class="card shadow-sm mb-3">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="admin-card-title fw-bold" style="color: #640D5F;">News / Updates</h4>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newsModal">
                Add New News
            </button>
        </div>
        <table class="table table-bordered mt-2">
            <thead class="table-dark">
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody id="newsTableBody">
            <!-- Dynamic data can be appended here -->
            </tbody>
        </table>

    </div>

    <!-- Post News Form Modal -->
    <div class="modal fade" id="newsModal" tabindex="-1" aria-labelledby="newsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="newsModalLabel">News Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="newsForm">
                        <div class="mb-2">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="mb-2">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" rows="3" name="description" required>
                            </textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" id="submitBtn">Save News</button>
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
                    Are you sure you want to delete this News?
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
    $(document).ready(function () {
        let newsId;
        loadNews();

        function loadNews() {
            $.ajax({
                url: URL + 'news/getAllNews/',
                type: 'POST',
                dataType: 'JSON',
                success: function (response) {
                    if (response.success) {
                        // Clear existing table data
                        $('#newsTableBody').empty();

                        // Iterate over the news data and populate the table
                        response.data.forEach(function (news) {
                            const row = `
                    <tr>
                        <td>${news.title}</td>
                        <td>${news.description}</td>
                        <td>
                            <button class="btn btn-primary btn-sm edit-btn" data-id="${news.id}"><i class="bi bi-pencil"></i></button>
                            <button class="btn btn-danger btn-sm delete-btn" data-id="${news.id}"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                `;
                            $('#newsTableBody').append(row);
                        });

                        // Attach click handlers for the newly added buttons
                        $('.edit-btn').click(function () {
                            newsId = $(this).data('id');
                            $('#newsModalLabel').text('Update News');
                            $('#submitBtn').text('Update');
                            editNews(newsId);
                        });

                        $('.delete-btn').click(function () {
                            newsId = $(this).data('id');
                            $('#deleteConfirmationModal').modal('show');
                        });

                    } else {
                        toastr.error('Failed to load news.');
                    }
                },
                error: function (xhr, status, error) {
                    toastr.error('An error occurred while loading the news. Please try again.');
                }
            });

        }

        // Showing Modal to update
        function editNews(newsId) {
            $.ajax({
                url: URL + 'news/getNewsById/' + newsId,
                type: 'GET',
                dataType: 'JSON',
                success: function (response) {
                    if (response.success) {
                        data = response.data[0];
                        $('#title').val(data.title);
                        $('#description').val(data.description);
                        $('#newsModal').modal('show');

                    } else {
                        toastr.error('Failed to load news data.');
                    }
                },
                error: function (xhr, status, error) {
                    toastr.error('An error occurred while loading the news data. Please try again.');
                }
            });
        }

        // Form submission for adding/updating news
        $('#newsForm').on('submit', function (e) {
            e.preventDefault();
            const formData = $(this).serialize();

            const actionUrl = $('#submitBtn').text() === 'Update' ? URL + 'news/addNews/' + newsId : URL + 'news/addNews/';

            $.ajax({
                url: actionUrl,
                type: 'POST',
                data: formData,
                dataType: 'JSON',
                success: function (response) {
                    if (response.success) {
                        toastr.success('News saved successfully!');
                        $('#newsModal').modal('hide');
                        loadNews();
                    } else {
                        toastr.error('Failed to save news.');
                    }
                },
                error: function (xhr, status, error) {
                    toastr.error('An error occurred while saving the news. Please try again.');
                }
            });
        });

        // Delete confirmation
        $('#confirmDeleteBtn').click(function () {
            deleteNews(newsId);
            $('#deleteConfirmationModal').modal('hide');
        });

        // Deleting news
        function deleteNews(newsId) {
            $.ajax({
                url: URL + 'news/deleteNews/' + newsId,
                dataType: 'JSON',
                type: 'DELETE',
                success: function (response) {
                    if (response.success) {
                        toastr.success(response.message);
                        loadNews();
                    } else {
                        toastr.error('Failed to delete News.');
                    }
                },
                error: function (xhr, status, error) {
                    toastr.error('An error occurred while deleting the news. Please try again.');
                }
            });
        }

        // Button click handler to reset the form for adding new event
        $('button[data-bs-target="#newsModal"]').click(function () {
            $('#submitBtn').text('Save News');
            $('#newsModalLabel').text('News Details');
            $('#newsForm')[0].reset();
        });


    });
</script>