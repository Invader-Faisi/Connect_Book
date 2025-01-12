<div class="card shadow-sm mb-3">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="admin-card-title fw-bold" style="color: #640D5F;">Alumni Rewards</h4>
        </div>
        <table class="table table-bordered mt-2">
            <thead class="table-dark">
            <tr>
                <th>Alumni</th>
                <th>Job Reward</th>
                <th>Intern Reward</th>
                <th>Total</th>
                <th>Ratings</th>
            </tr>
            </thead>
            <tbody id="rewardTableBody">
            <!-- Dynamic data can be appended here -->
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function(){
        $.ajax({
            url: URL + 'admin/getAlumniRewards/',
            dataType: 'json',
            type: 'GET',
            success: function (response) {
                if (response.success) {
                    $('#rewardTableBody').empty();

                    response.data.forEach(reward => {
                        let alumni_name = reward.alumni_name;
                        let job_reward = reward.job_reward * 10;
                        let internship_reward = reward.internship_reward * 10;
                        let total_reward = job_reward + internship_reward;
                        const stars = Math.min(Math.floor(total_reward / 20), 5);

                        let starsHtml = '';
                        for (let i = 0; i < stars; i++) {
                            starsHtml += '<span class="star" style="color: navy; font-size: 1em;">&#9733;</span>';
                        }

                        const row = `
                            <tr>
                                <td>${alumni_name}</td>
                                <td>${job_reward}</td>
                                <td>${internship_reward}</td>
                                <td>${total_reward}</td>
                                <td>${starsHtml}</td>
                            </tr>
                        `;
                        $('#rewardTableBody').append(row);
                    });

                } else {
                    toastr.error(response.message);
                }
            },
            error: function (xhr, status, error) {
                toastr.error('An error occurred while fetching the alumni rewards. Please try again.');
            }
        });
    });
</script>
