<div id="wp-register" class="bg-register">
	<div class="wp-middle">
		<div class="wp-container">
			<div class="wp-content row">
				<div class="col-md-4 col-md-offset-4">
					<div class="login-form">
			            <legend>Registrarme</legend>
			            <div class="form-group">
			              	<label for="exampleInputEmail1">Correo eletrónico</label>
			              	<input type="email" class="form-control required email" id="exampleInputEmail1" placeholder="Enter email">
			            </div>
			            <div class="form-group">
			              	<label for="exampleInputPassword1">Contraseña</label>
			              	<input type="password" class="form-control required password" id="exampleInputPassword1" placeholder="Password">
			            </div>
			            <div class="form-group">
			              	<label for="exampleInputPassword1">Confirmar contraseña</label>
			              	<input type="password" class="form-control required cpassword" id="exampleInputPassword1" placeholder="Password">
			            </div>
			            <div id="wp-formlog-app"></div>
			            <div id="wp-formlog-api"></div>
			            <button type="enviar" onclick="wp.user.register(event,'#wp-register');" class="btn btn-default">Enviar</button>
		          	</div>
				</div>
			</div>
		</div>
	</div>
</div>