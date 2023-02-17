<?php
function siparisOdemeSecimX($query)
{
	global $siteDizini;

	$q = my_mysql_query($query);
	$orgGet = $_GET;
	
	$_GET['act'] = 'satinal';
	$_GET['op'] = 'odeme';
	$azamiTaksit = hq("select ay from bankaVade,banka where bankaID=banka.ID AND banka.active = 1 order by ay desc limit 0,1");
	while($d = my_mysql_fetch_array($q))
	{
		
		$d = translateArr($d);
		$list = true;
		if (($d['cat'] && $d['cat'] != '0') || ($d['marka'] && $d['marka'] != '0'))
		{
			$qSepet = my_mysql_query("select * from sepet where randStr like '".$_SESSION['randStr']."'");
			while($dSepet = my_mysql_fetch_array($qSepet))
			{
				$qUrun = my_mysql_query("select * from urun where ID='".$dSepet['urunID']."'");
				$urun = my_mysql_fetch_array($qUrun);
				if ($d['cat'] && $d['cat'] != '0') if(!(stristr($d['cat'],','.$urun['catID'].',') === false)) 
				{
					$list=false;
					/*
					$catArray = explode('|',$urun['showCatIDs']);
					foreach($catArray as $catVal)
					{
						if(!(stristr($d['cat'],','.$catVal.',') === false) && ((int)$catVal)) 
							$list = true;		
					}
					*/
				}
				if ($d['marka'] && $d['marka'] != '0') if(!(stristr($d['marka'],','.$urun['markaID'].',') === false)) 
				{
					$list=false;
				}
			}
		}
		if(!$list)
			continue;
		
		$_GET['paytype'] = $d['ID'];
		$suAnkiToplamOdeme = basketInfo('ModulFarkiIle',$_SESSION['randStr']);
		if($d['taksitOrani'])
		{
			$logoTH.='<th><center>'.($d['odemeLogo']?'<img src="images/banka/'.$d['odemeLogo'].'">':$d['bankaAdi']).'</center></th>';
			for($i=1;$i<=$azamiTaksit;$i++)
			{
					if(azamiTaksit() < $i) continue;	
				$p = hq("select plus from bankaVade where bankaID='".$d['ID']."' AND ay = '$i'");
				$goster = ($p?$i.' (+'.$p.')':$i);	
				if(hq("select ID from bankaVade where bankaID='".$d['ID']."' AND ay = '$i' AND minfiyat <= $suAnkiToplamOdeme") || $i==1)
				{
					$onclick = 'onclick="$(\'#paytype\').val(\''.$d['ID'].'\'); $(\'#taksit\').val(\''.$i.'\'); "';	
					if($i == 1)
						$taksitTD[$i].='<td class="auto-radio-click"><div class="inputodeme"><input '.$onclick.' type="radio" name="radio" > </div><span class="taksittext">'.my_money_format('%i',taksitliOdemeHesalpa($suAnkiToplamOdeme,$i,$d['ID'])).' TL</span></td>';
					else
						$taksitTD[$i].='<td class="auto-radio-click"><div class="inputodeme"> <input '.$onclick.' type="radio" name="radio" ></div><span class="taksittext"> '.$goster.' x '.my_money_format('%i',(taksitliOdemeHesalpa($suAnkiToplamOdeme,$i,$d['ID']) / $i)).' TL </span><span class="taksitmebla">'.my_money_format('%i',taksitliOdemeHesalpa($suAnkiToplamOdeme,$i,$d['ID'])).' TL</span></td>';
				}
				else
					$taksitTD[$i].='<td>&nbsp;</td>';
			}
		}
	}
	$_GET = $orgGet;
	$x = my_mysql_query('select * from bankaHavale order by bankaAdi');
	while ($d = my_mysql_fetch_array($x)) {
		$bankaTR.='<tr>
                    <td>'.$d['bankaAdi'].'</td>
                    <td>'.$d['bankaSubeAdi'].'</td>
					<td>'.$d['bankaKullaniciAdi'].'</td>
					<td>'.$d['bankaSubeKodu'].'</td>                    
                    <td>'.$d['bankaHesapNo'].'</td>
                  </tr>';
	}
	$havaleID = hq("select ID from banka where minsiparis <= ".basketInfo('ModulFarkiIle',$_SESSION['randStr'])." AND active = 1 AND paymentModulURL like '%payment_havale%' order by minsiparis desc limit 0,1");
	$kapidaID = hq("select ID from banka where minsiparis <= ".basketInfo('ModulFarkiIle',$_SESSION['randStr'])." AND active = 1 AND paymentModulURL like '%payment_kapida%' order by minsiparis desc limit 0,1");
	$mobilID = hq("select ID from banka where minsiparis <= ".basketInfo('ModulFarkiIle',$_SESSION['randStr'])." AND active = 1 AND paymentModulURL like '%payment_mobil%' order by minsiparis desc limit 0,1");
	$out='
	<input type="hidden" id="paytype">
	<input type="hidden" id="taksit" value="1">
	  <script src="include/3rdparty/Odeme/js/arnoTabs.js"></script>
	  <script>
	  $(document).ready(function(){
		$(".auto-radio-click").click(function() { $(this).find("input[type=radio]:first").click(); });
		$(".paymentTab").arnoTab();
	  });
	  </script>
	<link rel="stylesheet" type="text/css" href="include/3rdparty/Odeme/css/style.css" />
	 <div class="payment">
	<div class="paymentTab">        
        <div class="tabLinks">
          <ul>
            <li><a href="#" class="pt1" data-tablink="1" onclick="$(\'#paytype\').val(\'0\');" >Kredi kartı</a></li>';
	if($havaleID)
	{
		$out.='<li><a href="#" class="pt2" data-tablink="2" onclick="$(\'#paytype\').val(\''.hq("select ID from banka where paymentModulURL like '%payment_havale%'").'\'); $(\'#taksit\').val(\'0\');">Havale</a></li>';
		
		$tab[2] = '          <div class="tab" data-tab="2">
				<div class="orderTable">
				  <h2>Havale Bilgileri</h2>
				  <span class="havaleOdemePaytab">Havele yaptıktan sonra, gelen e-posta\'daki adresten havale bildiriminde bulunmayı unutmayın.</span>
				  <table class="havaleTablo">
					<thead>
					  <tr>
						<th>BANKA ADI</th>
						<th>ŞUBE ADI</th>
						<th>HESAP SAHİBİ</th>
						<th>HESAP NO</th>						
						<th>IBAN</th>
					  </tr>
					</thead>
					<tbody>
					  '.$bankaTR.'
					</tbody>
				  </table>
				  <p>Havalenizi yaparken işlem açıklamasında mutlaka sipariş numarasını belirtiniz.</p>
				</div><!-- /.orderTable -->
			
			  </div><!-- /.tab -->';
	}
	if($kapidaID)
	{
		$out.='<li><a href="#" class="pt3" data-tablink="3" onclick="$(\'#paytype\').val(\''.$kapidaID.'\'); $(\'#taksit\').val(\'0\');">Kapıda Ödeme</a></li>';	
		$tab[3] = '<div class="tab" data-tab="3">';
		$q = my_mysql_query("select * from banka where paymentModulURL like '%payment_kapida%' AND active =1 order by seq");		  
		$tab[3].='  <div class="paymentTable">
              <table>			  
                <tbody class="trcheck">';
		while($d = my_mysql_fetch_array($q))
		{
			if($d['maxsiparis'] && basketInfo('ModulFarkiIle',$_SESSION['randStr']) > $d['maxsiparis']) continue;
			if($d['minsiparis'] && basketInfo('ModulFarkiIle',$_SESSION['randStr']) < $d['minsiparis']) continue;
					
			$tab[3].='<tr>
                    <th class="taksittitle" style="width:300px; text-align:left;">'.$d['bankaAdi'].'</th>
					<td class="auto-radio-click"><div class="inputodeme"> <input type="radio" onclick="$(\'#paytype\').val(\''.$d['ID'].'\');" name="radio" style="float:left;" ></div><span class="taksittext"></span></td>
                  </tr>';
		}
        $tab[3].='</tbody></table></div>';
		$tab[3].='
			  </div><!-- /.tab --> ';
	}
	
	if($mobilID)
	{
		$out.='<li><a href="#" class="pt4" data-tablink="4" onclick="$(\'#paytype\').val(\''.$mobilID.'\'); $(\'#taksit\').val(\'0\');">Mobil Ödeme</a></li>';	
		$tab[4] = '<div class="tab" data-tab="4">
				<div class="orderTable">
				  <h2>Mobil Ödeme seçildi!</h2>
				   <p>'.hq("select odemeAciklama from banka where ID='$mobilID'").'</p>
				</div>
			  </div><!-- /.tab --> ';
	}
	
	$q = my_mysql_query("select * from banka where paymentModulURL not like '%payment_kapida%' AND paymentModulURL not like '%payment_havale%' AND paymentModulURL not like '%payment_mobil%' AND (taksitOrani = '' OR taksitOrani = '0') AND active =1 order by seq");
	if(my_mysql_num_rows($q))	
	{
		//$out.='<li><a href="#" class="pt5" data-tablink="5" onclick="$(\'#paytype\').val(\''.hq("select ID from banka where paymentModulURL like '%payment_paypal%'").'\'); $(\'#taksit\').val(\'0\');">Paypal</a></li>';	
		$tab[5] = '<div class="tab" data-tab="5">';
				  
		$tab[5].='  <div class="paymentTable">
              <table>			  
                <tbody class="trcheck">';
		while($d = my_mysql_fetch_array($q))
		{
			if(!(stristr($d['paymentModulURL'],'payment_promosyon') === false) && ((float)basketInfo('ModulFarkiIle',$_SESSION['randStr']) > 0)) continue;
			if ((!$_SESSION['userID'] || !hq("select bakiyeEkleyebilir from userGroups where ID='".userGroupID()."'")) && !(stristr($d['paymentModulURL'],'payment_kredi') === false)) continue;
			$tab[5].='<tr>
                    <th class="taksittitle" style="width:300px; text-align:left; ">'.$d['bankaAdi'].'</th>
					<td class="auto-radio-click"><div class="inputodeme"> <input type="radio" onclick="$(\'#paytype\').val(\''.$d['ID'].'\');" name="radio" style="float:left;" ></div><span class="taksittext"></span></td>
                  </tr>';
			$tab5 = true;
		}
        $tab[5].='</tbody></table></div>';
		$tab[5].='
			  </div><!-- /.tab --> ';
		if(!$tab5) unset($tab[5]);
	}
            
            
 $out.='</ul>
        </div><!-- /.tabLinks -->
        <div class="tabs">
          <div class="tab" data-tab="1">
            <div class="paymentTable">
              <table>
                <thead>
                  <tr class="white">
                    <th>&nbsp;</th>
                    '.$logoTH.'
                  </tr>
                </thead>
                <tbody class="trcheck">
                  <tr>
                    <th class="taksittitle">Tek Çekim</th>
                    '.$taksitTD[1].'
                  </tr>';
 for($i=2;$i<=$azamiTaksit;$i++)
 {
	 	if(azamiTaksit() < $i) continue;	
		$out.='<tr>
                    <th class="taksittitle">'.$i.' Taksit</th>
                     '.$taksitTD[$i].'
                  </tr>'; 
 }
                  
 $out.='
                </tbody>
              </table>
            </div><!-- /.paymentTable -->
          </div><!-- /.tab -->
          '.$tab[2].$tab[3].$tab[4].$tab[5].'
     	        
        </div><!-- /.tabs -->
      </div>  	  
	  </div> <input onclick="if(parseInt($(\'#paytype\').val()) > 0) { window.location.href = \''.$siteDizini.'page.php?act=satinal&op=odeme&paytype=\' + $(\'#paytype\').val() + \'&taksit=\'+ $(\'#taksit\').val(); } else alert(\''._lang_hataOdemeSecim.'\');" class="sf-button sf-button-large sf-neutral-button" style="font-size:14px; float:right;" type="button" value="'._lang_onayliyorum.'" />
	  <div style="clear:both"></div>
	  '."
	  <script>
	  	$('tbody.trcheck > tr').each(function() { if(!$(this).find('input').length) $(this).hide(); });
	  </script>
	  ";
	  
	  return $out;
}
?>