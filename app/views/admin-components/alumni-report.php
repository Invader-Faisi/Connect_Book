<div class="card shadow-sm mb-3">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="admin-card-title fw-bold" style="color: #640D5F;">Events</h4>
            <button type="button" class="btn btn-primary" onclick="printPage()">
                Generate Report
            </button>
        </div>
        <div id="page"">
            <h4 class="text-center">Event Participation Report of Alumni's</h4>
            <table class="table table-bordered mt-2">
                <thead class="table-dark">
                <tr>
                    <th>Event</th>
                    <th>Date</th>
                    <th>Place</th>
                    <th>Name</th>
                    <th>Participation</th>
                </tr>
                </thead>
                <tbody id="eventsTableBody">
                <!-- Dynamic data can be appended here -->
                </tbody>
            </table>
        </div>


    </div>
</div>

<script>
    function printPage() {
        let element = document.getElementById('page');
        let opt = {
            margin: [0.5,0.5,0.5,0.5],
            filename: 'report.pdf',
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 1, useCORS: true },
            pagebreak: { mode: 'avoid-all' },
            jsPDF: { unit: 'in', format: 'a4', orientation: 'portrait' }
        };

        html2pdf(element, opt);
    }

    $(document).ready(function(){
        $.ajax({
            url: URL + 'admin/generateReport',
            type: 'POST',
            dataType: 'JSON',
            success: function(response) {
                if (response.success) {
                    // Clear existing table data
                    $('#eventsTableBody').empty();

                    // Iterate over the events data and populate the table
                    response.data.forEach(function(event) {
                        const row = `
                    <tr>
                        <td>${event.event_name}</td>
                        <td>${event.event_date}</td>
                        <td>${event.event_place}</td>
                        <td>${event.participant_names ? event.participant_names : ''}</td>
                        <td>${event.participation}</td>
                    </tr>
                `;
                        $('#eventsTableBody').append(row);
                    });

                } else {
                    toastr.error('Failed to load events.');
                }
            },
            error: function(xhr, status, error) {
                toastr.error('An error occurred while loading the events. Please try again.');
            }
        });
    });
</script>
