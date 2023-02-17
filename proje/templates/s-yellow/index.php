<?php
if (!$_GET['urunID']) $_GET['urunID'] = hq("select ID from urun where stok > 0 AND start < now() AND finish > now() order by seq desc,start asc limit 0,1");
if ($_GET['urunID']) $out ='			<div class="gunun_firsati">
			
				<ul class="sol_iconlar">
				<li>'.insertBanner('paro').'</li>
				<li><a target="_blank" href="http://www.facebook.com/share.php?u='.selfURL().'"><img id="sol-menu-icon-1" src="templates/s-yellow/images/sn/facebook1.png" class="" /></a></li>
				<li><a target="_blank" href="http://www.facebook.com/xxxx"><img id="sol-menu-icon-7" src="templates/s-yellow/images/sn/facebook3.png" class="" /></a></li>
				<li><a target="_blank" href="http://www.facebook.com/home.php#/group.php?gid=xxxx"><img id="sol-menu-icon-2" src="templates/s-yellow/images/sn/facebook2.png" class="" /></a></li>
				<li><a target="_blank" href="http://friendfeed.com/xxx"><img id="sol-menu-icon-3" src="templates/s-yellow/images/sn/friendfrend.png" class="" /></a></li>
				<li><a target="_blank" href="http://twitter.com/xxxx"><img id="sol-menu-icon-4" src="templates/s-yellow/images/sn/twitter.png" class="" /></a></li>
				<!--
				<li><a target="_blank" href="http://fusion.google.com/add?source=atgs&amp;feedurl=http://www.domain.com/rss/urunler"><img id="sol-menu-icon-5" src="templates/s-yellow/images/sn/google.png" class="" /></a></li>
				<li><a href="http://www.domain.com/rss/urunler"><img id="sol-menu-icon-6" src="templates/s-yellow/images/sn/rss.png" class="" /></a></li>
				-->
				</ul>
			'.showItem($_GET['urunID']).'			
			<div class="facebook_begen_kutusu">
				<iframe src="http://www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2F%23%21%2Fpages%2FSULUGOZ%2F131096710259444&amp;width=593&amp;connections=20&amp;stream=false&amp;header=true&amp;height=287" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:593px; height:287px;" allowTransparency="true"></iframe>
			</div>';
if (!hq("select ID from urun where ID='".$_GET['urunID']."' AND stok > 0 AND start < now() AND finish > now() order by seq desc,start asc limit 0,1")) 
{
	$out.="<style>.siparis_ver { visibility:hidden; }</style>";
}
$PAGE_OUT = $out;
?>