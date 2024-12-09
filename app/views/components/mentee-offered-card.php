<div class="card shadow-sm mb-2">
    <div class="card-body d-flex justify-content-center align-items-center">
        <h3 class="card-title fw-bold mb-0" style="color: #640D5F;">Available Mentors</h3>
    </div>
</div>

<div class="card shadow-sm mb-3">
    <div class="card-body">
        <ul class="list-group list-group-flush">
            <div id="mentorShipList">

            </div>
        </ul>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="applyConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="applyConfirmationModalLabel">Confirm Apply</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to apply for this mentorship?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="confirmApplyBtn">Apply</button>
            </div>
        </div>
    </div>
</div>

<script>
    let applyId;
    let alumniId;
    $(document).ready(function() {
        $.ajax({
            url: BASE_URL + 'mentor/getMentorShips/',
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    $('#mentorShipList').empty();

                    let latestOffers = response.data.reverse();

                    latestOffers.forEach(function (offer) {
                        let listItem = `
                    <li class="list-group-item">
                        <h5 class="text-primary">${offer.name}</h5>
                        ${offer.mentorOffer}
                        <p class="text-muted">${offer.description}</p>
                        <button class="btn btn-primary btn-sm apply-btn" data-id="${offer.id}" data-alumni="${offer.alumniId}">
                            Apply
                        </button>
                    </li>
                `;
                        $('#mentorShipList').append(listItem);
                    });

                    $('.apply-btn').click(function () {
                        applyId = $(this).data('id');
                        alumniId = $(this).data('alumni');
                        $('#applyConfirmationModal').modal('show');
                    });
                } else {
                    toastr.error('Failed to fetch mentor offers.');
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

        $('#confirmApplyBtn').click(function () {
            $.ajax({
                url: BASE_URL + 'mentor/applyForMentorship/',
                type: 'POST',
                data: {alumniId:alumniId, userId:user_id, mentorshipId:applyId},
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        toastr.success('Applied Successfully');
                    } else {
                        toastr.error('You have already applied for this');
                    }
                    $('#applyConfirmationModal').modal('hide');
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
        });

    });

</script>
