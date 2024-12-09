    <!-- Offer Mentorship Card -->
    <?php if($_SESSION['user_type'] !== 'Student'):?>
    <div class="card shadow-sm mb-2">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h3 class="card-title fw-bold mb-0" style="color: #640D5F;">Offer Mentorship</h3>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#offerMentorshipModal">Create</button>
        </div>
    </div>

    <!-- Students Under Mentorship List -->
    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <h5 class="card-title text-center fw-bold">Students Under Mentorship</h5>
            <div class="list-group" id="menteeList">
                <!-- Student List Items -->

            </div>
        </div>
    </div>
    <?php endif;?>



    <?php if($_SESSION['user_type'] === 'Student'):?>
        <?php include_once  __DIR__ . '/../components/mentee-offered-card.php'?>
    <?php endif;?>

    <!-- Offer Mentorship Modal -->
    <div class="modal fade" id="offerMentorshipModal" tabindex="-1" aria-labelledby="offerMentorshipModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="offerMentorshipModalLabel">Offer Mentorship</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="mentorshipForm">
                        <input type="hidden" name="alumniId" value="<?php echo $_SESSION['user_id']?>">
                        <div class="mb-3">
                            <label for="mentorOffer" class="form-label">Mentor Offer</label>
                            <input type="text" class="form-control" id="mentorOffer" name="mentorOffer" placeholder="Enter your offer">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4" placeholder="Enter description of mentorship offering"></textarea>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>
        // Getting user profile base in user type
        $(document).ready(function() {

            $.ajax({
                url: BASE_URL + 'mentor/getMentees/' + user_id,
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        $('#menteeList').empty();
                        response.data.forEach(mentee => {
                           const menteeList = `
                            <div class="list-group-item list-group-item-action" >
                                <p class="fw-bold text-primary text-center">${mentee.mentorOffer}</p>
                               <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1">${mentee.name}</h5>
                                    <small>Year of Study: ${mentee.yearOfStudy}</small>
                                </div>
                                <p class="mb-1">Course: ${mentee.course}</p>
                                <small>${mentee.description}</small>
                            </div>
                           `;
                            $('#menteeList').append(menteeList);
                        });
                    } else {
                        toastr.error('Failed to fetch news:', response.message);
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



            //updating alumni profile
            $('#mentorshipForm').on('submit', function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    url: BASE_URL + 'mentor/postMentorOffers',
                    type: 'POST',
                    dataType: 'json',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message);
                            loadOffers();
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
                this.reset();
            });

            // loading offers
            function loadOffers(){
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
                        <button class="btn btn-danger btn-sm delete-btn" data-id="${offer.id}">
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
            }



        });
    </script>
