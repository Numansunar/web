<li class="col-xs-6 col-sm-4">
<div class="product-container">
	<div class="left-block">
	<div class="catalog-item-ribbons">
		{%func-data_kargobeles%}
		{%func-data_tukendim%}
		{%func-data_yeniUrun%}
	</div>

	<div class="buttons">
		<a class="addtowishlist" href="#" onclick="{%ALARM_LISTEM_CLICK%}"><i class="material-icons">favorite_border</i></a>
		<a class="addtocart hidden-xs hidden-sm hidden-md" href="#" onclick="{%SEPETE_EKLE_AJAX%}"><i class="material-icons">shopping_cart</i></a>
	</div>

	<div class="clearfix"></div>
	<a href="{%URUN_DETAY_LINK%}" class="imgLink">
		{%func-data_tukendimBadge%}
		<img class="lozad" alt="{%DB_NAME%}" src="templates/orion/images/placeholder.jpg" data-src="resizer/400x400/2/images/urunler/{%DB_RESIM%}" loading="lazy">
		{%func-data_urunResim2%}
	</a>
	</div> 

	<div class="right-block">
		<h5 class="product-name"><a href="{%URUN_DETAY_LINK%}" title="{%DB_NAME%}">{%DB_NAME%}</a></h5>
		<div class="content_price">
			{%func-data_indirimOranList%}
			<span class="price old-price" data-oldprice="{%DB_PIYASAFIYAT%}">{%URUN_PIYASA_FIYAT%}</span>
			<span class="price product-price">{%URUN_FIYAT%}</span> 
		</div>
	</div>

</div>
</li>