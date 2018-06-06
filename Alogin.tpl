<div id="document" class="modal-dialog parent" role="document">
	<div class="modal-content">
		<form action="{base_url}ocr/index" method="post" accept-charset="utf-8" name="login" class="form login-form">
			<div class="modal-header">
				<h5 class="modal-title">Athentication</h5>

			</div>

			<div class="modal-body">
				<div class="input-group mb-3">
					<div class="input-group-prepend">
						<span class="input-group-text">Email&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
					</div>
					<input class="form-control" placeholder="E-mail Addresse" type="text" name="benutzername" value="" class="text benutzername">

				</div>
				<div class="input-group mb-3">
					<div class="input-group-prepend">
						<span class="input-group-text">Password</span>
					</div>
					<input class="form-control" placeholder="Passwort" type="password" name="passwort" value="" class="text passwort">

				</div>
			</div>

			<div class="modal-footer">
				<div id="loginSubmit">
					<button class="btn btn-block" name="send" type="submit">EINLOGGEN</button>
				</div>
			</div>
		</form>
	</div>
</div>