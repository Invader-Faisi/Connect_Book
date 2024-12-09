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
    <title>Connect Book - Main Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"/>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <?php linkCSS("assets/style.css"); ?>
    <script>
        const user_id = '<?php echo $_SESSION['user_id'];?>';
        const user_type = '<?php echo $_SESSION['user_type'];?>';
        const user_email = '<?php echo $_SESSION['user_email'];?>';
        const BASE_URL = '<?php echo BASE_URL;?>';
    </script>
</head>
<body>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
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
                    <li><a class="dropdown-item" href="?page=pages/profile">Profile</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href='<?php echo BASE_URL?>home/logout' >Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<!-- Main Content -->
<div class="container mt-4">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 mb-2">
            <?php include_once 'components/menu-list.php'; ?>
            <?php include_once 'components/news-card.php'; ?>
        </div>

        <!-- Feed (Dynamic Section) -->
        <div class="col-md-6" id="feed-section">
            <?php /** @var TYPE_NAME $data */
            include $data['page'] . '.php'; ?>
        </div>

        <!-- Right Sidebar -->
        <div class="col-md-3">
            <?php include_once 'components/event-registration.php'; ?>
            <?php if($_SESSION['user_type'] == 'Alumni'):?>
            <?php include_once 'components/alumni-reward-card.php'; ?>
            <?php include_once 'components/mentorship-offered-card.php'; ?>
            <?php endif;?>
            <?php if($_SESSION['user_type'] == 'Student'):?>
            <?php include_once 'components/job-applied-card.php'; ?>
            <?php include_once 'components/mentor-request-card.php'; ?>
            <?php endif;?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
