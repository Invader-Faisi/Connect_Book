<div class="card shadow-sm mb-3">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="admin-card-title fw-bold" style="color: #640D5F;">Discussion Topics</h4>
        </div>
        <table class="table table-bordered mt-2">
            <thead class="table-dark">
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Author</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody id="dicussionTableBody">
            <!-- Dynamic data can be appended here -->
            </tbody>
        </table>

    </div>

    <!--  Replies  -->
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="admin-card-title fw-bold" style="color: #640D5F;">Discussion Replies</h4>
        </div>
        <table class="table table-bordered mt-2">
            <thead class="table-dark">
            <tr>
                <th>Title</th>
                <th>Reply</th>
                <th>Author</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody id="dicussionRepliesTableBody">
            <!-- Dynamic data can be appended here -->
            </tbody>
        </table>

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
    $(document).ready(function() {
        let id;
        let type;
        loadDiscussion();

        function loadDiscussion() {
            // discussions
            $.ajax({
                url: URL + 'discussion/getDiscussion',
                type: 'POST',
                dataType: 'JSON',
                success: function(response) {
                    if (response.success) {
                        // Clear existing table data
                        $('#dicussionTableBody').empty();
                        $('#dicussionRepliesTableBody').empty();
                        // Iterate over the discussion data and populate the table
                        response.data.forEach(function(discussion) {
                            const row = `
                                <tr>
                                    <td>${discussion.title}</td>
                                    <td>${discussion.description}</td>
                                    <td>${discussion.author}</td>
                                    <td>
                                        <button class="btn btn-danger btn-sm delete-btn" data-id="${discussion.id}" data-type="discussion"><i class="bi bi-trash"></i></button>
                                    </td>
                                </tr>
                            `;
                            $('#dicussionTableBody').append(row);
                        });

                        $('.delete-btn').click(function() {
                            id = $(this).data('id');
                            type = $(this).data('type');
                            $('#deleteConfirmationModal').modal('show');
                        });

                    } else {
                        toastr.error('Failed to load discussion.');
                    }
                },
                error: function(xhr, status, error) {
                    toastr.error('An error occurred while loading the discussion. Please try again.');
                }
            });

            // discussion replies
            $.ajax({
                url: URL + 'discussion/getDiscussionReplies',
                type: 'POST',
                dataType: 'JSON',
                success: function(response) {
                    if (response.success) {
                        // Clear existing table data
                        $('#dicussionRepliesTableBody').empty();
                        // Iterate over the discussion data and populate the table
                        response.data.forEach(function(reply) {
                            const row = `
                                <tr>
                                    <td>${reply.title}</td>
                                    <td>${reply.reply}</td>
                                    <td>${reply.replier}</td>
                                    <td>
                                        <button class="btn btn-danger btn-sm delete-btn" data-id="${reply.id}" data-type="discussion_replies"><i class="bi bi-trash"></i></button>
                                    </td>
                                </tr>
                            `;
                            $('#dicussionRepliesTableBody').append(row);
                        });

                        $('.delete-btn').click(function() {
                            id = $(this).data('id');
                            type = $(this).data('type');
                            $('#deleteConfirmationModal').modal('show');
                        });

                    } else {
                        toastr.error('Failed to load discussion.');
                    }
                },
                error: function(xhr, status, error) {
                    toastr.error('An error occurred while loading the discussion. Please try again.');
                }
            });
        }

        // Delete confirmation
        $('#confirmDeleteBtn').click(function () {
            deleteDiscussion(id,type);
            $('#deleteConfirmationModal').modal('hide');
        });

        // Deleting discussion
        function deleteDiscussion(id,type){
            $.ajax({
                url: URL + 'discussion/deleteDiscussion/' + id + '/' + type,
                dataType: 'JSON',
                type: 'DELETE',
                success: function (response) {
                    if (response.success) {
                        toastr.success(response.message);
                        loadDiscussion();
                    } else {
                        toastr.error('Failed to delete discussion.');
                    }
                },
                error: function (xhr, status, error) {
                    toastr.error('An error occurred while deleting the discussion. Please try again.');
                }
            });
        }

    });
</script>