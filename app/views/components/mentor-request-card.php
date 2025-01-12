<div class="card shadow-sm mb-3">
    <div class="card-body">
        <h5 class="card-title fw-bold" style="color: #640D5F;">Applied for Mentorship</h5>
        <ul class="list-group list-group-flush" id="myMentorList">
            <!-- Mentor list items will be appended here -->
        </ul>
    </div>
</div>

<script>
    $(document).ready(function(){
        $.ajax({
            url: BASE_URL + 'mentor/getMyMentorship/' + user_id,
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    $('#myMentorList').empty();

                    let mentorship = response.data.reverse();

                    mentorship.forEach(function (mentor) {
                        let row = '';
                        if(mentor.action === 'Pending'){
                            row = `<span class="text-warning">${mentor.action}</span>`;
                        }else{
                            row = `<span class="text-success">${mentor.action}</span>`;
                        }
                        let listItem = `
                    <li class="list-group-item">
                        <h5 class="text-primary">${mentor.mentorOffer}</h5>
                        <span class="text-muted">${mentor.name}</span>
                        ${row}
                    </li>
                `;
                        $('#myMentorList').append(listItem);
                    });
                } else {
                    toastr.error('Failed to fetch Applied Mentorship.');
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
    });

</script>
