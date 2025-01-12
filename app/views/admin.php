<?php
if (!isset($_SESSION['user_name'])) {
    header('Location: ' . BASE_URL . 'home/logout');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connect Book - Admin Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"/>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <?php linkCSS("assets/admin.css"); ?>
    <script>
        const URL = '<?php echo BASE_URL;?>'
    </script>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="#" style="color: #640D5F;">VU Alumni-Student Connect Book</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <div class="ms-auto dropdown">
                <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-circle me-2" style="font-size: 1.5rem;"></i>
                    <span class="d-none d-lg-inline"><?php echo $_SESSION['user_name'];?></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                    <li><a class="dropdown-item" href='<?php echo BASE_URL?>home/logout' >Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<div class="container-fluid mt-2">
    <div class="row">
        <!-- Sidebar -->
        <div class="card col-md-3 mb-3" style="height: 100vh;width: 25%; position: fixed;overflow-y: auto;">
            <div class="card-body">
                <h5 class="card-title fw-bold" style="color: #640D5F;">Menu Items</h5>
                <div class="collapse show" id="sidebarMenu">
                    <div class="list-group">
                        <a href="page?page=admin-components/home" class="list-group-item list-group-item-action menu">
                            <i class="bi bi-house-door"></i> Home
                        </a>
                        <a href="page?page=admin-components/event" class="list-group-item list-group-item-action menu">
                            <i class="bi bi-card-checklist"></i> Event Management
                        </a>
                        <a href="page?page=admin-components/job-internship" class="list-group-item list-group-item-action menu">
                            <i class="bi bi-briefcase"></i> Job / Internship Portal
                        </a>
                        <a href="page?page=admin-components/news" class="list-group-item list-group-item-action menu">
                            <i class="bi bi-newspaper"></i> News & Updates
                        </a>
                        <a href="page?page=admin-components/discussion" class="list-group-item list-group-item-action menu">
                            <i class="bi bi-people"></i> Discussion Forum
                        </a>
                        <a href="page?page=admin-components/alumni" class="list-group-item list-group-item-action menu">
                            <i class="bi bi-person"></i> Alumni Rewards
                        </a>
                        <a href="page?page=admin-components/alumni-report" class="list-group-item list-group-item-action menu">
                            <i class="bi bi-printer"></i> Alumni Report
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Feed (Dynamic Section) -->
        <div class="col-md-8" style="margin-left: 25%; width: 75%;">
            <div class="card shadow-sm mb-2">
                <div class="card-body">
                    <h3 class="card-title fw-bold text-center" style="color: #640D5F;">Admin Dashboard</h3>
                </div>
            </div>
            <div id="content-section">
                <?php /** @var TYPE_NAME $data */
                include $data['page'] . '.php'; ?>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
</body>
</html>
