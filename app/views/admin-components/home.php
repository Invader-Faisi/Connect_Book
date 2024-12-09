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
        // Data for the chart
        const labels = ['Seminars', 'Reunions', 'Alumni Dinners', 'Guest Lecture'];
        const data = {
            labels: labels,
            datasets: [{
                label: 'Event Participation Rates',
                backgroundColor: 'rgba(99, 132, 255, 0.2)',
                borderColor: 'rgba(99, 132, 255, 1)',
                data: [65, 59, 80, 81],
            }]
        };

        // Configuration for the chart
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

        // Render the chart
        const analyticsChart = new Chart(
            $('#analyticsChart'),
            config
        );
    });
</script>
