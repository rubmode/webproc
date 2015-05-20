
/**
*
*	CFDI javascript methods plugin
*	Using jQuery
*	@author: Rubén López <ruben@w3are.mx>
*	
*/

var cfdi = {
	debugMode: true,
	console: function(msg) {
		if( this.debugMode ) 
		{ 
			console.log(msg) 
		}
	},
	user: {
		loadContent: function(section, loader)
		{
	        cfdi.console(section);

	        jQuery(loader).prepend('<div class="loader"></div>');
	        jQuery.ajax({
	        	url: base_url + 'app/' + section,
	        	type: 'GET',
	        	success: function(data){
		        	
		        	cfdi.console(data);
		        	
		        	setTimeout(function(){
		        		jQuery('#cfdi-content').html(data);
		        		window.history.pushState('', 'Title', section);
		        		jQuery(loader).removeClass('loader');
		        	}, 300);
	        	
	        	}
	        });
		},
		setMetadata: function(form, action)
		{
			jQuery(form + ' input').css('border', 'solid 1px #ccc');
			var checked = cfdi.fields.checkLength(form);
		 	if( !checked )
		 	{
		 		cfdi.console('Faltan campos por llenar.');
		 		cfdi.alert.show('error', 'Faltan campos por llenar.');
		 	}
		 	else
		 	{
		 		if( !cfdi.fields.checkRFC(form) )
		 		{
		 			cfdi.console('El RFC debe tener al menos 13 caracteres.');
		 			cfdi.alert.show('error', 'El RFC debe tener al menos 13 caracteres.');
		 		}
		 		else
		 		{
		 			if( !cfdi.fields.checkInteger(form) )
		 			{
		 				cfdi.console('Los campor en rojo deberían ser números enteros.');
		 				cfdi.alert.show('error', 'Los campor en rojo deberían ser números enteros.');
		 			}
		 			else
		 			{
		 				try
						{
							var formData = {
								type		: action,
								nombre		: jQuery(form + ' #nombre').val(),
								rfc 		: jQuery(form + ' #rfc').val(),
								regimen 	: jQuery(form + ' #regimen').val(),
								calle 		: jQuery(form + ' #calle').val(),
								exterior 	: jQuery(form + ' #exterior').val(),
								interior 	: jQuery(form + ' #interior').val(),
								cp 			: jQuery(form + ' #cp').val(),
								colonia 	: jQuery(form + ' #colonia').val(),
								localidad 	: jQuery(form + ' #localidad').val(),
								municipio 	: jQuery(form + ' #municipio').val(),
								estado 		: jQuery(form + ' #estado').val(),
								pais		: jQuery(form + ' #pais').val()
							};

							var msg = '<p class="">Guardando datos</p>'

							cfdi.alert.show('success', msg);

							jQuery.ajax({
								type: 'POST',
								url: base_url + 'app/sendMetadata',
								data: formData,
								success: function(data)
								{
									var r = jQuery.parseJSON(data);
									cfdi.console(r);

									if( r.result == 'success' ) 
									{
										msg = 'Tus datos se guardarón con exito'
										cfdi.alert.show('success', msg, true);
									}
									else
									{
										msg = 'Tus datos no se guardarón, intentalo de nuevo'
										cfdi.alert.show('error', msg, true);
									}
								}
							});
						}
						catch(e)
						{
							console.log(e);
						}
		 			}
		 		}
		 	}
		}
	},
	fields: {
		getLocationData: function(event, form)
		{
			jQuery(form + ' #localidad').val('');
			jQuery(form + ' #municipio').val('');
			jQuery(form + ' #estado').val('');
			jQuery(form + ' #colonia').html('<option value=""> -- Selecciona -- </option>');
			
			if( event.target.value.length > 3 )
			{
				try
				{
					jQuery.ajax({
						type: 'GET',
						url: base_url + 'app/getLocationData',
						data: { 
							cp: event.target.value
						},
						success: function(data)
						{
							cfdi.console(data);
							var r = jQuery.parseJSON(data);
							cfdi.console(r);

							jQuery(form + ' #localidad').val(r[0].d_mnpio);
							jQuery(form + ' #municipio').val(r[0].d_mnpio);
							jQuery(form + ' #estado').val(r[0].d_estado);

							count = 0;
							for(property in r)
							{
								jQuery(form + ' #colonia').append('<option val="' + r[count].d_asenta + '">' + r[count].d_asenta + '</option>');
								count++;
							}
						}
					});
				}
				catch(e)
				{
					console.log(e);
				}
			}
			
		},
		checkLength: function(form)
		{	
			var result = true;
			jQuery(form + ' .required').each(function() {
			  	if( jQuery(this).val().length == 0 )
			  	{	
			  		jQuery(this).css('border', 'solid 1px red');
			  		result = false;
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
					jQuery(this).css('border', 'solid 1px red');
					result = false;
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
						jQuery(this).css('border', 'solid 1px red');
						result = false;
					}
				}
			});
			return result;
		},
		checkEmail: function(email)
		{
			var result = true;
			if(!/^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+){1,2}$/.test(valor)){
				result = false;
			}
			return result;
		}
	},
	alert: {
		show : function(type, msg, close)
		{
			jQuery('#MCONTAINER>.MC>.box').html(msg);
			if( !close )
			{
				jQuery('#MCONTAINER>.MC>.box').append('<br/><p onclick="cfdi.alert.hide();" class="pointer lead">Aceptar</p>');
			}
			jQuery('#MCONTAINER>.MC>.box').addClass(type);			
	 		jQuery('.MODAL').fadeIn(300);
	 		if( close ) {
	 			setTimeout(function(){
	 				cfdi.alert.hide();
	 			}, 2000);
	 		}
		},
		warning: function(msg, callback)
		{
			jQuery('#MCONTAINER>.MC>.box').html(msg);
			jQuery('#MCONTAINER>.MC>.box').append('<br/><p class="btns"><strong onclick="cfdi.alert.hide();" class="pointer lead">Cancelar</strong><strong id="continue" class="pointer lead">Aceptar</strong></p>');
			jQuery('#MCONTAINER>.MC>.box').addClass('warning');			
	 		jQuery('.MODAL').fadeIn(300);
	 		
	 		jQuery('#continue').on('click', function(){
	 			callback();
	 		});

		},
		hide: function()
		{			
	 		jQuery('.MODAL').fadeOut(300, function(){
	 			jQuery('#MCONTAINER>.MC').html();
	 			jQuery('#MCONTAINER>.MC>.box').removeClass('success');	
	 			jQuery('#MCONTAINER>.MC>.box').removeClass('error');	
	 		});
		}
	},
	dropbox: {
		login: function()
		{
			document.location.href = base_url+'app/login/dropbox'; 
		},
		createSession: function(code)
		{
			var url = document.location.hash;
			try
			{
				jQuery.ajax({
					type: 'POST',
					url: base_url + 'app/getDropboxToken',
					data: { 
						code: code 
					},
					success: function(data)
					{
						cfdi.console('Data: '+data);
						var r = jQuery.parseJSON(data);
						cfdi.console(r.access_token);
						jQuery.ajax({
							type: 'POST',
							url: base_url + 'app/createSession',
							data: { access_token: r.access_token, type: r.type, uid: r.uid },
							success: function(data)
							{
								cfdi.console('Hey: '+data);
								var c = jQuery.parseJSON(data);
								if ( c.response == 'success' )
								{
									jQuery('#coverTitle').html('<h1 class="cover-heading">Tu sesión se creo con exito, te llevaremos a tu panel administrativo.</h1>');
									setTimeout(function(){
										document.location.href = base_url + 'app';
									}, 1000)
								}
							}
						});
					}
				});
			}
			catch(e)
			{
				console.log(e);
			}
		},
		uploadKey: function()
		{
			event.preventDefault();

			var form = document.getElementById('file-form');
			var key = document.getElementById('fileKey');
			var uploadButton = document.getElementById('upload');

			uploadButton.innerHTML = 'Subiendo';

			var formData = new FormData();
		  	var patt = /^.*\.(key)$/;
			
			if( key.value != '' )
			{
				if( patt.test(key.files[0].name)) 
				{
					formData.append('fielKey', key.files[0]);
					
					var xhr = new XMLHttpRequest();
					xhr.open('POST', base_url + 'app/uploadFIEL', true);
					xhr.onload = function () 
					{
					  	if (xhr.status === 200) 
					  	{
					  		msg = '<p class="success">Subida exitosa</p>'
							cfdi.alert.show('success', msg, true);
						    
						    cfdi.user.loadContent('fiel','#cfdi-content');
					  	} 
					  	else 
					  	{
						    cfdi.alert.show('error', 'Tu archivo .key no se subió por problemas con la red.');
					  	}
					};

					xhr.send(formData);
				} 
				else 
				{
					cfdi.alert.show('error', 'Éste archivo no es el correcto.');
				}
			}
			else
			{
				cfdi.alert.show('error', 'No elegiste ningún archivo .key');
			}
		},
		uploadCer: function()
		{
			event.preventDefault();

			var form = document.getElementById('file-form');
			var cer = document.getElementById('fileCer');
			var uploadButton = document.getElementById('upload');

			uploadButton.innerHTML = 'Subiendo';

			var formData = new FormData();
		  	var patt = /^.*\.(cer)$/;
			
			if( cer.value != '' )
			{
				if( patt.test(cer.files[0].name)) 
				{
					formData.append('fielCer', cer.files[0]);
					
					var xhr = new XMLHttpRequest();
					xhr.open('POST', base_url + 'app/uploadFIEL', true);
					xhr.onload = function (data) 
					{
						cfdi.console(data);
					  	if (xhr.status === 200) 
					  	{
					  		msg = '<p class="success">Subida exitosa</p>'
							cfdi.alert.show('success', msg, true);
						    
						    cfdi.user.loadContent('fiel','#cfdi-content');
					  	} 
					  	else 
					  	{
						    cfdi.alert.show('error', 'Tu archivo .cer no se subió por problemas con la red.');
					  	}
					};

					xhr.send(formData);
				} 
				else 
				{
					cfdi.alert.show('error', 'Éste archivo no es el correcto.');
				}
			}
			else
			{
				cfdi.alert.show('error', 'No elegiste ningún archivo .cer.');
			}
		},
		deleteFielFile: function(file)
		{
			cfdi.console(file);
			msg = '<p class="warning">¿Estás seguro de eliminar este archivo?</p>';
			cfdi.alert.warning(msg, function(data){
				cfdi.console(data);
				try
				{
					jQuery.ajax({
						type: 'POST',
						url: base_url + 'app/deleteFIEL',
						data: { 
							file: file
						},
						success: function(data)
						{
							cfdi.console(data);
							var r = jQuery.parseJSON(data);
							cfdi.console(r);
							if( r.is_deleted )
							{
								msg = '<p class="success">El archivo se eliminó</p>'
								cfdi.alert.show('success', msg, true);

							    cfdi.user.loadContent('fiel','#cfdi-content');
							}
						}
					});
				}
				catch(e)
				{
					console.log(e);
				}
			});
		},
		checkFIEL: function()
		{
			try
			{
				jQuery.ajax({
					type: 'GET',
					url: base_url + 'dropbox/fileMetadata',
					data: { 
						path: 'FIEL'
					},
					success: function(data)
					{
						cfdi.console(data);
					}
				});
			}
			catch(e)
			{
				console.log(e);
			}
		}
	},
	google: {

	}

}
cfdi.console('Debug Mode: ' + cfdi.debugMode);