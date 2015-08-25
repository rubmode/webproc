<div id="wp-login" class="bg-login">
	<div class="wp-middle">
		<div class="wp-container">
			<div class="wp-content row">
				<div class="col-md-4 col-md-offset-4">
					<div class="login-form">
			            <div class="form-group">
			              	<input type="text" class="form-control login-field required email" value="" placeholder="e-mail" id="login-name">
			              	<label class="login-field-icon fui-user" for="login-name"></label>
			            </div>

			            <div class="form-group">
			              	<input type="password" class="form-control login-field required password" value="" placeholder="Contraseña" id="login-pass">
			              	<label class="login-field-icon fui-lock" for="login-pass"></label>
			            </div>
			            <div id="wp-formlog-app"></div>
			            <div id="wp-formlog-api"></div>
			           	<button type="enviar" onclick="wp.user.login(event,'#wp-login');" class="btn btn-default">Enviar</button>
			            <div class="form-group">
              				<label class="checkbox" for="checkbox100">
                				<input type="checkbox" data-toggle="radio" value="" id="checkbox100" required>
                				Mantenerme conectado
              				</label>
            			</div>
			            <a class="login-link" href="#">Recuperar mi contraseña?</a>
			            <a class="login-link" href="register">Registrarme</a>
		          	</div>
				</div>
			</div>
		</div>
	</div>
</div>