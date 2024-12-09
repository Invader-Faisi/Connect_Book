<div class="card shadow-sm mb-3">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="admin-card-title fw-bold" style="color: #640D5F;">Events</h4>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEventModal">
                Add New Event
            </button>
        </div>
        <table class="table table-bordered mt-2">
            <thead class="table-dark">
            <tr>
                <th>Event</th>
                <th>Date</th>
                <th>Place</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody id="eventsTableBody">
            <!-- Dynamic data can be appended here -->
            </tbody>
        </table>

    </div>


    <!-- Add/Update Event Modal -->
    <div class="modal fade" id="addEventModal" tabindex="-1" aria-labelledby="addEventModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addEventModalLabel">Add New Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addEventForm">
                        <div class="mb-3">
                            <label for="eventName" class="form-label">Event Name</label>
                            <input type="text" class="form-control" id="eventName" name="event" required>
                        </div>
                        <div class="mb-3">
                            <label for="eventDate" class="form-label">Date</label>
                            <input type="date" class="form-control" id="eventDate" name="date" required>
                        </div>
                        <div class="mb-3">
                            <label for="eventPlace" class="form-label">Place</label>
                            <input type="text" class="form-control" id="eventPlace" name="place" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="submitBtn">Save Event</button>
                        </div>
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
                    Are you sure you want to delete this offer?
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
        let eventId;
        loadEvents();

        function loadEvents() {
            $.ajax({
                url: URL + 'event/getAllEvents',
                type: 'POST',
                dataType: 'JSON',
                success: function(response) {
                    if (response.success) {
                        // Clear existing table data
                        $('#eventsTableBody').empty();

                        // Iterate over the events data and populate the table
                        response.data.forEach(function(event) {
                            const row = `
                    <tr>
                        <td>${event.event}</td>
                        <td>${event.date}</td>
                        <td>${event.place}</td>
                        <td>
                            <button class="btn btn-primary btn-sm edit-btn" data-id="${event.id}"><i class="bi bi-pencil"></i></button>
                            <button class="btn btn-danger btn-sm delete-btn" data-id="${event.id}"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                `;
                            $('#eventsTableBody').append(row);
                        });

                        // Attach click handlers for the newly added buttons
                        $('.edit-btn').click(function() {
                            eventId = $(this).data('id');
                            $('#addEventModalLabel').text('Update Event');
                            $('#submitBtn').text('Update');
                            editEvent(eventId);
                        });

                        $('.delete-btn').click(function() {
                            eventId = $(this).data('id');
                            $('#deleteConfirmationModal').modal('show');
                        });

                    } else {
                        toastr.error('Failed to load events.');
                    }
                },
                error: function(xhr, status, error) {
                    toastr.error('An error occurred while loading the events. Please try again.');
                }
            });

        }

        // Showing Modal to update
        function editEvent(eventId) {
            $.ajax({
                url: URL + 'event/getEventById/' + eventId,
                type: 'GET',
                dataType: 'JSON',
                success: function(response) {
                    if (response.success) {
                        data = response.data[0];
                        $('#eventName').val(data.event);
                        $('#eventDate').val(data.date);
                        $('#eventPlace').val(data.place);
                        $('#addEventModal').modal('show');

                    } else {
                        toastr.error('Failed to load event data.');
                    }
                },
                error: function(xhr, status, error) {
                    toastr.error('An error occurred while loading the event data. Please try again.');
                }
            });
        }

        // Form submission for adding/updating events
        $('#addEventForm').on('submit', function(e) {
            e.preventDefault();
            const formData = $(this).serialize();

            const actionUrl = $('#submitBtn').text() === 'Update' ? URL + 'event/addEvent/' + eventId : URL + 'event/addEvent';

            $.ajax({
                url: actionUrl,
                type: 'POST',
                data: formData,
                dataType: 'JSON',
                success: function(response) {
                    if (response.success) {
                        toastr.success('Event saved successfully!');
                        $('#addEventModal').modal('hide');
                        loadEvents();
                    } else {
                        toastr.error('Failed to save event.');
                    }
                },
                error: function(xhr, status, error) {
                    toastr.error('An error occurred while saving the event. Please try again.');
                }
            });
        });

        // Delete confirmation
        $('#confirmDeleteBtn').click(function () {
            deleteEvent(eventId);
            $('#deleteConfirmationModal').modal('hide');
        });

        // Deleting event
        function deleteEvent(eventId){
            $.ajax({
                url: URL + 'event/deleteEvent/' + eventId,
                dataType: 'JSON',
                type: 'DELETE',
                success: function (response) {
                    if (response.success) {
                        toastr.success(response.message);
                        loadEvents();
                    } else {
                        toastr.error('Failed to delete offer.');
                    }
                },
                error: function (xhr, status, error) {
                    toastr.error('An error occurred while deleting the offer. Please try again.');
                }
            });
        }

        // Button click handler to reset the form for adding new event
        $('button[data-bs-target="#addEventModal"]').click(function() {
            $('#submitBtn').text('Save Event');
            $('#addEventModalLabel').text('Add New Event');
            $('#addEventForm')[0].reset();
        });
    });
</script>