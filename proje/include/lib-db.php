<?

$totalQry = 0;
$totalQryStr = '';
$microtime = microtime(true);
$ver = (float) phpversion();



if ($ver >= 7.0 && (!isset($connection_type) || $connection_type == 'mysql' || !function_exists('mysql_query'))) {
	$connection_type = 'mysqli';
	/*
	function ignore_exceptions_handler($exception) {
		// Do nothing here
	 }
	 
	 set_exception_handler('ignore_exceptions_handler');
	 */
}

if (!function_exists('mysql_query')) {
	if (!function_exists('ereg')) {
		function ereg($pattern, $subject, &$matches = [])
		{
			return preg_match('/' . $pattern . '/', $subject, $matches);
		}
	}
	if (!function_exists('eregi')) {
		function eregi($pattern, $subject, &$matches = [])
		{
			return preg_match('/' . $pattern . '/i', $subject, $matches);
		}
	}
	if (!function_exists('ereg_replace')) {
		function ereg_replace($pattern, $replacement, $string)
		{
			return preg_replace('/' . $pattern . '/', $replacement, $string);
		}
	}
	if (!function_exists('eregi_replace')) {
		function eregi_replace($pattern, $replacement, $string)
		{
			return preg_replace('/' . $pattern . '/i', $replacement, $string);
		}
	}
	if (!function_exists('split')) {
		function split($pattern, $subject, $limit = -1)
		{
			return preg_split('/' . $pattern . '/', $subject, $limit);
		}
	}
	if (!function_exists('spliti')) {
		function spliti($pattern, $subject, $limit = -1)
		{
			return preg_split('/' . $pattern . '/i', $subject, $limit);
		}
	}

	function mysql_connect($server, $username, $password, $dbname = null)
	{
		return my_mysql_connect($server, $username, $password, $dbname);
	}
	function mysql_select_db($x, $y)
	{
		return my_mysql_select_db($x, $y);
	}
	function mysql_query($qry)
	{
		return my_mysql_query($qry);
	}
	function mysql_fetch_array($x)
	{
		return my_mysql_fetch_array($x);
	}
	function mysql_fetch_query($x)
	{
		return my_mysql_fetch_array($x);
	}
	function mysql_num_fields($x)
	{
		return my_mysql_num_fields($x);
	}
	function mysql_num_rows($x)
	{
		return my_mysql_num_rows($x);
	}
	function mysql_fetch_assoc($x)
	{
		return my_mysql_fetch_assoc($x);
	}
	function mysql_real_escape_string($x)
	{
		return my_mysql_real_escape_string($x);
	}
	function mysql_insert_id()
	{
		return my_mysql_insert_id();
	}
	function mysql_affected_rows()
	{
		return my_mysql_affected_rows();
	}
	function mysql_close()
	{
		return my_mysql_close();
	}
	function mysql_error()
	{
		return 'Mysql Bağlantı Hatası.';
	}
}

function my_mysql_query($qry, $showError = false)
{
	if (function_exists('my_mysql_queryx'))
		return my_mysql_queryx($qry);
	global $showSPError, $baglanti, $connection_type, $debugBackTrace;
	if (!$showSPError && !$showError) {
		switch ($connection_type) {
			case 'mysqli':
				$out = mysqli_query($baglanti, $qry);
				if (!$debugBackTrace)
					return $out;
				break;
			default:
				$out =  mysql_query($qry);
				if (!$debugBackTrace)
					return $out;
				break;
		}
	}

	global $totalQry, $totalQryStr;

	if ($debugBackTrace)
		$msc = microtime(true);
	switch ($connection_type) {
		case 'mysqli':
			if ($showSPError || $showError)
				$out = mysqli_query($baglanti, $qry) or die('Query : ' . $qry . '<br />' . mysqli_error($baglanti));
			break;
		default:
			if ($showSPError || $showError)
				$out = mysql_query($qry) or die('Query : ' . $qry . '<br />' . mysql_error());
			break;
	}

	if ($debugBackTrace) {
		$callers = debug_backtrace();
		$msc = microtime(true) - $msc;
		if (stristr($qry, 'result from cache') === false) {
			$totalQry++;
			$totalQryStr .= $msc . ':' . $qry . ' : ' . $callers[1]['function'] . ' : ' . $callers[2]['function'].'<br>';
		}
	}
	return $out;
}

function my_mysqli_query($qry)
{
	return my_mysql_query($qry);
}

$my_db_name = '';
$my_db_username = '';
$my_db_password = '';
$my_db_server = '';

function my_mysql_connect($server, $username, $password, $dbname = null)
{
	global $connection_type, $baglanti;
	if ((float) phpversion() >= 7.0 && (!isset($connection_type) || $connection_type == 'mysql')) {
		$connection_type = 'mysqli';
	}

	switch ($connection_type) {
		case 'mysqli':
			global $my_db_name, $my_db_username, $my_db_password, $my_db_server;
			$my_db_name = @$dbname;
			$my_db_username = $username;
			$my_db_password = $password;
			$my_db_server = $server;
			break;
		default:
			$baglanti = @mysql_connect($server, $username, $password) or die(mysql_error());
			return $baglanti;
			break;
	}
}

