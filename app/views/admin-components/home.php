<div class="card shadow-sm mb-3">
    <div class="card-body">
        <h4 class="admin-card-title fw-bold" style="color: #640D5F;">Dashboard</h4>
        <div class="row">
            <!-- Cards for displaying numbers -->
            <div class="col-md-3 mb-4">
                <div class="admin-card bg-alumni">
                    <div class="admin-card-body text-center">
                        <i class="bi bi-people icon"></i>
                        <h5 class="admin-card-title">Alumni</h5>
                        <p class="admin-card-value" id="alumniCount">150</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="admin-card bg-students">
                    <div class="admin-card-body text-center">
                        <i class="bi bi-mortarboard icon"></i>
                        <h5 class="admin-card-title">Students</h5>
                        <p class="admin-card-value" id="studentsCount">200</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="admin-card bg-jobs">
                    <div class="admin-card-body text-center">
                        <i class="bi bi-briefcase icon"></i>
                        <h5 class="admin-card-title">Jobs</h5>
                        <p class="admin-card-value" id="jobsCount">50</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="admin-card bg-mentorship">
                    <div class="admin-card-body text-center">
                        <i class="bi bi-person-lines-fill icon"></i>
                        <h5 class="admin-card-title">Mentorship</h5>
                        <p class="admin-card-value" id="mentorshipCount">30</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart for analytics -->
        <div class="row">
            <div class="col-12">
                <div class="admin-card">
                    <div class="admin-card-body">
                        <h5 class="admin-card-title text-center">Alumni Engagement Metrics</h5>
                        <canvas id="analyticsChart" height="100"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    $(document).ready(function() {

        $.ajax({
            url: URL + 'admin/getCounts/',
            type: 'GET',
            dataType: 'JSON',
            success: function(response) {
                if (response.success) {
                    const data = response.data[0];
                    $('#alumniCount').text(data.alumni);
                    $('#studentsCount').text(data.student);
                    $('#jobsCount').text(data.jobs);
                    $('#mentorshipCount').text(data.mentorship);
                } else {
                    toastr.error('Failed to load data.');
                }
            },
            error: function(xhr, status, error) {
                toastr.error('An error occurred while loading the data. Please try again.');
            }
        });

        const labels = [];
        const data = {
            labels: labels,
            datasets: [
                {
                    label: 'Number of Events',
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                    data: []
                },
                {
                    label: 'Number of Participants',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1,
                    data: []
                }
            ]
        };

        const config = {
            type: 'bar',
            data: data,
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        };

        const analyticsChart = new Chart(
            $('#analyticsChart'),
            config
        );

        // Fetch and update chart data
        $.ajax({
            url: URL + 'admin/getChartData/',
            type: 'GET',
            dataType: 'JSON',
            success: function(response) {
                if (response.success) {
                    const labels = [];
                    const eventCounts = [];
                    const participationCounts = [];

                    response.data.forEach(function(item) {
                        labels.push(item.event);
                        eventCounts.push(item.event_count);
                        participationCounts.push(item.participation_count);
                    });

                    // Update the chart
                    analyticsChart.data.labels = labels;
                    analyticsChart.data.datasets[0].data = eventCounts;
                    analyticsChart.data.datasets[1].data = participationCounts;
                    analyticsChart.update();
                } else {
                    toastr.error('Failed to load event participation data.');
                }
            },
            error: function(xhr, status, error) {
                toastr.error('An error occurred while loading the data. Please try again.');
            }
        });

    });
</script>
