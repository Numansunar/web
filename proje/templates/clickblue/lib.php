<?php



function twoLevelTopMenu()
{
	global $siteConfig;
	$out= '
	<style>
		#nav ul{margin:0; padding:0;}
		#nav li{
			display:block;
			float:left;
			height:24px;
			margin-top:3px;
			xborder-left:1px solid #3a588e;
			padding-left:9px;
			padding-right:6px;
			margin-left:5px;
			padding-top:3px;
}

		#nav li:hover{
			background-color:#5a7db7;
					}
					
		#nav li:hover a {
			text-decoration:none;
			color:#fff;
		}

		#nav li:hover .navinner {
			display:block;
			z-index:100000;
			padding:0;
		}

		#nav .navinner a:hover { color:#bbb; }
		#nav li:first-child{
			border:none;		
		}
		#nav a{

			color:#fff;

			display:block;

			margin:0;

			margin-left:5px;

		}

		

		#nav div.navinner { position:absolute; border:6px solid #5a7db7; width:230px; background-color:white; font-size:11px; line-height:15px; font-weight:normal; margin-left:-9px; display:none;  }

		#nav .navinner ul { background:none; margin:10px; border:none; padding:0; }

		#nav .navinner ul li { background:none; clear:both; list-style:none; border:none; color:#555; padding:6px; border-bottom:1px solid #eee; display:block; width:200px; margin:0; height:auto; line-height:18px; }

		#nav .navinner ul li a { background:none; clear:both; border:none; padding:0; margin:0; color:#235c7d; }	

	</style>';

	

	

	$out.='<ul id="nav">';

	$q = my_mysql_query("select * from kategori where active =1 AND parentID='$parentID' order by seq,name");

	while($d = my_mysql_fetch_array($q))

	{

		$link= ($siteConfig['seoURL'] ? seoFix($d['name']).'-kat'.$d['ID'].'.html':'page.php?act=kategoriGoster&catID='.$d['ID'].'&name='.seoFix($d['name']));

		$out.='<li><a id="a'.$d['ID'].'" href="'.$link.'">'.$d['name'].'</a><div style="clear:both"></div>'."\n";

		if (hq("select name from kategori where parentID='".$d['ID']."'"))

		{

			$q2 = my_mysql_query("select * from kategori where active = 1 AND parentID='".$d['ID']."' order by seq,name");

			if (my_mysql_num_rows($q2))

			{

				$out.='<div class="navinner"><ul id="ul'.$d['ID'].'">'."\n";

				while ($d2 = my_mysql_fetch_array($q2))

				{

					$linkSub= ($siteConfig['seoURL'] ? seoFix($d2['name']).'-kat'.$d2['ID'].'.html':'page.php?act=kategoriGoster&catID='.$d2['ID'].'&name='.seoFix($d2['name']));

					$out.='<li><a id="a'.$d2['ID'].'"  href="'.$linkSub.'">'.$d2['name'].' &raquo; </a></li>'."\n";

				}

				$out.='</ul></div>'."\n";

				

			}

		}

		$out.='</li>';

	}

	$out.='</ul>';

	return $out;	

}



function liVitrin()

{

	$q = my_mysql_query("select * from kampanyaJSBanner order by seq");

	$out= '<ul>';

	while ($d=my_mysql_fetch_array($q))

	{		

		$out.="				<li>

                            	<a href='".$d['link']."'><img width='595' height='285' src='images/kampanya/".$d['resimJS']."' /></a>

                            </li> \n";

	}

	$out.='</ul>';

	return $out;

}

?>