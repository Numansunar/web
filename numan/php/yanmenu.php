<div class="main_nav">	
	
				<div class="sub_menu">
					<div>Menu</div>
							<?php 
	
								$deger=$_REQUEST["para1"];
								if($_REQUEST["para1"]=="")
									{
										$deger=0;
									}
								$query = $db->query("SELECT * FROM yanmenu where anaMenuId=$deger", PDO::FETCH_ASSOC);


								$ifade="<ul >";
								if ( $query->rowCount() )
								{
							    	 foreach( $query as $row )
							    	 {
							    	 	$ifade.="<li ><a href=\"index.php?para1={$_GET["para1"]}&para2=".$row['Id']."\">".$row['yanMenuAdi']."</a></li>";   	 	
							         }
							    }

							    $ifade.="</ul>";
							    echo $ifade; 

							?>
				</div>

			</div>


