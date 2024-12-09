<div class="card shadow-sm mb-3">
  <div class="card-body">
    <h5 class="card-title fw-bold" style="color: #640D5F;">Mentorship Offered</h5>
    <ul class="list-group list-group-flush">
        <div class="mentorOffersList">

        </div>
    </ul>
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



<script>
    let selectedOfferId;
    $(document).ready(function() {
            $.ajax({
                url: BASE_URL + 'mentor/getMentorOffers/' + user_id,
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        $('.mentorOffersList').empty();

                        let latestOffers = response.data.slice(-5).reverse();

                        latestOffers.forEach(function (offer) {
                            let listItem = `
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        ${offer.mentorOffer}
                        <button class="btn btn-danger btn-sm delete-btn d-none" data-id="${offer.id}">
                            <i class="bi bi-trash3-fill"></i>
                        </button>
                    </li>
                `;
                            $('.mentorOffersList').append(listItem);
                        });

                        $('.delete-btn').click(function () {
                            selectedOfferId = $(this).data('id');
                            $('#deleteConfirmationModal').modal('show');
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


        $('#confirmDeleteBtn').click(function () {
            deleteOffer(selectedOfferId);
            $('#deleteConfirmationModal').modal('hide');
        });

        // Function for deletion of an offer
        function deleteOffer(selectedOfferId) {
            $.ajax({
                url: BASE_URL + 'mentor/deleteMentorshipOffer/' + selectedOfferId,
                dataType: 'JSON',
                type: 'DELETE',
                success: function (response) {
                    if (response.success) {
                        console.log('Offer deleted successfully:', selectedOfferId);
                        $(`button[data-id="${selectedOfferId}"]`).closest('li').remove();
                        toastr.success(response.message);
                    } else {
                        console.log('Failed to delete offer:', response);
                        toastr.error('Failed to delete offer.');
                    }
                },
                error: function (xhr, status, error) {
                    toastr.error('An error occurred while deleting the offer. Please try again.');
                }
            });
        }

    });
</script>

