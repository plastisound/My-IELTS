(function($){
	$(function(){
		
		// Validación para registro de inversionistas
		var sector_seleccionado = false;
		$(document).on('acf/validate_field', function (e,el) {

			var sectores = ['acf-electricidad_reg_inversionista',
							'acf-electricidad_sub_reg_inversionista',
							'acf-hidrocarburos_reg_inversionista',
							'acf-hidrocarburos_sub-sectores',
							'acf-transporte_reg_inversionista',
							'acf-transporte_sub-sectores',
							'acf-infraestructura_social_reg_inversionista',
							'acf-agua_y_medio_ambiente_reg_inversionista',
							'acf-industria_reg_inversionista',
							'acf-mineria_reg_inversionista',
							'acf-inmobiliario_y_turismo_reg_inversionista',
							'acf-telecomunicaciones_reg_inversionista'];

			//if ($('#post_type').val() == 'reg_inversionistas') {
			var alrt = $('#post_type').val();
			
			if (alrt == 'reg_inversionistas') {	
				//alert(alrt);
				if ($(el).attr('id') == 'acf-electricidad_reg_inversionista') {
					$fields = $('.field.required, .form-field.required');
					for (i=1; i<$fields.length; i++){
					
						if (sectores.indexOf($($fields[i]).attr('id'))>-1){
							if ($($fields[i]).find('input[type="checkbox"]:checked').exists() ||
								$($fields[i]).val() != "") {
								sector_seleccionado = true;
								$(el).data('validation',true);
							}

						}
	
					}
				} else {
					if (sectores.indexOf($(el).attr('id'))>-1)
						$(el).data('validation',sector_seleccionado);
				}
			}
		});

	
		
	});
       
})(jQuery);