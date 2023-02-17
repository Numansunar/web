<?php
$sorgu = $baglanti->prepare("SELECT * FROM hakkimizda where id='8'");
$sorgu->execute();
?>

    <!-- ======= About Section ======= -->
    <section id="about">
      <div class="container" data-aos="fade-up">
        <div class="row">
          <div class="col-md-12">
            <h3 class="section-title"><?= $sonuc['ustBalik'] ?></h3>
            <div class="section-title-divider"></div>
            <p class="section-description"><?= $sonuc['ustIcerik'] ?></p>
          </div>
        </div>
      </div>
      <div class="container about-container" data-aos="fade-up" data-aos-delay="200">
        <div class="row">

          <div class="col-lg-6 about-img">
            <img src="assets/img/<?= $sonuc['foto'] ?>" alt="">
          </div>

          <div class="col-md-6 about-content">
            <h2 class="about-title"><?= $sonuc['baslik'] ?></h2>
            <p class="about-text">
              <?= $sonuc['icerik'] ?>
            </p>
            <p class="about-text">
              Ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim
              id est laborum
            </p>
            <p class="about-text">
              Ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt molli.
            </p>
          </div>
        </div>
      </div>
    </section><!-- End About Section -->
