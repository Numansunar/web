<div class="detail-page">
			<!-- detail block -->
			<div class="detail-block">
				<!-- detail photos -->
				<div class="detail-photos">
					<div id="urun-image-container">
                       <a href="images/urunler/{%DB_RESIM%}" class="lightbox"><img class="detay-resim" src="images/urunler/{%DB_RESIM%}" /></a>
                     </div>
                     <div class="clear-space">&nbsp;</div>
                     {%URUN_RESIM_LIST%}
                     <div class="clear-space">&nbsp;</div>
				</div>
				<!-- //detail photos -->
				<!-- detail info -->
				<div class="detail-info">
					<div class="detail-name">{%DB_NAME%}</div>
					<div class="detail-info-left">
                    	<div class="on-detay">{%DB_ONDETAY%}</div>
						<div class="detail-price">
							<div class="detail-normal-price">
								<span class="row1">Piyasa Fiyatı</span>
								<span class="row2">:</span>
								<span class="row3">{%URUN_PIYASA_FIYAT%}</span>
							</div>
							<div class="detail-sale-price">
								<span class="row1">Site Fiyatı</span>
								<span class="row2">:</span>
								<span class="row3">{%URUN_FIYAT%}</span>
							</div>
						</div>
						<div class="stock-amount">Bu ürünü indirimli alabileceğiniz {%DB_STOK%} stok kalmıştır.</div>
						<div class="other-price">
							<div class="cc-price">
								<span class="row1">Kredi Kartı ile Tek Çekim</span>
								<span class="row2">:</span>
								<span class="row3">{%URUN_TEKCEKIM_FIYAT_YTL%} TL</span>
							</div>
							<div class="eft-price">
								<span class="row1">Havale ile İndirimli</span>
								<span class="row2">:</span>
								<span class="row3">{%URUN_HAVALE_FIYAT_YTL%} TL</span>
							</div>
						</div>
						<div class="product-variant">
							{%URUN_SECIM_FORM%}
						</div>
						<div class="detail-btn">
							<a href="#" onclick="{%SEPETE_EKLE_LINK%}"><img src="templates/mcshop/img/addbasket.png" alt="" /></a>
							<a href="#" onclick="{%HEMEN_AL_LINK%}"><img src="templates/mcshop/img/buynow.png" alt="" /></a>
						</div>
					</div>
					<div class="detail-info-right">
						<div class="detail-icons">
							<div class="discount piyasa-indirim">%{%PIYASA_INDIRIM_ORANI%}</div>
							{%func-data_mcrubs%}
						</div>
						<div style="clear:both;"></div>
						<div class="detail-badge"><img src="templates/mcshop/img/detailbadge.png" alt="" /></div>
						<div class="point">{%PUAN%}</div>
					</div>
					<div style="clear:both;"></div>
					<div class="read-comments">
						<a href="" onclick="$('.yorum-li').click(); return false;">Yorumları oku <b>({%YORUM_SAYISI%})</b></a>
						<ul>
							<li>{%URUN_PUAN%}</li>
						</ul>
					</div>
					<div class="detail-process-links">
						{%URUN_KULLANICI_SECENEKLERI%}
					</div>
				</div>
				<!-- //detail info -->
				<div style="clear:both;"></div>
			</div>
			<!-- //detail block -->
			<!-- detail tabs -->
			<div class="detail-tabs">
				<script type="text/javascript">
					$(document).ready(function(){
						$(".detail-tab-content").eq(0).show();
						$("#detail-tab-titles li").eq(0).addClass("detail-active");
						$("#detail-tab-titles li").click(function(){
							var number = $(this).index();
						$("#detail-tab-titles li").removeClass("detail-active");
						$(".detail-tab-content").hide().eq(number).fadeIn("slow");
						$("#detail-tab-titles li").eq(number).addClass("detail-active");
						});
					});
				</script>
				<ul id="detail-tab-titles">
					<li>Ürün Özellikleri</li>
					<li>Ödeme</li>
					<li>Yorumlar</li>
					<li>Soru ve Cevaplar</li>
				</ul>
				<div class="detail-tab-wrap">
					<div class="detail-tab-content">
						{%DB_DETAY%}
                        <div class="clear-space"></div>
					</div>
					<div class="detail-tab-content">{%TAB_TAKSIT%}<div class="clear-space"></div></div>
					<div class="detail-tab-content">{%TAB_YORUM%}</div>
					<div class="detail-tab-content">{%TAB_SORU%}</div>
				</div>
			</div>
			<!-- //detail tabs -->
			<!-- other products -->
			<div class="other-products">
				<div class="other-title">Benzer Ürünler</div>
				<div class="other-wrap">
					<ul class="other-slider">
						{%func-data_mcbenzer%}
					</ul>
					<div style="clear:both;"></div>
					<script type="text/javascript">
						$(document).ready(function(){
						  $('.other-slider').bxSlider({
							slideWidth: 198,
							minSlides: 5,
							maxSlides: 5,
							slideMargin: 11
						  });
						});
					</script>
				</div>
			</div>
			<!-- //other products -->
            <div class="clear-space"></div>
		</div>