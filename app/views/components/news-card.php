<div class="card shadow-sm mb-3">
    <div class="card-body">
        <h5 class="card-title fw-bold" style="color: #640D5F;">Latest News</h5>
        <ul class="list-group list-group-flush" id="myNewsList">
            <!-- Event list items will be appended here -->
        </ul>
    </div>
</div>

<script>
    $(document).ready(function (){
        $.ajax({
            url: BASE_URL + 'news/getAllNews/',
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    $('#myNewsList').empty();
                    response.data.forEach(news => {
                        const listItem = `<li class="list-group-item">${news.title.charAt(0).toUpperCase() + news.title.slice(1)}</li>`;
                        $('#myNewsList').append(listItem);
                    });
                } else {
                    toastr.error('Failed to fetch news:', response.message);
                }
            },
            error: function (xhr, status, error) {
                toastr.error('Failed to fetch events:', xhr);
            }
        });
    });
</script>

