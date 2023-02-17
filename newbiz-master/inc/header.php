<?php
$sayfa = 'Ana Sayfa';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>ŞAN GRUP</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="" name="keywords">
  <meta content="" name="description">

  <!-- Favicons -->
  <link href="img/logo.jpg" rel="icon">
  <link href="img/logo.jpg" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Montserrat:300,400,500,700" rel="stylesheet">

  <!-- Bootstrap CSS File -->
  <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Libraries CSS Files -->
  <link href="lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="lib/animate/animate.min.css" rel="stylesheet">
  <link href="lib/ionicons/css/ionicons.min.css" rel="stylesheet">
  <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
  <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">

  <!-- Main Stylesheet File -->
  <link href="css/style.css" rel="stylesheet">

</head>

<body>

  <!--==========================
  Header
  ============================-->
  <header id="header" class="fixed-top">
    <div class="container">

      <div class="logo float-left" >
        <a href="#intro" class="scrollto"><img src="img/logo.jpg" alt=""></a>
      </div>

      <nav class="main-nav float-right d-none d-lg-block">
        <ul>
          <li <?php echo $sayfa == 'Ana Sayfa' ? 'active' : '' ?>><a href="#intro">Ana Sayfa</a></li>
          <li <?php echo $sayfa == 'Hakkımızda' ? 'active' : '' ?>><a href="#about">Hakkımızda</a></li>
          <li <?php echo $sayfa == 'Servisler' ? 'active' : '' ?>><a href="#services">Servisler</a></li>
          <li <?php echo $sayfa == 'Portfolyo' ? 'active' : '' ?>><a href="#portfolio">Portfolyo</a></li>
			<li <?php echo $sayfa == 'Katalog' ? 'active' : '' ?>><a href="#kataloglar">Kataloglar</a></li>
          <li <?php echo $sayfa == 'Takım' ? 'active' : '' ?>><a href="#team">Takım</a></li>
		  <li <?php echo $sayfa == 'Ortaklar' ? 'active' : '' ?>><a href="#clients">Çözüm Ortakları</a></li>
          <li <?php echo $sayfa == 'İletişim' ? 'active' : '' ?>><a href="#contact">İletişim</a></li>
        </ul>
      </nav><!-- .main-nav -->
      
    </div>
  </header><!-- #header -->
	  <!--==========================
    Intro Section
  ============================-->
 <section id="intro" class="clearfix">
    <div class="container">
      <div class="intro-info" style="background:#6A6A6A">
        <h2>SİZLERE DAHA İYİ<br>HİZMET SUNMAK<br>İÇİN ÇALIŞIYORUZ</h2>
        <div>
          <a href="#about" class="btn-get-started scrollto">Hakkımızda</a>
          <a href="#services" class="btn-services scrollto">Servisler</a>
        </div>
      </div>

    </div>
  </section><!-- #intro -->
