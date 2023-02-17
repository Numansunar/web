<?php
$sayfa = 'Takım';
?>
    <!--==========================
      Team Section
    ============================-->
    <section id="team">
      <div class="container">
        <div class="section-header">
          <h3>Takımımız</h3>
          <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque</p>
        </div>

        <div class="row">
			<?php
               $sorgu = $baglanti->prepare("SELECT * FROM takim where id order by sira");
               $sorgu->execute();
          while ($sonuc = $sorgu->fetch()) {
              ?>
			          <div class="col-lg-3 col-md-6 wow fadeInUp">
            <div class="member">
              <img src="img/<?= $sonuc['foto'] ?>" class="img-fluid" alt="">
              <div class="member-info">
                <div class="member-info-content">
                  <h4><?= $sonuc['baslik'] ?></h4>
                  <span><?= $sonuc['icerik'] ?></span>
                  <div class="social">
                    <a href="<?= $sonuc['twitter'] ?>"><i class="fa fa-twitter"></i></a>
                    <a href="<?= $sonuc['facebook'] ?>"><i class="fa fa-facebook"></i></a>
                    <a href="<?= $sonuc['google'] ?>"><i class="fa fa-google-plus"></i></a>
                    <a href="<?= $sonuc['linkedin'] ?>"><i class="fa fa-linkedin"></i></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
              <?php
                  } //while sonu
              ?>

        </div>

      </div>
    </section><!-- #team -->