function my_mysql_select_db($dbname, $baglanti)
{
	global $connection_type, $baglanti;
	switch ($connection_type) {
		case 'mysqli':
			global $my_db_name, $my_db_username, $my_db_password, $my_db_server;
			if (!$my_db_name)
				$my_db_name = $dbname;
			$baglanti = mysqli_connect($my_db_server, $my_db_username, $my_db_password, $my_db_name) or die(mysqli_connect_error());
			break;
		default:
			@mysql_select_db($dbname, $baglanti) or die(mysql_error());
			break;
	}
}

function my_mysql_fetch_row($r)
{
	global $connection_type, $baglanti;
	switch ($connection_type) {
		case 'mysqli':
			return mysqli_fetch_row($r);
			break;
		default:
			return mysql_fetch_row($r);
			break;
	}
}

function my_mysql_fetch_array($r)
{
	global $connection_type, $baglanti;
	switch ($connection_type) {
		case 'mysqli':
			return mysqli_fetch_array($r);
			break;
		default:
			return mysql_fetch_array($r);
			break;
	}
}



function my_mysql_num_fields($r)
{
	global $connection_type, $baglanti;
	switch ($connection_type) {
		case 'mysqli':
			return mysqli_num_fields($r);
			break;
		default:
			return mysql_num_fields($r);
			break;
	}
}


function my_mysql_fetch_assoc($r)
{
	global $connection_type, $baglanti;
	switch ($connection_type) {
		case 'mysqli':
			return mysqli_fetch_assoc($r);
			break;
		default:
			return mysql_fetch_assoc($r);
			break;
	}
}


function my_mysql_num_rows($r)
{
	global $connection_type, $baglanti;
	switch ($connection_type) {
		case 'mysqli':
			return mysqli_num_rows($r);
			break;
		default:
			return mysql_num_rows($r);
			break;
	}
}

function my_mysql_insert_id()
{
	global $connection_type, $baglanti;
	switch ($connection_type) {
		case 'mysqli':
			return mysqli_insert_id($baglanti);
			break;
		default:
			return mysql_insert_id();
			break;
	}
}

function my_mysql_affected_rows()
{
	global $connection_type, $baglanti;
	switch ($connection_type) {
		case 'mysqli':
			return mysqli_affected_rows($baglanti);
			break;
		default:
			return mysql_affected_rows();
			break;
	}
}



function my_mysql_real_escape_string($r)
{
	global $connection_type, $baglanti;
	switch ($connection_type) {
		case 'mysqli':
			return mysqli_real_escape_string($baglanti, $r);
			break;
		default:
			return mysql_real_escape_string($r);
			break;
	}
}

function my_mysql_close()
{
	global $connection_type, $baglanti;
	switch ($connection_type) {
		case 'mysqli':
			return mysqli_close($baglanti);
			break;
		default:
			return @mysql_close($baglanti);
			break;
	}
}

if (function_exists('finfo_open')) {
	foreach ($_FILES as $k => $v) {
		if (!$v['tmp_name'] || is_array($v['tmp_name']))
			continue;
		if (!(stristr(file_get_contents($v['tmp_name']), 'GIF89') === false)) {

			unset($_FILES[$k]);
		}
		$info = getimagesize($v['tmp_name']);
		if ($info === false) {
			$finfo = finfo_open(FILEINFO_MIME_TYPE);
			$mime = finfo_file($finfo, $v['TMP_NAME']);
			switch ($mime) {
				case 'image/jpeg':
				case 'image/jpg':
				case 'image/png':
				case 'image/all':
				case 'application/pdf':
				case 'application/msword':
				case 'application/zip':
				case 'application/x-compressed-zip':
				case 'application/xml':
					break;
				default:
					if ($mime && stristr($mime, 'excel') === false && stristr($mime, 'xls') === false && (stristr($mime, 'image/') === false || !(stristr($mime, 'gif') === false)))
						unset($_FILES[$k]);
					break;
			}
		}
	}

	foreach ($_FILES as $k => $v) {
		if (!is_array($v['name']))
			continue;
		$dosya_sayi = count($v['name']);
		for ($i = 0; $i < $dosya_sayi; $i++) {
			if (!$v['tmp_name'][$i] || !(stristr(file_get_contents($v['tmp_name'][$i]), 'GIF89') === false)) {
				unset($_FILES[$k]['temp_name'][$i]);
			}
			$info = getimagesize($v['tmp_name'][$i]);
			if ($info === false) {
				$finfo = finfo_open(FILEINFO_MIME_TYPE);
				$mime = finfo_file($finfo, $v['tmp_name'][$i]);
				switch ($mime) {
					case 'image/jpeg':
					case 'image/jpg':
					case 'image/png':
					case 'image/all':
					case 'application/pdf':
					case 'application/msword':
					case 'application/zip':
					case 'application/x-compressed-zip':
					case 'application/xml':
						break;
					default:
						if ($mime && stristr($mime, 'excel') === false && stristr($mime, 'xls') === false && (stristr($mime, 'image/') === false || !(stristr($mime, 'gif') === false)))
							unset($_FILES[$k]);
						break;
				}
			}
		}
	}
}
