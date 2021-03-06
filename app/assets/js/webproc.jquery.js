
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
	user: {
		register: function(event, form)
		{
			var check = wp.formdata.checkForm(form)
			if( check.result == 'error' )
			{
				wp.formdata.addAlert('#wp-formlog', '<p class="wp-'+check.result+'" >'+check.desc+'</p>')
			} 

			if( check.result == 'success' ) {
				wp.formdata.addAlert('#wp-formlog', '<p class="wp-'+check.result+'" >'+check.desc+'</p>')
				var args = {
					email: jQuery('.email').val(),
					password: jQuery('.password').val()
				}
				jQuery.ajax({
					type: 'POST',
					url: base_url + 'user/registerUser',
					data: args,
					success: function(response){
						var r = jQuery.parseJSON(response)
						wp.console(r);
						if( r.result != 0 )
						{
							
						}
					}
				})
			}
		}
	},
	formdata: {
		checkForm: function(form)
		{
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
										desc:"Los datos son correctos" 
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
			if(jQuery(form + ' .password').val() != jQuery(form + ' .cpassword').val()){
				jQuery(form + ' .cpassword').css('border', 'solid 2px #e74c3c');
				result = false;
			}
			else
		  	{
		  		jQuery(form + ' .cpassword').css('border', 'solid 2px #2ecc71');
		  	}
			return result;
		}
	}
}
wp.console('Debug Mode: ' + wp.debugMode);