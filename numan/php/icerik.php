<div class="content">
			<?php	
				$deger1=$_REQUEST["para2"];
				if($_REQUEST["para2"]=="")
				{
					$deger1=0;
				}
				
			$query = $db->query("SELECT * from icerik where yanMenuId=$deger1", PDO::FETCH_ASSOC);

			if ( $query->rowCount() )
			{
    			 foreach( $query as $row )
		    	 {
		    	 	$ifade0="<h1 class=\"title\">".$row['baslik']."</h1>";
		    	 	$ifade4="<p class=\"title\">".$row['yazi']."</p>";
		    	 	$ifade2="<h1 class=\"title\">".$row['baslik2']."</h1>";
		    	 	$ifade3="<p class=\"title\">".$row['yazi2']."</p>";
        		 }
   			 }
   			 echo $ifade0;
   			 echo $ifade4;
   			 echo $ifade2;
   			 echo $ifade3;

  			?>
				

			</div>
		</div>
	<!-- Designed by DreamTemplate. Please leave link unmodified. -->
<br><center>
<a href="https://www.instagram.com/numan.sunar" title="Website Templates" target="_blank">@NUMAN SUNAR</a>
</center>
</body>
</html>


