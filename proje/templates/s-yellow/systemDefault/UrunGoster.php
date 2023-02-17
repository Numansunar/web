<div class="sag_urun">

	<div class="facebook_begen_buton">
		<iframe src="http://www.facebook.com/plugins/like.php?href=http://www.SITEADI.com%2F%3FurunID={%DB_ID%}&amp;layout=standard&amp;show_faces=false&amp;width=400&amp;action=like&amp;colorscheme=light&amp;height=35" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:400px; height:35px;" allowTransparency="true"></iframe>
	</div>
	
	<div class="urun_resimleri">
		{%FUNC_urunGoster_ResimList%}
	</div>
	
	<div class="urun_bilgisi">
		<div class="u1" style="position:absolute; width:300px;">
		<div class="urun_ismi"> {%URUN_BASLIK%}</div>
		<div class="ek_fiyat"> +{%DB_FIXKARGOFIYAT%} TL Kargo (KDV DAHİL)</div>
		</div>
		<div class="u2">
		<div class="fiyat"> {%URUN_FIYAT_KDV_DAHIL_YTL%} TL </div>
		<div class="siparis_ver"><a style="cursor:pointer" title="{%URUN_BASLIK%} Sipariş ver" onclick="{%HEMEN_AL_LINK%}">Sipariş</a></div>
		</div>
		<div class="clear" style="height:5px;"></div>
		<a name="Yorum"></a>
		{%FUNC_urunGoster_LoginForm%}
	</div>
</div>
</div>

<div class="urun_detaylari">

<div class="detay">
<h3>{%URUN_BASLIK%}</h3>
{%DB_DETAY%}
</div>

<ul class="alt_iconlar">
<li style="padding-left:30px;"><a target="_blank" href="http://www.facebook.com/share.php?u={%FUNC_selfURL%}"><img id="sol-menu-icon-1" src="templates/s-yellow/images/sn/facebook1.png" width="16" height="16" /></a></li>
<li><a target="_blank" href="http://www.facebook.com/xxxx"><img id="sol-menu-icon-7" src="templates/s-yellow/images/sn/facebook3.png" width="16" height="16" /></a></li>
<li><a target="_blank" href="http://www.facebook.com/home.php#/group.php?gid=xxxx"><img id="sol-menu-icon-2" src="templates/s-yellow/images/sn/facebook2.png" width="16" height="16" /></a></li>
<li><a target="_blank" href="http://friendfeed.com/xxx"><img id="sol-menu-icon-3" src="templates/s-yellow/images/sn/friendfrend.png" width="16" height="16" /></a></li>
<li><a target="_blank" href="http://twitter.com/xxxx"><img id="sol-menu-icon-4" src="templates/s-yellow/images/sn/twitter.png" width="16" height="16" /></a></li>
<!--
<li><a target="_blank" href="http://fusion.google.com/add?source=atgs&amp;feedurl=http://www.domain.com/rss/urunler"><img id="sol-menu-icon-5" src="templates/s-yellow/images/sn/google.png"width="16" height="16" /></a></li>
<li><a href="http://www.domain.com/rss/urunler"><img id="sol-menu-icon-6" src="templates/s-yellow/images/sn/rss.png" width="16" height="16"></a /></li>
-->
</ul>

</div>