<li class="col-xs-6 col-sm-3">
<div class="product-container">
	<div class="left-block">
	<div class="catalog-item-ribbons">
			{%func-data_kargobeles%}
			{%func-data_tukendim%}
			{%func-data_yeniUrun%}
		</div>
		<div class="clearfix"></div>
		<a href="{%URUN_DETAY_LINK%}">
			<img alt="{%DB_NAME%}" src="{%IMG_400%}">
			{%func-data_urunResim2%}
		</a>

	</div>
	<div class="right-block">
		<h5 class="product-name"><a href="{%URUN_DETAY_LINK%}" title="{%DB_NAME%}">{%DB_NAME%}</a></h5>
		<div class="content_price">
			{%func-data_indirimOranList%}
			<span class="price old-price" data-oldprice="{%URUN_PIYASA_FIYAT%}">{%URUN_PIYASA_FIYAT%}</span>
			<span class="price product-price">{%URUN_FIYAT%}</span> 
		</div>
		<div class="button-group hidden">
			<a class="btn-add-cart" href="{%URUN_DETAY_LINK%}">ÜRÜNÜ İNCELE</a>
		</div>
	</div>
</div>
</li>