<form action="{base_url}angocr/index" method="post" accept-charset="utf-8" name="login" class="form login-form">
    <h5 class="text-center"><strong>Bitte geben Sie Ihre E-Mail-Adresse <br>und lhr Passwort ein</strong></h5>
	<br>
    <div class="input-group"> <span class="input-group-addon"><i class="fa fa-envelope" aria-hidden="true"></i></span>
        <input class="form-control" placeholder="E-mail Addresse" type="text" name="benutzername" value="" class="text benutzername"> </div>
    <br>
    <div class="input-group" id="passW"> <span class="input-group-addon"><i class="fa fa-lock" style="font-size:20px;" aria-hidden="true"></i></span>
        <input class="form-control" placeholder="Passwort" type="password" name="passwort" value="" class="text passwort"> 
	</div>
	<div id="forgotPass"><a href="{base_url}lgi/receive_password" class="pull-left">Passwort vergessen?</a></div>
	<div>{form:errors}</div>
	<div>{login:errors}</div>
	<div id="loginSubmit"><button class="btn btn-block" name="send" type="submit">EINLOGGEN</button></div>
	<h4 class="text-center"><strong>Neu bei Eridian? <a href="{base_url}reg/index">Jetzt eigenen Account erstellen!</a></strong></h4>
</form>




