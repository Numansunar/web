<?php 
$out=insertBanner('vitrin_ust').'			<div id="left">
					'.markaAnaListe().'				
				</div><!--#left END-->
				<div id="right">
				<div class="invite">
					<form method="get" action="page.php">
                        <input type="hidden" name="act" value="modDavet" />
						<input type="text" name="email" value="E-Posta adresi girin" onfocus="if(this.value==\'E-Posta adresi girin\')this.value=\'\';" onblur="if(this.value==\'\') this.value=\'E-Posta adresi girin\';" class="input" />
						<input type="submit" class="submit" value="" />
					
					</form>
					<a href="page.php?act=modDavet">Birden çok arkadaşınızı davet etmek için lütfen tıklayın</a>
				</div><!--.invite END-->
				<div class="ads">
					<a href="#"><img src="templates/p-brown/samples/2.jpg" /></a>
				</div>
			
			</div><!--#right END-->'.insertBanner('vitrin_alt');
$PAGE_OUT=$out;
?>