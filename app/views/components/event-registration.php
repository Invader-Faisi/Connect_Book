<div class="card shadow-sm mb-3">
    <div class="card-body">
        <h5 class="card-title fw-bold" style="color: #640D5F;">My Events</h5>
        <ul class="list-group list-group-flush" id="myEventsList">
            <!-- Event list items will be appended here -->
        </ul>
    </div>
</div>

<script>
    $(document).ready(function (){
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
    });
</script>
