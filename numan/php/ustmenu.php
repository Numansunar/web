<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<title>Your Blog</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" media="screen" href="css/style.css" />
	</head>
	<body>

		<div class="container">
			<div class="header"><span>Numan SUNAR blog</span></div>
			<div class="menuu">
			<?php
				$ifade1="<ul>";
				$query = $db->query("SELECT * FROM ustmenu", PDO::FETCH_ASSOC);
				if ( $query->rowCount() )
				{
			    	 foreach( $query as $row )
			    	 {
			    	 	$ifade1.="<li><a href=\"index.php?para1=".$row['Id']."\">".$row['baslik']."</a></li>";
			    	 	
			         }
			    }

			    $ifade1.="</ul>";
			    echo $ifade1; 

			?>
			


			</div>
			<div class="yonetici">

				<a href="html/index.html">Yönetici Girişi</a>

			</div>
