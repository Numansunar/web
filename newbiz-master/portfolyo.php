<?php
$sayfa = 'Portfolyo';
?>
<!--==========================
      Portfolio Section
    ============================-->
    <section id="portfolio" class="clearfix">
      <div class="container">

        <header class="section-header">
          <h3 class="section-title">Portfolyo</h3>
        </header>

        <div class="row">
          <div class="col-lg-12">
            <ul id="portfolio-flters">
              <li data-filter="*" class="filter-active">Tümü</li>
              <li data-filter=".filter-app">Avize</li>
              <li data-filter=".filter-card">Kablo</li>
              <li data-filter=".filter-web">Priz</li>
            </ul>
          </div>
        </div>

        <div class="row portfolio-container">
			<?php
               $sorgu = $baglanti->prepare("SELECT * FROM portfolyo where baslik='Avize' order by sira");
               $sorgu->execute();
          while ($sonuc = $sorgu->fetch()) {
              ?>
          <div class="col-lg-4 col-md-6 portfolio-item filter-app">
            <div class="portfolio-wrap">
              <img src="img/portfolio/<?= $sonuc['foto'] ?>" class="img-fluid" alt="">
              <div class="portfolio-info">
                <h4><a href="<?= $sonuc['ustBaslik'] ?>"><?= $sonuc['baslik'] ?></a></h4>
                <p><?= $sonuc['icerik'] ?></p>
                <div>
                  <a href="img/portfolio/<?= $sonuc['foto'] ?>" data-lightbox="portfolio" data-title="<?= $sonuc['baslik'] ?>" class="link-preview" title="Preview"><i class="ion ion-eye"></i></a>
                  <a href="<?= $sonuc['ustBaslik'] ?>" class="link-details" title="More Details"><i class="ion ion-android-open"></i></a>
                </div>
              </div>
            </div>
          </div>
              <?php
                  } //while sonu
              ?>
			<?php
               $sorgu2 = $baglanti->prepare("SELECT * FROM portfolyo where baslik='Priz' order by sira");
               $sorgu2->execute();
          while ($sonuc2 = $sorgu2->fetch()) {
              ?>
          <div class="col-lg-4 col-md-6 portfolio-item filter-web" data-wow-delay="0.1s">
            <div class="portfolio-wrap">
              <img src="img/portfolio/<?= $sonuc2['foto'] ?>" class="img-fluid" alt="">
              <div class="portfolio-info">
                <h4><a href="<?= $sonuc2['ustBaslik'] ?>"><?= $sonuc2['baslik'] ?></a></h4>
                <p><?= $sonuc2['icerik'] ?></p>
                <div>
                  <a href="img/portfolio/<?= $sonuc2['foto'] ?>" class="link-preview" data-lightbox="portfolio" data-title="<?= $sonuc2['baslik'] ?>" title="Preview"><i class="ion ion-eye"></i></a>
                  <a href="<?= $sonuc2['ustBaslik'] ?>" class="link-details" title="More Details"><i class="ion ion-android-open"></i></a>
                </div>
              </div>
            </div>
          </div>
              <?php
                  } //while sonu
              ?>
			<?php
               $sorgu3 = $baglanti->prepare("SELECT * FROM portfolyo where baslik='Kablo' order by sira");
               $sorgu3->execute();
          while ($sonuc3 = $sorgu3->fetch()) {
              ?>
          <div class="col-lg-4 col-md-6 portfolio-item filter-card" data-wow-delay="0.1s">
            <div class="portfolio-wrap">
              <img src="img/portfolio/<?= $sonuc3['foto'] ?>" class="img-fluid" alt="">
              <div class="portfolio-info">
                <h4><a href="#<?= $sonuc3['ustBaslik'] ?>"><?= $sonuc3['baslik'] ?></a></h4>
                <p><?= $sonuc3['icerik'] ?></p>
                <div>
                  <a href="img/portfolio/<?= $sonuc3['foto'] ?>" class="link-preview" data-lightbox="portfolio" data-title="<?= $sonuc3['baslik'] ?>" title="Preview"><i class="ion ion-eye"></i></a>
                  <a href="<?= $sonuc3['ustBaslik'] ?>" class="link-details" title="More Details"><i class="ion ion-android-open"></i></a>
                </div>
              </div>
            </div>
          </div>
              <?php
                  } //while sonu
              ?>
			

        </div>

      </div>
    </section><!-- #portfolio -->