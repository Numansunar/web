<?php
$sayfa = 'Hakkımızda';
$sorgu = $baglanti->prepare("SELECT * FROM hakkimizda where id='1'");
$sorgu->execute();
$sonuc = $sorgu->fetch();//sorgu çalıştırılıp veriler alınıyor
$sorgu2 = $baglanti->prepare("SELECT * FROM hakkimizda where id='2'");
$sorgu2->execute();
$sonuc2 = $sorgu2->fetch();//sorgu çalıştırılıp veriler alınıyor
$sorgu3 = $baglanti->prepare("SELECT * FROM hakkimizda where id='3'");
$sorgu3->execute();
$sonuc3 = $sorgu3->fetch();//sorgu çalıştırılıp veriler alınıyor
?>  

<main id="main">

    <!--==========================
      About Us Section
    ============================-->
    <section id="about">
      <div class="container">

        <header class="section-header">
          <h3><?= $sonuc['ustBaslik'] ?></h3>
          <p><?= $sonuc['baslik'] ?></p>
        </header>

        <div class="row about-container">

          <div class="col-lg-6 content order-lg-1 order-2">
            <p>
              <?= $sonuc['icerik'] ?>
            </p>
          </div>

          <div class="col-lg-6 background order-lg-2 order-1 wow fadeInUp">
            <img src="img/<?= $sonuc['foto'] ?>" class="img-fluid" alt="">
          </div>
        </div>

        <div class="row about-extra">
          <div class="col-lg-6 wow fadeInUp">
            <img src="img/<?= $sonuc2['foto']?>" class="img-fluid" alt="">
          </div>
          <div class="col-lg-6 wow fadeInUp pt-5 pt-lg-0">
            <h4><?= $sonuc2['baslik']?></h4>
            <p>
            <?= $sonuc2['icerik']?>
            </p>
          </div>
        </div>

        <div class="row about-extra">
          <div class="col-lg-6 wow fadeInUp order-1 order-lg-2">
            <img src="img/<?= $sonuc3['foto']?>" class="img-fluid" alt="">
          </div>

          <div class="col-lg-6 wow fadeInUp pt-4 pt-lg-0 order-2 order-lg-1">
            <h4><?= $sonuc3['baslik']?></h4>
            <p>
				<?= $sonuc2['icerik']?>
            </p>
          </div>
          
        </div>

      </div>
    </section><!-- #about -->




  