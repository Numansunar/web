<?
@set_time_limit(0);
include('include/all.php');
exit('
{
	"name": "'.str_replace('"','',$siteConfig['seo_title']).'",
	"short_name": "'.str_replace('www.','',$_SERVER['HTTP_HOST']).'",
	"theme_color": "#CE1B28", 
	"background_color": "#2196f3",  
	"display": "standalone",
	"Scope": "/",
	"start_url": "'. 'http' . (siteConfig('httpsAktif') ? 's' : '') . '://' . $_SERVER['HTTP_HOST'] . $siteDizini .'",
	"icons": [
	  {
		"src": "images/icons/icon-16x16.png",
		"sizes": "16x16",
		"type": "image/png"
	  },
	  {
		"src": "images/icons/icon-32x32.png",
		"sizes": "32x32",
		"type": "image/png"
	  },
	  {
		"src": "images/icons/icon-64x64.png",
		"sizes": "64x64",
		"type": "image/png"
	  },
	  {
		"src": "images/icons/icon-72x72.png",
		"sizes": "72x72",
		"type": "image/png"
	  },
	  {
		"src": "images/icons/icon-96x96.png",
		"sizes": "96x96",
		"type": "image/png"
	  },
	  {
		"src": "images/icons/icon-128x128.png",
		"sizes": "128x128",
		"type": "image/png"
	  },
	  {
		"src": "images/icons/icon-144x144.png",
		"sizes": "144x144",
		"type": "image/png"
	  },
	  {
		"src": "images/icons/icon-152x152.png",
		"sizes": "152x152",
		"type": "image/png"
	  },
	  {
		"src": "images/icons/icon-192x192.png",
		"sizes": "192x192",
		"type": "image/png"
	  },
	  {
		"src": "images/icons/icon-384x384.png",
		"sizes": "384x384",
		"type": "image/png"
	  },
	  {
		"src": "images/icons/icon-512x512.png",
		"sizes": "512x512",
		"type": "image/png"
	  }
	],
	"splash_pages": null
  }');
  ?>