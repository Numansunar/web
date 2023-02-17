<!-- PRODUCT DETAIL PHOTO START -->
		<div id="product-detail-photo">
			{%URUN_RESIM_LIST%}
			<div class="big-photo"><center><a class="lightbox" title="{%URUN_BASLIK%}" href="images/urunler/{%DB_RESIM%}"><img class="img" src="{%URUN_RESIM_SRC%}"></a></center></div>
			<div style="clear:both;"></div>
			<p style="font-size:12px; color:#888; margin:10px 0 0 85px;">Ürün fotoğrafının büyük hali için fotoğrafa tıklayın.</p>
		</div>
		<!-- PRODUCT DETAIL PHOTO END -->
		<!-- PRODUCT INFOS START -->
		<div id="product-infos">
			<div class="prices">
            	<p class="ondetay">{%DB_ONDETAY%}</p>

				<p><span>Piyasa Fiyatı:</span> {%URUN_PIYASA_FIYAT%}</p>
				<p>	<span>Havale / EFT:</span> {%URUN_HAVALE_FIYAT_YTL%} TL (KDV Dahil)</p>
                <hr />
                <p>
                {%URUN_KULLANICI_SECENEKLERI%}
                </p>
				<p class="size">
                	{%URUN_SECIM_LISTE%}
                </p>               
			</div>
			<div class="buttons">
            	
            	<a id="mod-telefon"><img src="templates/orange/images/sizi_arayalim.jpg" /></a><br /><br />
                {%func_modTelefon%}
				<p class="point">{%URUN_FIYAT_KDV_DAHIL%} {%URUN_FIYAT_BIRIM%}</p>
				<span class="pointt">(KDV Dahil)</span>
				<a href="#" onclick="{%SEPETE_EKLE_LINK%}"><img src="templates/orange/resimler/addbasket.png" alt="" style="margin:20px 0 5px 0;" /></a>
				<a href="#" onclick="{%HEMEN_AL_LINK%}"><img src="templates/orange/resimler/buy.png" alt="" /></a>
			</div>
			
		</div>
		<!-- PRODUCT INFOS END -->
		<!-- PRODUCT DETAILS START -->
			<script type="text/javascript">
			$(document).ready(function(){
				$(".detail-content").eq(0).show();
				$("#detail-title li").eq(0).addClass("active-detail");
				$("#detail-title li").click(function(){
					var number = $(this).index();
					$("#detail-title li").removeClass("active-detail");
					$(".detail-content").hide().eq(number).fadeIn("slow");
					$("#detail-title li").eq(number).addClass("active-detail");
					});
				});
			</script>
            <div style="clear:both"></div>
			<div id="product-details">
				<ul id="detail-title">
					<li>Ürün özellikleri</li>
					<li>Taksit Seçenekleri</li>
					<li>Yorumlar</li>
					<li>Geri Bildirim</li>
                    <li>Soru-Cevap</li>
				</ul>
                <div style="clear:both"></div>
				<div class="detail-content">
					{%DB_DETAY%} 
				</div>
				<div class="detail-content">
					{%func_showTaksit%} 
				</div>
				<div class="detail-content">
					{%TAB_YORUM%} 
				</div>
                <div class="detail-content">
					{%TAB_MESAJ%} 
				</div>
                <div class="detail-content">
					{%TAB_SORU%} 
				</div>
			</div>
			<!-- PRODUCT DETAILS END -->
		<div style="clear:both;"></div>