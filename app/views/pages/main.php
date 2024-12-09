    <!-- Discussion Card -->
    <div class="card shadow-sm mb-2">
        <div class="card-body">
            <h3 class="fw-bold text-center mb-0" style="color: #640D5F;">Discussion Forum</h3>
        </div>
    </div>
    <div class="card shadow-sm mb-2">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h5 class="card-title fw-bold mb-0">Start New Topic</h5>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createDiscussionModal">Create</button>
        </div>
    </div>
    <div id="discussionsContainer"></div>
    <!-- Container for discussions -->

    <!-- Reply Card Template (Hidden) -->
    <div class="card-body mb-2" id="replyCardTemplate" style="display:none;">
        <h5 class="card-title">Participate in discussion</h5>
        <form class="replyForm">
            <textarea class="form-control mb-2" name="reply" rows="3" placeholder="What's on your mind?"></textarea>
            <input type="hidden" name="discussion_id" class="discussion_id" />
            <button type="submit" class="btn btn-success">Post</button>
        </form>
    </div>




    <!-- Create Discussion Modal -->
<div class="modal fade" id="createDiscussionModal" tabindex="-1" aria-labelledby="createDiscussionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createDiscussionModalLabel">Create New Discussion Topic</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="discussionForm">
                    <div class="mb-3">
                        <label for="title" class="form-label">Discussion Title</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Enter title">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Discussion Content</label>
                        <textarea class="form-control" id="description" name="description" rows="4" placeholder="Enter content"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        // Load discussions initially
        loadDiscussions();

        // Posting new discussion
        $('#discussionForm').on('submit', function(e) {
            e.preventDefault();
            const formData = $(this).serialize();
            $.ajax({
                url: BASE_URL + 'discussion/createDiscussion',
                type: 'POST',
                dataType: 'json',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        loadDiscussions(); // Refresh discussions
                    }
                },
                error: function(xhr) {
                    const response = JSON.parse(xhr.responseText);
                    toastr.error(response.message || 'An error occurred. Please try again.');
                }
            });
            this.reset();
        });

        // Loading discussions
        function loadDiscussions() {
            $.ajax({
                url: BASE_URL + 'discussion/getDiscussion/',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $('#discussionsContainer').empty();
                        const newDiscussion = response.data.reverse();
                        newDiscussion.forEach(discussion => {
                            // Create discussion card
                            const discussionCard = `
                    <div class="post-card card shadow-sm mb-2">
                        <div class="card-body">
                            <h4 class="card-title">${discussion.title}</h4>
                            <h5 class="card-subtitle mb-2 text-muted">${discussion.author ? discussion.author : 'Anonymous'}</h5>
                            <p class="card-text">${discussion.description}</p>
                            <button class="btn btn-primary btn-sm" onclick="showReplyCard(${discussion.id})">Reply</button>
                        </div>
                    </div>
                    <div id="repliesContainer${discussion.id}" class="ms-2"></div> <!-- Container for replies -->
                `;
                            $('#discussionsContainer').append(discussionCard);

                            // Append replies to the existing discussion card
                            if (discussion.replies.length > 0) {
                                const repliesContainer = $(`#repliesContainer${discussion.id}`);
                                const maxVisibleReplies = 2; // Number of replies to show initially

                                const latestReplies = discussion.replies.reverse();

                                latestReplies.forEach((reply, index) => {
                                    if(reply.reply != null) {
                                        const replyCard = `
                                <div class="card shadow-sm mb-2" style="background-color: #D9EAFD; color:cadetblue">
                                    <div class="card-body border-top">
                                        <h6 class="card-subtitle mb-2 text-muted">${reply.replier}</h6>
                                        <p class="card-text">${reply.reply}</p>
                                    </div>
                                </div>
                            `;
                                        // Show only the latest replies initially
                                        if (index < maxVisibleReplies) {
                                            repliesContainer.append(replyCard);
                                        } else {
                                            repliesContainer.append(replyCard);
                                            repliesContainer.children().last().hide();
                                        }
                                    }
                                });

                                // Show "Show More" button if there are more than the maxVisibleReplies
                                if (discussion.replies.length > maxVisibleReplies) {
                                    const showMoreButton = `
                            <button class="btn btn-link btn-sm show-more" onclick="showMoreReplies(${discussion.id})">Show More</button>
                            <button class="btn btn-link btn-sm show-less" onclick="showLessReplies(${discussion.id})" style="display:none;">Show Less</button>
                        `;
                                    repliesContainer.append(showMoreButton);
                                }
                            } else {
                                // Display message if there are no replies
                                $(`#repliesContainer${discussion.id}`).append(`<p class="text-muted">No replies yet.</p>`);
                            }
                        });
                    } else {
                        toastr.error('Failed to fetch discussions:', response.message);
                    }
                },
                error: function(xhr) {
                    toastr.error('Failed to fetch discussions:', xhr);
                }
            });
        }

        // Showing reply card
        window.showReplyCard = function(discussionId) {
            const replyContainer = $(`#repliesContainer${discussionId}`);
            if (replyContainer.find('.replyForm').length === 0) {
                const replyCard = $('#replyCardTemplate').clone().attr('id', '').addClass('reply-card').show();
                replyCard.find('.discussion_id').val(discussionId);
                replyContainer.append(replyCard);
            }
        };

        // Function to show more replies
         window.showMoreReplies = function(discussionId) {
            const repliesContainer = $(`#repliesContainer${discussionId}`);
            repliesContainer.children().each((index, element) => {
                if ($(element).is(':hidden')) {
                    $(element).show();
                }
            });
            // Hide "Show More" button and show "Show Less" button
            repliesContainer.find('.show-more').hide();
            repliesContainer.find('.show-less').show();
        }

        // Function to show less replies
         window.showLessReplies = function(discussionId) {
            const repliesContainer = $(`#repliesContainer${discussionId}`);
            const maxVisibleReplies = 2; // Number of replies to show initially

            repliesContainer.children().each((index, element) => {
                if (index >= maxVisibleReplies) {
                    $(element).hide();
                }
            });
            // Show "Show More" button and hide "Show Less" button
            repliesContainer.find('.show-more').show();
            repliesContainer.find('.show-less').hide();
        }

        // Posting reply on dicussion
        $(document).on('submit', '.replyForm', function(event) {
            event.preventDefault();
            const form = $(this);
            const formData = form.serialize();

            $.ajax({
                url: BASE_URL + 'discussion/replyOnDiscussion',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        form.find('textarea').val('');
                        form.closest('.reply-card').hide();
                        toastr.success('Reply posted successfully!');
                        loadDiscussions();
                    } else {
                        toastr.error('Failed to post reply: ' + response.message);
                    }
                },
                error: function(xhr) {
                    console.error('Failed to post reply:', xhr);
                    toastr.error('Failed to post reply. Please try again later.');
                }
            });
        });
    });

</script>

