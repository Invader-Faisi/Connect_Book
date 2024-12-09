<div class="card shadow-sm mb-2">
    <div class="card-body">
        <h3 class="card-title fw-bold text-center" style="color: #640D5F;">Upcoming Events</h3>
    </div>
</div>

<!-- Event Listings -->
<div id="eventContainer"></div>

<!-- Register Event Modal -->
<div class="modal fade" id="registerEventModal" tabindex="-1" aria-labelledby="registerEventModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registerEventModalLabel">Register for Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="registerEventForm">
                    <div class="mb-3">
                        <label for="eventName" class="form-label">Event Name</label>
                        <input type="text" class="form-control" id="eventName" name="event" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="participantName" class="form-label">Your Name</label>
                        <input type="text" class="form-control" id="participantName" name="name" placeholder="Enter your name">
                    </div>
                    <div class="mb-3">
                        <label for="participantEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="participantEmail" name="email" placeholder="Enter your email" value="<?php echo $_SESSION['user_email']?>" readonly>
                    </div>
                    <input type="hidden" id="eventId" name="event_id">
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    let event_id;
    $(document).ready(function () {
        $.ajax({
            url: BASE_URL + 'event/getAllEvents',
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    $('#eventContainer').empty();
                    response.data.forEach(event => {
                        // Create event card
                        const eventCard = `
                            <div class="card shadow-sm mb-2">
                                <div class="card-body">
                                    <h5 class="card-title">${event.event.charAt(0).toUpperCase() + event.event.slice(1)}</h5>
                                    <p class="card-text">Date: ${event.date}<br>Place: ${event.place}</p>
                                    <button class="btn btn-primary apply-btn" data-bs-toggle="modal" data-bs-target="#registerEventModal" data-id="${event.id}" data-name="${event.event.charAt(0).toUpperCase() + event.event.slice(1)}">Register</button>
                                </div>
                            </div>
                        `;
                        $('#eventContainer').append(eventCard);
                    });
                    $('.apply-btn').click(function () {
                        event_id = $(this).data('id');
                        const eventName = $(this).data('name');
                        $('#eventId').val(event_id);
                        $('#eventName').val(eventName);
                        $('#registerEventModal').modal('show');
                    });
                } else {
                    toastr.error('Failed to fetch events:', response.message);
                }
            },
            error: function (xhr, status, error) {
                toastr.error('Failed to fetch events:', xhr);
            }
        });

        // Function to handle event registration
        $('#registerEventForm').on('submit', function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: BASE_URL + 'event/registerForEvent',
                type: 'POST',
                data: formData,
                dataType: 'JSON',
                success: function (response) {
                    if (response.success) {
                        toastr.success(response.message);
                    } else {
                        toastr.error('Failed to register: You are already registered for this event');
                    }
                    $('#registerEventForm')[0].reset();
                    $('#registerEventModal').modal('hide');
                    loadEvents();
                },
                error: function (xhr, status, error) {
                    toastr.error('Failed to register:', xhr);
                }
            });
        });

        function loadEvents(){
            $.ajax({
                url: BASE_URL + 'event/getMyEvents/' + user_email,
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        $('#myEventsList').empty();
                        response.data.forEach(event => {
                            const listItem = `
                                <li class="list-group-item"><span class="fw-bold text-info">${event.event.charAt(0).toUpperCase() + event.event.slice(1)}</span></br>
                                ${event.place}</br>
                                <b>${event.date}</b> </li>`;
                            $('#myEventsList').append(listItem);
                        });
                    } else {
                        toastr.error('Failed to fetch events:', response.message);
                    }
                },
                error: function (xhr, status, error) {
                    toastr.error('Failed to fetch events:', xhr);
                }
            });


        }
    });
</script>
