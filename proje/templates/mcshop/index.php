<?php
$PAGE_OUT = '
		<!-- discount bar -->
		<div class="discount-bar">01-07 Kasım tarihleri arasında Giyim, Kozmetik ve Elektronik ürünlerde <span>%60\'a</span> varan indirimleri kaçırmayın.</div>
		<!-- //discount bar -->
		<div class="showcase">
			<!-- main slider -->
			<div class="main-slider">
				<div id="main-slider">
					<ul>
						'.simpleVitrin().'
					</ul>
				</div>
			</div>
			<!-- //main slider -->
			<div style="clear:both;"></div>
		</div>
		<!-- //showcase -->
		<!-- info bar -->
		<div class="info-bar"><img src="templates/mcshop/img/infobar.png" alt="" /></div>
		<!-- //info bar -->
		<div class="page-head"><span>Sizin için Seçtiklerimiz</span> <div style="clear:both;"></div></div>
		<!-- first products -->
		<div class="highlight-products">
			<ul class="highlight-slider">
				'.urunList('select * from urun where anasayfa = 1 order by seq desc,ID desc','empty','UrunListIndexSliderShow').'
			</ul>
			<script type="text/javascript">
					$(document).ready(function(){
					  $(\'.highlight-slider\').bxSlider({
						slideWidth: 145,
						minSlides: 5,
						maxSlides: 5,
						slideMargin: 6
					  });
					});
				</script>
		</div>
		<!-- //first products -->
		<!-- home banner -->
		<div class="home-banner"><img src="templates/mcshop/img/banner.png" alt="" /></div>
		<!-- //home banner -->
		<div style="clear:both;"></div>
		<!-- home products -->
		
			<script type="text/javascript">
				$(document).ready(function(){
					$(".tab-content").eq(0).show();
					$("#tab-titles li").eq(0).addClass("active-tab");
					$("#tab-titles li").click(function(){
						var number = $(this).index();
					$("#tab-titles li").removeClass("active-tab");
					$(".tab-content").hide().eq(number).fadeIn("slow");
					$("#tab-titles li").eq(number).addClass("active-tab");
					});
				});
			</script>
			<!-- tab titles -->
			<ul id="tab-titles">
				<li class="active-tab">İndirime Girenler</li>
				<li>Yeni Eklenenler</li>
				<li>Sınırlı Stoklar</li>
			</ul>
			<div class="home-products">
			<!-- //tab titles -->
			<!-- tab wrap -->
			<div class="tab-wrap">
				<!-- tab content -->
				<div class="tab-content">
					'.urunList('select * from urun where indirimde = 1 order by seq desc,ID desc').'
					<div style="clear:both;"></div>
				</div>
				<!-- //tab content -->
				<!-- tab content -->
				<div class="tab-content">
					'.urunList('select * from urun where yeni = 1 order by seq desc,ID desc').'
					<div style="clear:both;"></div>
				</div>
				<!-- //tab content -->
				<!-- tab content -->
				<div class="tab-content">
					'.urunList('select * from urun where stok < 5 AND stok > 0 order by seq desc,ID desc').'
					<div style="clear:both;"></div>
				</div>
				<!-- //tab content -->
			</div>
			<!-- //tab wrap -->
		</div>
		<!-- //home products -->';
?>