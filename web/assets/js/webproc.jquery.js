
/**
*
*	CFDI javascript methods plugin
*	Using jQuery
*	@author: Rubén López <ruben@w3are.mx>
*	
*/

var wp = {
	debugMode: true,
	console: function(msg) 
	{
		if( this.debugMode ) 
		{ 
			console.log(msg) 
		}
	},
	cookies: {
		getCookie: function(cname) 
		{
		    var name = cname + '=';
		    var ca = document.cookie.split(';');
		    for(var i=0; i<ca.length; i++) {
		        var c = ca[i];
		        while (c.charAt(0)==' ') c = c.substring(1);
		        if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
		    }
		    return "";
		},
		setCookie: function(cname, cvalue, exdays) {
		    var d = new Date();
		    d.setTime(d.getTime() + (exdays*24*60*60*1000));
		    var expires = 'expires='+d.toUTCString();
		    document.cookie = cname + '=' + cvalue + ';' + expires + ';path=/;';
		}
	},
	user: {
		register: function(event, form)
		{
			var check = wp.formdata.checkForm(form)
			wp.console('AppCookie: '+wp.cookies.getCookie('app_key'))
			if( check.result == 'error' )
			{
				wp.formdata.addAlert('#wp-formlog-app', '<p class="wp-'+check.result+'" >'+check.desc+'</p>')
			} 
			if( check.result == 'success' ) {
				wp.formdata.addAlert('#wp-formlog-app', '<p class="wp-'+check.result+'" >'+check.desc+'</p>')
				var args = {
					app_key: wp.cookies.getCookie('app_key'),
					email: jQuery('.email').val(),
					password: jQuery('.password').val()
				}
				jQuery.ajax({
					type: 'POST',
					url: api_url + 'user/addnew',
					data: args,
					success: function(response){
						var r = jQuery.parseJSON(response)
						wp.console(r);
						wp.formdata.addAlert('#wp-formlog-api', '<p class="wp-'+r.result+'" >'+r.desc+'</p>')
						if( r.result == 'success' )
						{
							wp.cookies.setCookie('auth_key',r.data.token,30)
							wp.cookies.setCookie('app_key','',-1)
							wp.console('AppCookie: '+wp.cookies.getCookie('app_key'))
							wp.console('AuthCookie: '+wp.cookies.getCookie('auth_key'))
						}
					}
				})
			}
		},
		login: function(event, form)
		{
			var check = wp.formdata.checkForm(form)
			if( check.result == 'error' )
			{
				wp.formdata.addAlert('#wp-formlog-app', '<p class="wp-'+check.result+'" >'+check.desc+'</p>')
			} 
			if( check.result == 'success' ) {
				wp.formdata.addAlert('#wp-formlog-app', '<p class="wp-'+check.result+'" >'+check.desc+'</p>')
				var args = {
					app_key: wp.cookies.getCookie('app_key'),
					email: jQuery('.email').val(),
					password: jQuery('.password').val()
				}
				jQuery.ajax({
					type: 'POST',
					url: api_url + 'user/login',
					data: args,
					success: function(response){
						var r = jQuery.parseJSON(response)
						wp.console(r);
						wp.formdata.addAlert('#wp-formlog-api', '<p class="wp-'+r.result+'" >'+r.desc+'</p>')
						if( r.result == 'success' )
						{
							wp.cookies.setCookie('app_key', '', -1)
							wp.cookies.setCookie('auth_key', r.data.token, 30)
							wp.console('AuthCookie: ' + wp.cookies.getCookie('auth_key'))
							wp.console('AppCookie: ' + wp.cookies.getCookie('app_key'))
						}
					}
				})
			}
		}
	},
	formdata: {
		checkForm: function(form)
		{
			wp.console(form)
			if( !wp.formdata.checkLength(form) )
			{
				return { 
					result:"error", 
					desc:"Faltan campos por llenar" 
				};
			} else {
				if( !wp.formdata.checkInteger(form) )
				{
					return { 
						result:"error", 
						desc:"Los campo en rojo deberían ser solo números" 
					};
				} else {
					if( !wp.formdata.checkRFC(form) )
					{
						return { 
							result:"error", 
							desc:"No es un RFC válido" 
						};
					} else {
						if( !wp.formdata.checkEmail(form) )
						{
							return { 
								result:"error", 
								desc:"No es un correo válido" 
							};
						} else {
							if( !wp.formdata.checkPassword(form) )
							{
								return { 
									result:"error", 
									desc:"Contraseña inválida, debe tener al menos 8 caracteres, letras y números" 
								};
							} else {
								if( !wp.formdata.confirmPassword(form) )
								{
									return { 
										result:"error", 
										desc:"La contraseñas no son iguales" 
									};
								} else {
									return { 
										result:"success", 
										desc:"Los datos que escribiste son válidos" 
									};
								}
							}
						}
					}
				}
			}
		},
		addAlert: function(element, data)
		{	
			jQuery(element).html(data)
		},
		checkLength: function(form)
		{	
			var result = true;
			jQuery(form + ' .required').each(function() {
			  	if( jQuery(this).val().length == 0 )
			  	{	
			  		jQuery(this).css('border', 'solid 2px #e74c3c');
			  		result = false;
			  	} 
			  	else
			  	{
			  		jQuery(this).css('border', 'solid 2px #2ecc71');
			  	}

			});
			return result;
		},
		checkRFC: function(form)
		{
			var result = true;
			jQuery(form + ' .rfc-data').each(function() 
			{
			  	if( jQuery(this).val().length != 13 )
				{
					jQuery(this).css('border', 'solid 2px #e74c3c');
					result = false;
				}
				else
			  	{
			  		jQuery(this).css('border', 'solid 2px #2ecc71');
			  	}
			});
			
			return result;
		},
		checkInteger: function(form)
		{
			var result = true;
			jQuery(form + ' .int-data').each(function() 
			{
			  	if( jQuery(this).val().length > 0 )
			  	{
				  	if(!/^[0-9]+$/.test(jQuery(this).val()))
					{
						jQuery(this).css('border', 'solid 2px #e74c3c');
						result = false;
					}
					else
			  	{
			  		jQuery(this).css('border', 'solid 2px #2ecc71');
			  	}
				}
			});
			return result;
		},
		checkEmail: function(form)
		{
			var result = true;
			jQuery(form + ' .email').each(function() 
			{
				if(!/^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+){1,2}$/.test(this.value)){
					jQuery(this).css('border', 'solid 2px #e74c3c');
					result = false;
				}
				else
			  	{
			  		jQuery(this).css('border', 'solid 2px #2ecc71');
			  	}
			});
			return result;
		},
		checkPassword: function(form)
		{
			var result = true;
			jQuery(form + ' .password').each(function() 
			{
				if(!/^(?=.*[0-9])[a-z0-9!@#$%^&*]{8,20}$/.test(this.value)){
					jQuery(this).css('border', 'solid 2px #e74c3c');
					result = false;
				}
				else
			  	{
			  		jQuery(this).css('border', 'solid 2px #2ecc71');
			  	}
			});
			return result;
		},
		confirmPassword: function(form)
		{
			var result = true;
			if(form.hasOwnProperty(',cpassword')){
				if(jQuery(form + ' .password').val() != jQuery(form + ' .cpassword').val()){
					jQuery(form + ' .cpassword').css('border', 'solid 2px #e74c3c');
					result = false;
				}
				else
			  	{
			  		jQuery(form + ' .cpassword').css('border', 'solid 2px #2ecc71');
			  	}
		  	}
			return result;
		}
	}
}
wp.console('Debug Mode: ' + wp.debugMode);