<?php

$out='<!-- SLİDER START -->
	
	<div id="slider">
		'.liVitrin().'
	</div>
	'.insertBanner('vitrin_ust').'
	<!-- SLİDER END -->
	<!-- LEFT BOX START -->
	<div id="left-box">
		<!-- EMAİL START -->
		<div id="email-box">
			<h1>E-bülten listemize kayıt olun.</h1>
			<div style="clear:left;"></div>
			<p>Güncel kampanya ve duyurulardan haberdar olmak için e-bülten listemize kayıt olabilirsiniz.</p>
			<form action="#" method="post">
            	<input type="hidden" name="ebultensent" value="true">
				'.ebulten('<input type="text" class="email-box" name="email" />
				<input type="submit" class="email-button" value="" />').'
			</form>
             <script>
                if ($(".ebulteninfo").html() != null) { alert($(".ebulteninfo").text());  }
                if ($(".ebultenerror").html() != null) { alert($(".ebultenerror").text());  }
                $(".ebulteninfo,.ebultenerror").remove();
            </script>
		</div>
		<!-- EMAİL END -->
		<!-- FACEBOOK START -->
		<div id="facebook-page">
			<img src="templates/clickblue/resimler/facebook.png" alt="" />
			<h1>Facebook sayfamızı gördünü mü?</h1>
			<p>Facebook sayfamızı beğenin, kampanya, duyuru ve indirimleri anında yakalayın.</p>
			<a href="#"><img src="templates/clickblue/resimler/facebooklink.png" alt="" style="margin:10px 0 0 20px;" /></a>
		</div>
		<!-- FACEBOOK END -->
	</div>
	<!-- LEFT BOX END -->
	<div style="clear:both;"></div>
	<!-- BANNER START -->
	<div id="banner">
	
	<div class="duyuruPaneli">
	<div class="rek1">
    	<div style="margin-left:70px;">
    		<div class="rekBaslik">Erkek <span>Moda&Giyim </span></div>
            <div class="rekicerik">Erkeklere özel giyim, kozmetik ürünleri burada</div>
        </div>
    </div>
    <div class="rek2">
    	<div style="margin-right:40px; margin-left:10px;">
    		<div class="rekBaslik2">Bebek <span>Ürünleri </span></div>
            <div class="rekicerik2">Bebeklere özel giyim, kozmetik ürünleri burada</div>
        </div>
    
    </div>
    <div class="rek3">
    	<div style="margin-right:40px; margin-left:10px;">
    		<div class="rekBaslik3">Bayan</div>
            <div class="rekicerik3">Bayanlara özel giyim, kozmetik ve takı markaları burada
            <span>%50\'ye varan indirimler</span></div>
        </div>
    
    </div>

<div style="clear:both;"></div>
</div>
	
	
	</div>
	<!-- BANNER END -->
	<!-- INFO START -->
	<div id="info" style="padding: 9px 0 7px 0; height:70px;"><img src="templates/clickblue/resimler/bilgiler.png" alt="" /></div>
	<!-- INFO END -->
	<!-- PRODUCTS START -->
	<div id="products">
		
		<div id="tabs">
			<ul>
				<li><a href="#fragment-1"><span>Vitrin ürünleri</span></a></li>
				<li><a href="#fragment-3"><span>Yeniler</span></a></li>
				<li><a href="#fragment-2"><span>İndirimdekiler</span></a></li>
				
				<li><a href="#fragment-4"><span>Bitmek üzere</span></a></li>
			</ul>
			<div style="clear:left;"></div>
			<div class="products-content">
				<div id="fragment-1" class="products-content">
					'.urunlist('select * from urun where anasayfa = 1').'
					<div style="clear:left;"></div>
				</div>
				<div id="fragment-2" class="products-content">
					'.urunlist('select * from urun where indirimde = 1').'
					<div style="clear:left;"></div>
				</div>
				<div id="fragment-3" class="products-content">
					'.urunlist('select * from urun where yeni = 1').'
					<div style="clear:left;"></div>
				</div>
				<div id="fragment-4" class="products-content">
					'.urunlist('select * from urun where stok < 10').'
					<div style="clear:left;"></div>
				</div>
			</div>
		</div>
	</div>
	<!-- PRODUCTS END -->'.insertBanner('vitrin_alt');
$PAGE_OUT = $out;
?>