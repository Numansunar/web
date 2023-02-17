<?php
    $baslik1=$_POST['b1'];
	$yazi1=$_POST['y1'];
	$baslik2=$_POST['b2'];
	$yazi2=$_POST['y2'];
	$yanmenub=$_POST['yan'];
	$deg=$_POST['select'];	
	
	include "baglan.php";	

			$query = $db->query('select * from ustmenu where baslik="'.$deg.'"', PDO::FETCH_ASSOC);

			if ( $query->rowCount() )
			{
				
    			 foreach( $query as $row )
		    	 {
					$deg1=$row['Id'];
        		 }
        		
   			 }

			
		
	$query1= $db->prepare("INSERT INTO 	yanmenu SET
										yanMenuAdi = ?,
										anaMenuId = ?");
										$insert = $query1->execute(array(
										     "$yanmenub", "$deg1"
										));
					if ( $insert )
					{
					    $last_id = $db->lastInsertId();			
					}

		$query = $db->query('SELECT * FROM yanmenu ORDER BY Id DESC LIMIT 1', PDO::FETCH_ASSOC);

			if ( $query->rowCount() )
			{
				
    			 foreach( $query as $row )
		    	 {
					$deg2=$row['Id'];
        			$ymenuId=$deg2;
        		 }
        		
   			 }
   			 if ($ymenuId<0)
			{
				$ymenuId=1;
			}




	$query = $db->prepare("INSERT INTO 	icerik  SET
										baslik = ?,
										yazi   = ?,
										baslik2 = ?,
										yazi2   = ?,
										yanmenuId = ?");
										$insert   = $query->execute(array(
										     "$baslik1", "$yazi1", "$baslik2","$yazi2","$ymenuId"
										));
					if ( $insert )
					{
					    $last_id = $db->lastInsertId();
					    print "Konu Başarıyla Kayıt Edildi.";
					}
			




?>

<h3>Yeni konu eklemek için <a href="yonetici.php">tıklayınız.</a></h3>