<?php
$sayfa = 'Ortaklar';
?>
<!--==========================
      Clients Section
    ============================-->
    <section id="clients" class="section-bg">

      <div class="container">

        <div class="section-header">
          <h3>Çözüm Ortaklarımız</h3>
        </div>

        <div class="row no-gutters clients-wrap clearfix wow fadeInUp">
			<?php
               $sorgu = $baglanti->prepare("SELECT * FROM ortaklar where id order by sira");
               $sorgu->execute();
          while ($sonuc = $sorgu->fetch()) {
              ?>
		  <div class="col-lg-3 col-md-4 col-xs-6">
            <div class="client-logo">
              <a href="<?= $sonuc['baslik'] ?>" target="_blank"><img src="img/clients/<?= $sonuc['foto'] ?>" class="img-fluid" alt=""></a>
            </div>
          </div>
              <?php
                  } //while sonu
              ?>
        </div>

      </div>

    </section>