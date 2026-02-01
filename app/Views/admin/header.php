<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>M-Skul</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="<?= base_url('assets/img/foto.jpg')?>" rel="icon">
  <link href="<?= base_url('assets/img/apple-touch-icon.png')?>" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="<?= base_url('assets/vendor/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet">
  <link href="<?= base_url('assets/vendor/bootstrap-icons/bootstrap-icons.css')?>" rel="stylesheet">
  <link href="<?= base_url('assets/vendor/boxicons/css/boxicons.min.css')?>" rel="stylesheet">
  <link href="<?= base_url('assets/vendor/quill/quill.snow.css')?>" rel="stylesheet">
  <link href="<?= base_url('assets/vendor/quill/quill.bubble.css')?>" rel="stylesheet">
  <link href="<?= base_url('assets/vendor/remixicon/remixicon.css')?>" rel="stylesheet">
  <link href="<?= base_url('assets/vendor/simple-datatables/style.css')?>" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="<?= base_url('assets/css/style.css')?>" rel="stylesheet">

  <!-- =======================================================
  * Template Name: NiceAdmin
  * Updated: Sep 18 2023 with Bootstrap v5.3.2
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="index.html" class="logo d-flex align-items-center">
        <img src="<?=  base_url('assets/img/foto.jpg')?>" alt="">
        <span class="d-none d-lg-block">M-Skul</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="<?=base_url('assets/img/'.$prof->foto)?>" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2"><?= $prof-> nama ?></span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6><?= $prof->nama_level ?></h6>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="<?=base_url('logout')?>">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->
  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">

    <?php 
    // kelompokkan menu by parent
   $menu_parent = [];
$menu_child  = [];

// 1. kumpulkan child (harus ada privilege)
foreach ($menu_all as $m) {
    if (
        $m['parent_id'] !== null &&
        isset($privileges[$m['id_menu']])
    ) {
        $menu_child[$m['parent_id']][] = $m;
    }
}

// 2. tentukan parent yang boleh tampil
foreach ($menu_all as $m) {
    if ($m['parent_id'] === null) {

        $has_child     = isset($menu_child[$m['id_menu']]);
        $has_privilege = isset($privileges[$m['id_menu']]);

        if ($has_child || $has_privilege) {
            $menu_parent[] = $m;
        }
    }
}



    foreach($menu_parent as $parent):
        $has_child = isset($menu_child[$parent['id_menu']]);
    ?>
        <li class="nav-item">
            <?php if($has_child): ?>
            <a class="nav-link collapsed" data-bs-target="#menu-<?= $parent['id_menu'] ?>" data-bs-toggle="collapse" href="#">
                <i class="<?= $parent['icon'] ?>"></i>
                <span><?= $parent['nama_menu'] ?></span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="menu-<?= $parent['id_menu'] ?>" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <?php foreach($menu_child[$parent['id_menu']] as $child): ?>
                    <li>
                        <a href="<?= $child['url'] ?>">
                            <i class="<?= $child['icon'] ?: 'bi bi-circle' ?>"></i>
                            <span><?= $child['nama_menu'] ?></span>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <?php else: ?>
            <a class="nav-link collapsed" href="<?= $parent['url'] ?>">
                <i class="<?= $parent['icon'] ?>"></i>
                <span><?= $parent['nama_menu'] ?></span>
            </a>
            <?php endif; ?>
        </li>
    <?php endforeach; ?>

    </ul>
</aside>


  <main id="main" class="main">