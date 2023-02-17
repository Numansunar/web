<?
if (file_exists('include/mod_FacebookConnect.php')) require_once('include/mod_FacebookConnect.php');
if (file_exists('mod_FacebookConnect.php')) require_once('mod_FacebookConnect.php');
if (file_exists('include/mod_GoogleConnect.php')) require_once('include/mod_GoogleConnect.php');
if (file_exists('mod_GoogleConnect.php')) require_once('mod_GoogleConnect.php');

//exit(debugArray($_POST));
	
$loginOut='
<link href="css/login.css" rel="stylesheet" type="text/css" />
<div class="loginWrapper">	
    <div class="l-left"> 
		<div class="l-innerDiv">   
			<div class="loginBaslik"> '._lang_girisYap.'</div>
            <form id="form1" name="form1" method="post" action="">
            <div class="label">'._lang_epostaAdresiniz.'</div>
            <input name="username" type="text" class="sp-login-user sp-login-input" />
            <div class="label">'._lang_sifreniz.'</div>
            <input name="password" type="password" class="sp-login-pass sp-login-input" /><br /><br />
            <input name="hatirla" type="checkbox" class="sp-login-pass sp-login-input" value="true" id="hatirla" /> <label for="hatirla">'._lang_beniHatirla.'</a><br />
            <div class="clear-space"></div>
            <div class="sp-login-sumbit">
                <div>
                    <input type="submit" class="sf-button sf-button-large sf-negative-button" value="'.(_lang_girisYap).'"/>
                    <div class="sifreUnuttum"><a href="'.slink('sifre').'">'._lang_sifremiUnuttum.'</a></div> 
                </div>
            </div>
            </form>
            <div class="l-info">'.$login_message.'</div>
            <div class="sp-login-social">								
                <div>
                    '.$facebookConnectLogin.'
                </div>
                <div>
                    '.$googleConnectLogin.'
                </div>
            </div>		   
		</div>
	</div>
	<div class="l-right">    
		<div class="l-innerDiv">
			<div class="loginBaslik kayitBaslik">'._lang_kayitBaslik.'</div>
			<div class="kayitaciklama">'._lang_kayitAciklama.'</div>
				<ul>
					<li> <strong>&middot;</strong> '._lang_kayitInfo_1.'  </li>
					<li> <strong>&middot;</strong> '._lang_kayitInfo_2.'  </li>
					<li> <strong>&middot;</strong> '._lang_kayitInfo_3.' </li>
					<li> <strong>&middot;</strong> '._lang_kayitInfo_4.'  </li>
					<li> <strong>&middot;</strong> '._lang_kayitInfo_5.'  </li>
				</ul>
			<div class="kayit"><input type="button" onclick="window.location.href=\''.slink('register').'\'" class="sf-button sf-button-large sf-primary-button" value="'.(_lang_kayitUcretsizKayit).'"/></div>
		</div>
	</div>
	<div class="clear"></div>
</div>
';
return $loginOut;
?>