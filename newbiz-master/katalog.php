<?php
$sayfa = 'Katalog';
$sorgu = $baglanti->prepare("SELECT * FROM katalog where id='8'");
$sorgu->execute();
?>
<!--==========================
      Clients Section
    ============================-->
    <section id="kataloglar" class="section-bg">

      <div class="container">
        <div class="section-header">
          <h3>Katalog</h3>
          <p>Güncel Katalog Fiyatları</p>
        </div>

        <div class="row no-gutters kataloglar-wrap clearfix wow fadeInUp" style="background: #FFFFFF">
			<?php
               $sorgu = $baglanti->prepare("SELECT * FROM katalog where id order by sira");
               $sorgu->execute();
          while ($sonuc = $sorgu->fetch()) {
              ?>
          <div class="col-lg-3 col-md-4 col-xs-6">
            <div class="katalog-logo">
			<a href="pdf/<?= $sonuc['ustBaslik'] ?>">
			<img src="img/<?= $sonuc['foto'] ?>">
              </a>
            </div>
			  <center><p><a href="pdf/<?= $sonuc['ustBaslik'] ?>" target="_blank" style="border-bottom: ridge" ><?= $sonuc['baslik'] ?></a></p></center>
          </div>
              <?php
                  } //while sonu
              ?>
        </div>
      </div>

    </section>