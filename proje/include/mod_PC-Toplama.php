<?php
function pcToplama() {
	global $siteConfig;
	$out.="<style>	
	.pcToplama select { width:300px; }
	.pcToplama td { padding:2px; }
	.pcToplama .stok { width:auto; }
	.pcToplama .stok div { text-align:center; }
	.pcToplama .catName { text-align:right; }
	#pcToplamaSatirEkle { cursor:pointer; font-weight:bold; text-decoration:underline; }
	#pcToplamaSatirSelect { width:auto; }
	</style>	
	";
	$out.="<script>
				var urunGercekFiyat = new Array();
				var urunFiyat = new Array();
				var urunKDVHaricFiyat = new Array();
				var urunStok = new Array();
				var urunResim = new Array();
				var catNum = new Array();
				var dolar = '".hq("select value from fiyatbirim where code like 'USD'")."';
				var euro = '".hq("select value from fiyatbirim where code like 'EUR'")."';
				var havaleindirim = '".siteConfig('havaleIndirim')."';
				$(document).ready(function() {
					$('#pcToplamaSatirEkle').click(function()
					{
						  $.ajax({
						  url: 'include/ajaxLib.php?act=pcToplamaCat&catID=' + $('#pcToplamaSatirSelect').val() + '&toplamkategori=' + toplamkategori + '&r='+ Math.floor(Math.random()*99999),
						  success: function(data) 
								   { 
								    	toplamkategori++;
								   		$('.catTr:last').after(data);
								   }

						  });
					});				
				});
		   </script>";
	$out.='<table class="pcToplama" cellspacing=3 cellpadding=2>';
	$out.='<tr class="sepet">';
	$out.='<th colspan=3>Kategori</th>';
	$out.='<th>Stok</th>';
	$out.='<th>Adet</th>';
	$out.='<th>Fiyat</th>';
	$out.='</tr>';
	$q = my_mysql_query("select * from kategori where PCToplama=1 AND active=1 order by seq");
	$i=1;
	$catID = $d['ID'];
	while($d=my_mysql_fetch_array($q)) {
		//$onChangeInsert = ($i==1?"updateKategori(this.options[this.selectedIndex].value);":"");
		$prefix = substr(md5(time()),0,5);
		$d['ID'] = $prefix.'_'.$d['ID'].'_';
		$out.='<script>catNum['.$i.'] = \''.$d['ID'].'\';</script>';
		$out.='<tr class="catTr"><td class="catName"><nobr>'.$d['name'].' : </nobr></td><td id="catNum_'.$i.'"><select onchange="'.$onChangeInsert.'updateFiyat(this.options[this.selectedIndex].value,\''.$d['ID'].'\')" id="urunSelected_'.$d['ID'].'" name="pctURUN[]"><option value=0>L??tfen Se??in</option>';
		$q2 = my_mysql_query("select urun.* from urun,kategori where urun.catID = kategori.ID and kategori.idPath like '".$d['idPath']."%' order by urun.name");
		while ($d2=my_mysql_fetch_array($q2)) {
			$fiyat = fixFiyat($d2['fiyat'],0,$d);
			$out.='<option value="'.$d2['ID'].'">'.$d2['name'].'</option>';
			$out.="
			<script>
				urunGercekFiyat[".$d2['ID']."] = '".str_replace(',','',YTLfiyat($fiyat,$d2['fiyatBirim']))."';
				urunKDVHaricFiyat[".$d2['ID']."] = '".str_replace(',','',(YTLfiyat($fiyat,$d2['fiyatBirim']) - (YTLfiyat($fiyat,$d2['fiyatBirim']) * $d2['kdv'])))."';
				urunFiyat[".$d2['ID']."] = '".str_replace(',','',my_money_format('%i',YTLfiyat($fiyat,$d2['fiyatBirim'])))."';
				urunStok[".$d2['ID']."]  = ".str_replace(',','',dbInfo('urun','stok',$d2['ID'])).";					 				urunResim[".$d2['ID']."] = '".getFirstPic($d2['ID'])."';		
			</script>";			
		}
		$out.='</td>';
		$out.='<td><a href="#" id="detail_href_'.$d['ID'].'" onMouseOver="if (this.href.indexOf(\'#\') < 0) ShowDetailPic(\''.$d['ID'].'\')" onMouseOut="document.getElementById(\'detail_div_'.$d['ID'].'\').style.display = \'none\';"><img id="detail_image_'.$d['ID'].'" src="templates/'.siteConfig('templateName').'/images/detail.gif"><br>
			<div style="border:1px solid #dddddd; padding:5px; background-color:white; margin-top:5px; position:absolute; display:none; z-index:20;" id="detail_div_'.$d['ID'].'"></div>
		</td>';
		$out.='<td>
		 <div class="stok" id="stok_'.$d['ID'].'">'.textBox('#dddddd','white',9,'&nbsp;').'</div>
		 <div class="stok" id="stok_var_'.$d['ID'].'" style="display:none">'.textBox('#90be00','white',9,'var').'</div>
		 <div class="stok" id="stok_yok_'.$d['ID'].'" style="display:none">'.textBox('#FF0000','white',9,'yok').'</div>
		 <div class="stok" id="stok_def_'.$d['ID'].'" style="display:none">'.textBox('#dddddd','white',9,'&nbsp;').'</div>		 
		</td>';
		$out.='<td><input size=1 onchange="updateAdet(this.value,\''.$d['ID'].'\')" value=1 id="adet_'.$d['ID'].'" name="pctADET[]"></td>';
		$out.='<td><input onchange="alert()" disabled="disabled" size=5 value=0 id="fiyat_'.$d['ID'].'"> &nbsp; TL </td>';
		$out.='</tr>';
		$i++;
	}
	$out.='<script>var toplamkategori = \''.($i - 1).'\';var updatekategori = \''.($i - 1).'\';</script>';
	$out.='<tr><td class="catName"><br>Yeni : </td><td colspan=5 align="left"><br><select id="pcToplamaSatirSelect">';
	$qCat = my_mysql_query("select * from kategori where  PCToplama=1 order by seq");
	while($dCat=my_mysql_fetch_array($qCat))
	{
		$out.='<option value="'.$dCat['ID'].'">'.$dCat['name'].'</option>'."\n";
	}
	$out.='</select> <span id="pcToplamaSatirEkle">sat??r?? ekle</span></td></tr>';
	$out.='<tr><td colspan=6>';
	$out.='<div class="sepetToplam">';
		$out.='<table>';
		$out.='<tr><td class="td1">Sistem Toplam?? (KDV Dahil)</td><td class="td2">:</td><td class="td3"><span ID="kdvdahil">0</span> TL</td></tr>';
		//$out.='<tr><td class="td1">Sistem Toplami (KDV Hari??)</td><td class="td2">:</td><td class="td3"><span ID="kdvharic">0</span> TL</td></tr>';
		//$out.='<tr><td class="td1">KDV</td><td class="td2">:</td><td class="td3"><span ID="toplamkdv">0</span> TL</td></tr>';
		$out.='<tr><td colspan="3" class="gri_menu_sep_td"><div class="gri_menu_sep_div"></div></td></tr>';	
		$out.='<tr><td class="toplam">TOPLAM (TL)</td><td class="td2">:</td><td class="toplam"><span ID="toplamytl">0</span> TL</td></tr>';
		$out.='<tr><td class="toplam">TOPLAM (Dolar)</td><td class="td2">:</td><td class="toplam"><span ID="dolar">0</span> USD</td></tr>';
		$out.='<tr><td class="toplam">TOPLAM (Euro)</td><td class="td2">:</td><td class="toplam"><span ID="euro">0</span> EUR</td></tr>';
		if (siteConfig('havaleIndirim')) $out.='<tr><td class="toplam">HAVALE INDIRIMI ILE (%'.(siteConfig('havaleIndirim') * 100).')</td><td class="td2">:</td><td class="toplam"><span ID="havaleile">0</span> TL</td></tr>';
		$out.='</table>';
		$out.='</div>';
		
		$out.='<div style="clear:both;"></div><div class="urunInfo" id="SistemSepeteEkleDiv" style="text-align:right; margin-top:14px; margin-bottom:-4px;"><table cellpadding="0" cellspacing="0" align="right"><tr><td style="padding-right:6px;" onClick="sistemTeklifeEkle()"><span class="button"><img src="templates/'.siteConfig('templateName').'/images/form_Teklif.gif"></span></td><td style="padding-right:6px;" onClick="sistemSepeteEkle()"><span class="button"><img src="templates/'.siteConfig('templateName').'/images/form_SepeteAt.gif"></span></td></tr></table></div>';		
		$out.='</td><td></td></tr></table>';
	return $out;
}
?>