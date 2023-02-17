<?php 
 
include "baglan.php";
ob_start();
session_start();
 
if(!isset($_SESSION["login"])){
    header("Location:admingiris.php");
}
else {
 
    echo "<a href=logout.php class=\"baslik\">Güvenli Çıkış</a></center>";
}
?>
<div >
<ul class="sonarmenu">
<li><a href="yonetici.php">Konu Ekle</a></li>
<li><a href="menuekle.php"  >Menü Ekle</a></li>


</ul>
</div>
<div class="konuForm">
<form action="menuek.php" method="post">
<h2 class="baslik">Konu Ekleme</h2>
<table width="300px" >
	<tr>
			<td>
				<label>Yan Menü Başlık</label>
			</td>
			<td>
				<input type="text" name="yan">
			</td>
		</tr>
			<tr>
		<td>
			<label>Hangi Ana Menü</label>
		</td>
		<td>
			
			<?php 
				$query = $db->query("select * from ustmenu", PDO::FETCH_ASSOC);

			if ( $query->rowCount() )
			{
				echo "<select name=\"select\"  id=\"select\">";
    			 foreach( $query as $row )
		    	 {
					echo "<option >".$row['baslik']."</option>";
        		 }
        		 echo '</select>';
   			 }
   				
		else
			{
    			echo "Hic kayit yok!";
			}


		
			?>

			
		</td>
	</tr>
		<tr>
			<td>
				<label>Başlık1</label>
			</td>
			<td>
				<input type="text" name="b1">
			</td>
		</tr>
		<tr>
			<td>
				<label>Yazı1</label>
			</td>
			<td>
				<input type="text" name="y1">
			</td>
		</tr>
		<tr>
			<td>
				<label>Başlık2</label>
			</td>
			<td>
				<input type="text" name="b2">
			</td>
		</tr>
			<tr>
			<td>
				<label>Yazı2</label>
			</td>
			<td>
				<input type="text" name="y2">
			</td>
		</tr>


	</table>

<input class="subMenuEkle" type="submit" name="sub" value="Ekle">

</form>
</div>


