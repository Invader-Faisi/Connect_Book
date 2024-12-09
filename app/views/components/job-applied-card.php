<div class="card shadow-sm mb-3">
    <div class="card-body">
        <h5 class="card-title fw-bold" style="color: #640D5F;">Applied Jobs / Internship</h5>
        <ul class="list-group list-group-flush" id="myJobList">
            <!-- Job list items will be appended here -->
        </ul>
    </div>
</div>

<script>
    $(document).ready(function(){
        $.ajax({
            url: BASE_URL + 'job/getMyJobInternship/' + user_id,
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    $('#myJobList').empty();

                    let myJobs = response.data.reverse();

                    myJobs.forEach(function (job) {
                        let listItem = `
                    <li class="list-group-item">
                        <h5 class="text-primary">${job.title}</h5>
                        <span class="text-muted">${job.description}</span>
                    </li>
                `;
                        $('#myJobList').append(listItem);
                    });
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
