
    <div class="card shadow-sm mb-2">
        <div class="card-body">
            <h3 class="card-title fw-bold text-center" style="color: #640D5F;">Latest News</h3>
        </div>
    </div>

    <!-- News Listings -->
    <div id="newsContainer"></div>


    <script>
        $(document).ready(function (){
            $.ajax({
                url: BASE_URL + 'news/getAllNews/',
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        $('#newsContainer').empty();
                        response.data.forEach(news => {
                            const newsCard = `
                            <div class="card shadow-sm mb-2">
                                <div class="card-body">
                                    <h5 class="card-title">${news.title.charAt(0).toUpperCase() + news.title.slice(1)}</h5>
                                    <p class="card-text">${news.description}</p>
                                </div>
                            </div>
                            `;
                            $('#newsContainer').append(newsCard);
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