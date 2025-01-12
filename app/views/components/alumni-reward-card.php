<div class="card shadow-sm mb-3">
    <div class="card-body">
        <h5 class="card-title fw-bold" style="color: #640D5F;">Alumni Rewards</h5>
        <div class="row">
            <div class="col"><strong>Contribution</strong></div>
            <div class="col"><strong>Reward Points</strong></div>
        </div>
        <div class="row">
            <div class="col" id="jobs">Jobs</div>
            <div class="col" id="job_reward"></div>
        </div>
        <div class="row">
            <div class="col" id="internship">Internship</div>
            <div class="col" id="internship_reward"></div>
        </div>
        <div class="row">
            <div class="col fw-bold text-success">Total</div>
            <div class="col fw-bold text-success" id="total_reward"></div>
        </div>

        <div class="row">
            <div class="col fw-bold text-warning">Rating</div>
            <div class="col" id="stars"></div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $.ajax({
            url: BASE_URL + 'home/getAlumniRewards/' + user_id,
            dataType: 'json',
            type: 'GET',
            success: function (response) {
                if (response.success) {
                    const data = response.data[0];
                    let job_reward = data.job_reward * 10;
                    let internship_reward = data.internship_reward * 10;
                    $('#job_reward').text(job_reward);
                    $('#internship_reward').text(internship_reward);

                    const totalReward = job_reward + internship_reward;
                    $('#total_reward').text(totalReward);

                    const stars = Math.min(Math.floor(totalReward / 20), 5);
                    let starHtml = '';
                    for (let i = 0; i < stars; i++) {
                        starHtml += '<span class="star" style="color: navy;font-size: 1em;">&#9733;</span>';
                    }
                    $('#stars').html(starHtml);
                }
            },
            error: function (xhr, status, error) {
                toastr.error('An error occurred while fetching the alumni rewards. Please try again.');
            }
        });

    });
</script>