<?php
$sorgu = $baglanti->prepare("SELECT * FROM anasayfa WHERE id='2'");
$sorgu->execute();
$sonuc = $sorgu->fetch()
?>
<!DOCTYPE html>
<html lang="tr">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>ŞAN GRUP</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Facebook Opengraph integration: https://developers.facebook.com/docs/sharing/opengraph -->
  <meta property="og:title" content="">
  <meta property="og:image" content="">
  <meta property="og:url" content="">
  <meta property="og:site_name" content="">
  <meta property="og:description" content="">

  <!-- Twitter Cards integration: https://dev.twitter.com/cards/  -->
  <meta name="twitter:card" content="summary">
  <meta name="twitter:site" content="">
  <meta name="twitter:title" content="">
  <meta name="twitter:description" content="">
  <meta name="twitter:image" content="">

  <!-- Favicons -->
  <link href="../assets/img/<?= $sonuc['foto'] ?>" rel="icon">
  <link href="../assets/img/<?= $sonuc['foto'] ?>" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Raleway:300,400,500,700,800" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>

  <!-- ======= Hero Section ======= -->
  <section id="hero">
    <div class="hero-container">
      <div data-aos="fade-in">
        <div class="hero-logo">
          <img class="" src="../assets/img/<?= $sonuc['foto'] ?>" alt="ŞAN GRUP">
        </div>

        <h1><?= $sonuc['ustBaslik'] ?></h1>
        <h2><span class="typed" data-typed-items=" <?= $sonuc['altBaslik'] ?>,HER ZAMAN YANINIZDAYIZ <?= $sonuc['altIcerik'] ?> , HER ZAMAN YANINIZDAYIZ PERAKENDE"></span></h2>
      </div>
    </div>
  </section><!-- End Hero -->

  <!-- ======= Header ======= -->
  <header id="header" class="d-flex align-items-center">
    <div class="container d-flex align-items-center justify-content-between">

      <a href="<?= $sonuc['link'] ?>" class="logo mr-auto"><img src="../assets/img/<?= $sonuc['foto'] ?>" alt="ŞAN GRUP"></a>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto active" href="#hero">ANA SAYFA</a></li>
          <li><a class="nav-link scrollto" href="#about">HAKKIMIZDA</a></li>
          <li><a class="nav-link scrollto" href="#services">SERVİSLER</a></li>
          <li><a class="nav-link scrollto " href="#portfolio">PORTFOLYO</a></li>
          <li><a class="nav-link scrollto" href="#testimonials">REFERANS</a></li>
          <li><a class="nav-link scrollto" href="#team">TAKIM</a></li>
          <li><a class="nav-link scrollto" href="#contact">İLETİŞİM</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->

  <main id="main">
