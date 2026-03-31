<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Admin Panel</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- AdminLTE CSS -->
  <link rel="stylesheet" href="../public/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../public/dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#">
        <i class="fas fa-bars"></i>
      </a>
    </li>
  </ul>

  <ul class="navbar-nav ml-auto">
    <li class="nav-item">
      <a href="../logout.php" class="nav-link">Logout</a>
    </li>
  </ul>
</nav>

<!-- Sidebar -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <a href="dashboard.php" class="brand-link">
    <span class="brand-text font-weight-light">Admin Panel</span>
  </a>

  <div class="sidebar">
    <nav>
      <ul class="nav nav-pills nav-sidebar flex-column">

        <li class="nav-item">
          <a href="dashboard.php" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="movies/list.php" class="nav-link">
            <i class="nav-icon fas fa-film"></i>
            <p>Movies</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="theaters/list.php" class="nav-link">
            <i class="nav-icon fas fa-building"></i>
            <p>Theaters</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="shows/list.php" class="nav-link">
            <i class="nav-icon fas fa-video"></i>
            <p>Shows</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="reports/movie_wise.php" class="nav-link">
            <i class="nav-icon fas fa-chart-bar"></i>
            <p>Reports</p>
          </a>
        </li>

      </ul>
    </nav>
  </div>
</aside>

<!-- Content Wrapper -->
<div class="content-wrapper">
