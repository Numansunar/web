<?
error_reporting('~E_NOTICE & ~E_DEPRICATED % E_ALL'); 
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<title>Giriş Popup</title>
	
	<link rel="stylesheet" type="text/css" href="css/style.css" media="screen" />
	<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
</head>
<body>

	<div id="loginBox">
		<h2>ÜYELİK İŞLEMLERİ</h2>
		<div class="lbLeft">
			<h4>Üye olmak istiyorum!</h4>
			<div class="regForm">
				<form action="#" method="GET">
					<div class="formElem">
						<label for="mail">E-Posta</label>
						<input type="text" name="mail" id="email" class="inputText" />
					</div>
					<div class="formElemSmall">
						<label for="pass">Şifre</label>
						<input type="password" name="pass" id="pass" class="inputTextSmall" />
					</div>
					<div class="formElemSmall last">
						<label for="pass2">Şifre Tekrar</label>
						<input type="password" name="pass2" id="pass2" class="inputTextSmall" />
					</div>
					<div class="formElem">
						<label for="name">Ad</label>
						<input type="text" name="name" id="name" class="inputText" />
					</div>
					<div class="formElem">
						<label for="surname">Soyad</label>
						<input type="text" name="surname" id="surname" class="inputText" />
					</div>
					<div class="formElem">
						<label for="sex">Cinsiyet</label>
						<select class="selectBox" name="sex" id="sex">
							<option value="0">Seçiniz</option>
							<option value="1">Erkek</option>
							<option value="2">Kadın</option>
						</select>
					</div>
					<div class="formElem">
						<input type="checkbox" id="remember2" /><a href="#" class="agree">Üyelik Sözleşmesini Okudum. Kabul Ediyorum. </a>
					</div>
					<div class="formElem">
						<input type="button" class="regBtn" value="" style="cursor:pointer;" />
					</div>
					<p class="warn">Lütfen tüm alanları doldurunuz.</p>
				</form>
			</div><!-- /.loginForm -->
		</div><!-- /.lbLeft -->
		<div class="lbRight">
			<h4>Üye Girişi</h4>
			<div class="loginForm">
				<form  method="POST">
					<div class="formElem">
						<label for="mail">E-Posta</label>
						<input type="text" name="username" id="l_username"  class="inputText" value="<?=($_COOKIE['u']?$_COOKIE['u']:'')?>" />
					</div>
					<div class="formElem">
						<label for="mail">Şifreniz</label>
						<input type="password" name="password" id="l_password"  class="inputText" />
					</div>
					<div class="formElem">
						<div class="check"><input type="checkbox" id="remember" value="true" /> <label for="remember">Beni Hatırla</label></div>
						<a href="#" onclick="window.top.location = '../../../page.php?act=sifre';">Şifremi Unuttum</a>
					</div>
					<div class="formElem">
						<input type="button" class="loginBtn" style="cursor:pointer;" value="" />
					</div>
					
				</form>
			</div>
			<div class="campaign">
				<img src="images/campaign.png" alt="Kampanya" />
			</div>
		</div><!-- /.lbRight -->
	</div><!-- /#loginBox -->
    <script>
		function quickCheckUser()
		{
			if (!$('#l_username').val() || !$('#l_password').val())
			{
				alert('Lütfen bilgileri eksiksiz girin.');
				return false;	
			}			
			var url = '../../../include/ajaxLib.php?act=quickCheckUser&username=' + $('#l_username').val() + '&password=' + $('#l_password').val() + '&remember=' + $('#remember').val();
			//window.open(url);
			$.get(url, function(data) {
				data = data.replace(/^\s+|\s+$/g,"");
			//	alert(data); return;
				if (data)
				{
					window.top.location.reload(true);
				}
				else alert('Hatalı kullanıcı adı veya şifre.');
			});		
		}
		function quickRegister()
		{
			if (!$('#email').val() || !$('#pass').val() || !$('#name').val() || !$('#surname').val() || !$('#sex').val() || !$('#pass2').val())
			{
				alert('Lütfen bilgileri eksiksiz girin.');
				return false;	
			}
			if ($('#pass').val().length < 5)
			{
				alert('Şifreniz 5 karakterden kısa olamaz.');
				return false;				
			}
			if ($('#pass').val() != $('#pass2').val())
			{
				alert('Hatalı şifre tekrarı.');
				return false;					
			}
			var url = '../../../include/ajaxLib.php?act=quickRegister&email=' + $('#email').val() + '&username=' + $('#email').val() + '&pass=' + $('#pass').val() + '&name=' + $('#name').val() +  '&lastname=' + $('#surname').val() +  '&sex=' + $('#sex').val();
			//window.open(url);
			$.get(url, function(data) {
				data = data.replace(/^\s+|\s+$/g,"");
				if (data == '00')
				{
					alert('Tebrikler. Üye kaydınız tamamlandı. Giriş yapabilirsiniz.');	
				}
				else if(data == 'ue')
				{
					alert('Kullanıcı adı daha önce tanımlanmış.');	
				}
				else if(data == 'us')
				{
					alert('Bir IP adresinden gün içerisinde 5 den fazla kayıt yapılamaz.');	
				}
				else alert(data);
			});		
		}
		$('.regBtn').click(function() { quickRegister(); return false; });
		$('.loginBtn').click(function() { quickCheckUser(); return false; });
	</script>
</body>
</html>
