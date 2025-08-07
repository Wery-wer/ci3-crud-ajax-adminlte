<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= isset($title) ? $title : 'CI3 CRUD System' ?> | AdminLTE 3</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css">
  <!-- AdminLTE -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.20/dist/sweetalert2.min.css">
  
  <style>
    .content-wrapper {
      background-color: #f4f6f9;
    }
    
    .main-sidebar {
      background: linear-gradient(180deg, #343a40 0%, #495057 100%);
    }
    
    .nav-sidebar .nav-link {
      color: rgba(255,255,255,.8);
    }
    
    .nav-sidebar .nav-link:hover {
      background-color: rgba(255,255,255,.1);
      color: #fff;
    }
    
    .nav-sidebar .nav-link.active {
      background-color: #007bff;
      color: #fff;
    }
    
    .card {
      box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
      border: 0;
    }
    
    .btn {
      border-radius: 0.25rem;
    }
    
    .table th {
      border-top: 0;
      background-color: #f8f9fa;
      font-weight: 600;
    }
    
    .badge {
      font-weight: 500;
    }
    
    .navbar-nav .nav-link {
      padding-right: 1rem;
      padding-left: 1rem;
    }
    
    .loading-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(255, 255, 255, 0.8);
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 9999;
    }
    
    .spinner-border {
      color: #007bff;
    }
  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="<?= base_url() ?>" class="nav-link">Home</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Real-time Clock -->
      <li class="nav-item">
        <span class="navbar-text">
          <i class="far fa-clock"></i>
          <span id="current-time"><?= date('H:i:s') ?></span>
        </span>
      </li>
      
      <!-- Auto Refresh Status -->
      <li class="nav-item">
        <span class="navbar-text ml-3">
          <span id="refresh-status" class="badge badge-success">
            <i class="fas fa-sync-alt"></i> Auto Refresh: ON
          </span>
        </span>
      </li>

      <!-- Fullscreen -->
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= base_url() ?>" class="brand-link">
      <img src="https://adminlte.io/themes/v3/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">CI3 CRUD System</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="https://adminlte.io/themes/v3/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Developer Mode</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Dashboard -->
          <li class="nav-item">
            <a href="<?= base_url() ?>" class="nav-link <?= uri_string() == '' ? 'active' : '' ?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </a>
          </li>
          
          <!-- Master Data -->
          <li class="nav-item <?= strpos(uri_string(), 'users') !== false ? 'menu-open' : '' ?>">
            <a href="#" class="nav-link <?= strpos(uri_string(), 'users') !== false ? 'active' : '' ?>">
              <i class="nav-icon fas fa-database"></i>
              <p>
                Master Data
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= base_url('users') ?>" class="nav-link <?= uri_string() == 'users' ? 'active' : '' ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Users Management</p>
                </a>
              </li>
            </ul>
          </li>
          
          <!-- Settings -->
          <li class="nav-header">SETTINGS</li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-cog"></i>
              <p>
                System Settings
                <span class="badge badge-info right">Soon</span>
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><?= isset($page_title) ? $page_title : 'Dashboard' ?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <?php if(isset($breadcrumb)): ?>
                <?php foreach($breadcrumb as $item): ?>
                  <?php if(isset($item['url'])): ?>
                    <li class="breadcrumb-item"><a href="<?= $item['url'] ?>"><?= $item['title'] ?></a></li>
                  <?php else: ?>
                    <li class="breadcrumb-item active"><?= $item['title'] ?></li>
                  <?php endif; ?>
                <?php endforeach; ?>
              <?php else: ?>
                <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
              <?php endif; ?>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
