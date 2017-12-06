(function($) {
	// Ajusta el campo de folio para ocultarlo y mostrarlo en una etiqueta A TODOS LOS CAMPOS
	$(".id_catalog").attr("type","hidden");	
	if ($(".id_catalog").val()=='') {
		$(".id_catalog").parent().append('<label><h2>El folio se genera al guardar el registro.</h2></label>');
	} else {
		$(".id_catalog").parent().append('<label><div>'+$(".id_catalog").val()+'</div></label>');
	}

	//Agrega el titulo de Nombre Oficial solo a proyectos de inversiÃ³n

	if ($(".wrap h1").text().indexOf("Proyecto de")>0)
		$(".wrap h1").append('<p class="bmxtTitle"><label>Nombre Oficial</label></p>');	
	

		$(document).ready(function(){
			var selected = $('#acf-field-tipo_de_contacto_reg_inversionista').text().toLowerCase();
			if (selected) {
				$('#'+selected).removeClass("hide").addClass( "active" );
			    $('.tab-content #'+selected).removeClass("hide").addClass( "active" );
			}
			//select TAB
			$('#acf-field-tipo_de_contacto_reg_inversionista').change(function() {
				var selected = $('#acf-field-tipo_de_contacto_reg_inversionista  option:selected').text().toLowerCase();
			    //alert(selected);
			    if (selected == 'consultor' || selected == 'otros') {
			    	$('#acf-field-web_reg_inversionista').removeAttr('data-validation');
			    }else {
			    	$('#acf-field-web_reg_inversionista').attr('data-validation', 'required');
			    }
			    
			});

		});

			
})(jQuery);