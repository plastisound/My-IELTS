<?php
	/////////////////////// ADMIN SECTION 
	/*
	*  users_iels_list_menu
	*
	*  Creates Admin Menu
	*  
	*/
	function users_iels_list_menu(){
        add_menu_page('IELS Page', 'IELS List', 'manage_options', 'iels-form-plugin','iels_form_page_init', 'dashicons-admin-users');
        	add_submenu_page( 'iels-form-plugin', 'Ciudades', 'Ciudades','manage_options', 'edit-tags.php?taxonomy=ciudad');
        	add_submenu_page( 'iels-form-plugin', 'Cursos', 'Cursos','manage_options', 'edit-tags.php?taxonomy=cursos');
	}

	/*
	*  menu_highlight
	*
	*  This function move the item taxonomy from Entries to Custom Menu
	*  
	*/
	function menu_highlight( $parent_file ) {
        global $current_screen;

        $taxonomy = $current_screen->taxonomy;
        if ( $taxonomy == 'ciudad' || $taxonomy == 'cursos' ) {
            $parent_file = 'iels-form-plugin';
        }

        return $parent_file;
    }
	 
	/*
	*  iels_form_page_init
	*
	*  Init for List of users Page
	*  
	*/
	function iels_form_page_init(){
	    include('list-mails.php');
	    if ( is_admin()) {
	    	wp_enqueue_script('jquery-ui-datepicker');
	    	//wp_enqueue_script( 'datatable-script-init-ui', 'http://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.0/jquery-ui.js', array( 'jquery' ), '1.0.0', true );

	    	//JQuery Datatable
        	wp_enqueue_script( 'datatable-script', plugin_dir_url( __FILE__ ).'../assets/DataTable/datatables.min.js', array( 'jquery' ), '1.0.0', true );
		    wp_enqueue_script( 'datatable-script-init', plugin_dir_url( __FILE__ ).'../assets/init-table.js', array( 'jquery' ), '1.0.0', true );
		    wp_enqueue_style('datatable-style', plugin_dir_url( __FILE__ ).'../assets/DataTable/datatables.min.css', array() );
		    wp_enqueue_style('datatable-style-new', plugin_dir_url( __FILE__ ).'../assets/table.css', array() );
		    
		    //custom style
		    wp_enqueue_style('custom-style-iels', plugin_dir_url( __FILE__ ).'../assets/css/custom.css', array() );

		    //Bootstrap
		    wp_enqueue_script( 'bancomext-bootstrap-js', plugin_dir_url( __FILE__ ). '../assets/bootstrap-3.3.7/js/bootstrap.min.js', array( 'jquery' ), '3.3.7', true );
		    wp_enqueue_style('bancomext-bootstrap', plugin_dir_url( __FILE__ ). '../assets/bootstrap-3.3.7/css/bootstrap.min.css');
		   
        }
	}

	/*
	*  Init_IELS_Form_Shortcode
	*
	*  Init the shortcode that creates the Form with styles
	*  
	*/
	function Iels_Styles() {
	    // Register the style for the form    

	        //custom style
		    wp_register_style('custom-style-iels', plugin_dir_url( __FILE__ ).'../assets/css/custom.css', array() );
		    
		    wp_register_script( 'post-contact-jquery', plugin_dir_url( __FILE__ ).'/js/post-contact-js.js', array( 'jquery' ));

		    wp_register_script( 'jquery-validate', plugin_dir_url( __FILE__ ).'/js/jquery.form-validator.min.js', array( 'jquery' ));
		     /*wp_localize_script( 'jquery-validate', 'id_query_ciudad', array(
				'ajax_url' => admin_url( 'admin-ajax.php')
			));*/

	    
	}
	// add_action('wp_ajax_id_query_ciudad', 'id_query_ciudad');
	// add_action('wp_ajax_nopriv_id_query_ciudad', 'id_query_ciudad');
	
	// function id_query_ciudad() {

	// 	$values= array();
	// 	$choices= array();
		
	// 	$child = get_term_children($_POST['parent_option'],'ciudad');
	// 	//var_dump($value);
	// 	foreach ($child as $key => $value) {
	// 		$term = get_term( $value, 'ciudad' );
	// 		//echo '- '.$value .' - '. $term->name.'<br>';
	// 		$values[$value] = $term->name;
	// 	}


	// 	/*$terms = get_terms( array(
	// 	    'taxonomy' => $_POST['parent_option'],
	// 	    'hide_empty' => false
	// 	) );
	// 	//var_dump($terms);
	// 	//$my_query = null;
	// 	$query = new WP_Query($terms);
	// 	foreach ( $query->posts as $post ) {
	// 	  $values[get_field('id',$post->ID)] = get_the_title( $post->ID );
	// 	  //echo '<option value="'.get_field('id',$post->ID).'">'.get_the_title($post->ID).'</option>';
	// 	}*/
		
	// 	echo json_encode($values);
	// 	wp_die();
	// }


	function Iels_form_shortcode($content = null) {
		global $post;
	 
		// We're outputing a lot of html and the easiest way 
		// to do it is with output buffering from php.
		ob_start();
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-autocomplete');
		wp_enqueue_style('custom-style-iels');
		wp_enqueue_script( 'post-contact-jquery' );
		wp_enqueue_script( 'jquery-validate');

		if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == 'post' )
			IELS_form_send_mail();
	?>
	<script type="text/javascript">
		(function($) {
			function getsupport ( selectedtype )
			{
			  
			  document.supportform.submit() ;
			}
			$(document).ready(function() {
				// Retreive fields SELECT

				var myLanguage = {
					requiredField: 'Este campo es obligatorio',
					errorTitle: 'Form submission failed!',
					badEmail: 'Correo no válido'
				};
				var myLanguage2 = {
					errorTitle: 'Form submission failed!'
				};
					$.validate({
						language : myLanguage,
						form : '#postcontact_new_post'
					  
					});
		        
		    });
			
			 

		 })(jQuery);
	</script>
		<div id="postcontact_form" class="">
				<?php 
				do_action( 'iels-form-notice' );  	?>
				<div class="simple-fep-inputarea">
				
					<!-- <form id="postcontact_new_post" name="new_post" method="post" action="<?php the_permalink(); ?>"> -->
					<form id="postcontact_new_post" class="postcontact_new_post" name="new_post" method="post" action="">
						<div class = "panel panel-default">
						   
						   <div class = "panel-body">
						      
						   		  <div class="form-group flex_column av_one_half  flex_column_div first  avia-builder-el-3  el_after_av_hr  el_before_av_one_half  ">
								      <label for="post-title" class="col-sm-2 control-label">Nombre <span>(*)</span></label>
								      <div class="col-sm-10">
								        <input type="text" id ="nombre" class="form-control" name="nombre" value="<?php echo isset($_POST['nombre']) ? $_POST['nombre'] : ''; ?>" class="form-control" data-validation="required"/>
								      </div>
								  </div>
								  <div class="form-group flex_column av_one_half  flex_column_div   avia-builder-el-5  el_after_av_one_half  avia-builder-el-last  ">
								      <label for="post-title" class="col-sm-2 control-label">Apellidos <span>(*)</span></label>
								      <div class="col-sm-10">
								        <input type="text" id ="apellidos" class="form-control" name="apellidos" value="<?php echo isset($_POST['apellidos']) ? $_POST['apellidos'] : ''; ?>" class="form-control" data-validation="required"/>
								      </div>
								  </div>
								  <div class="form-group form-group flex_column av_one_half  flex_column_div first  avia-builder-el-3  el_after_av_hr  el_before_av_one_half">
								      <label for="post-title" class="col-sm-2 control-label">Email <span>(*)</span></label>
								      <div class="col-sm-10">
								        <input type="text" id ="email" class="form-control" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>" class="form-control" data-validation="email"/>
								      </div>
								  </div>
								  <div class="form-group flex_column av_one_half  flex_column_div   avia-builder-el-5  el_after_av_one_half  avia-builder-el-last">
								      <label for="post-title" class="col-sm-2 control-label">Teléfono <span>(*)</span></label>
								      <div class="col-sm-10">
								        <input type="text" id ="telefono" class="form-control" name="telefono" value="<?php echo isset($_POST['telefono']) ? $_POST['telefono'] : ''; ?>" class="form-control" data-validation="required"/>
								      </div>
								  </div>
								  <div class="form-group flex_column av_one_half  flex_column_div first  avia-builder-el-3  el_after_av_hr  el_before_av_one_half">
								      <label for="ciudad-residencia" class="col-sm-2 control-label">Departamento <span>(*)</span></label>
								      <div class="col-sm-10">
								        <select id="ciudad-residencia" data-type="ciudad-residencia" data-id="ciudad-residencia" class="id_nested_select" name="ciudad-residencia" data-validation="required">
								        	<option value="">- Selecciona -</option> 	
								        	<?php fill_dropdown_iels( 'ciudad' ); ?>
										</select>
										<?php
										//$valor = get_term_children(38,'sede');
										//var_dump($valor);
										//foreach ($valor as $key => $value) {
											//$term = get_term( $value, 'sede' );
											//echo '- '.$value .' - '. $term->name.'<br>';
										//}
										
										// $term = get_term( 55, 'sede' );
										// echo $term->name;						

										//var_dump($valor);
 										?> 
								      </div>
								  </div>
								  <div class="form-group flex_column av_one_half  flex_column_div   avia-builder-el-5  el_after_av_one_half  avia-builder-el-last">
								      <label for="post-title" class="col-sm-2 control-label">Curso de tu interés</label>
								      <div class="col-sm-10">
								        <select id="cursos-ih" data-type="cursos-ih" data-id="cursos-ih" class="cursos-ih" name="cursos-ih">
								        	<option value="">- Selecciona -</option> 
								        	<?php fill_dropdown_iels( 'cursos' ); ?>	
										</select>
								      </div>
								  </div>

						   </div>
						</div>

						<div align="right">
							<a id="sbmtbtn" class="avia-button  avia-icon_select-no avia-color-theme-color avia-size-small avia-position-right">
							 <input id="submit" type="submit" tabindex="3" class="btn custombtn2" value="Registro" /></a>
							 <input type="hidden" name="action" value="post" />
						</div>
					</form>
				
				</div>
		 
		</div> <!-- #simple-fep-postbox -->
		<?php
			// Output the content.
			$output = ob_get_contents();
			ob_end_clean();
		 
			// Return only if we're inside a page. This won't list anything on a post or archive page. 
			if (is_page()) return  $output;
	}



	

	/*
	*  init_states_iels_taxonomy
	*
	*  Creates the Ciudad Taxonomy
	*  
	*/
	function init_states_iels_taxonomy() {
		$labels = array(
			'name'          => 'Ciudades',
			'singular_name' => 'Ciudad',
			'edit_item'     => 'Edit Ciudad',
			'update_item'   => 'Update Ciudad',
			'add_new_item'  => 'Add New Ciudad',
			'menu_name'     => 'Ciudades'
		);
		$args = array(
			'label'				=> esc_html__( 'Ciudad', 'ciudad' ),
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'rewrite'           => array( 'slug' => 'ciudad' )
		);
		register_taxonomy( 'ciudad', 'cpost', $args );

		$labels2 = array(
			'name'          => 'Cursos',
			'singular_name' => 'Curso',
			'edit_item'     => 'Edit Curso',
			'update_item'   => 'Update Curso',
			'add_new_item'  => 'Add New Curso',
			'menu_name'     => 'Cursos'
		);

		$args2 = array(
			'label'				=> esc_html__( 'Curso', 'cursos' ),
			'hierarchical'      => true,
			'labels'            => $labels2,
			'show_ui'           => true,
			'show_admin_column' => true,
			'rewrite'           => array( 'slug' => 'cursos' )
		);

		register_taxonomy( 'cursos', 'cpost', $args2 );

	}

	function Iels_form_notices(){
		global $notice_array;
		foreach($notice_array as $notice){
			echo '<p class="iels-form-notice">CORRECTO<br>' . $notice . '</p>';
			echo '<script type="text/javascript">
						(function($) {
							$(document).ready(function() {
						        $("#postcontact_new_post").find("input:text").val(""); 
						    });
						 })(jQuery);
					</script>';
		}
	}
	function Iels_form_errors(){
		global $error_array;
		foreach($error_array as $error){
			echo '<p class="iels-form-error">ERROR <br> ' . $error . '</p>';
		}
	}
	function fill_dropdown_iels( $taxonomy ) {
		$terms = get_terms( array(
		    'taxonomy' => $taxonomy,
		    'hide_empty' => false,
		    'parent' => 0
		) );
		//var_dump($terms);
		if ( $terms ) {
			foreach ( $terms as $term ) {
				printf( '<option value="%s">%s</option>', esc_attr( $term->name ), esc_html( $term->name ) );
			}
		}
	}
	function IELS_form_send_mail(){
/*$to      = 'gerardo@merca3w.com';
$subject = 'the subject';
$message = 'hello';
$headers = 'From: webmaster@example.com' . "\r\n" .
    'Reply-To: webmaster@example.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();


if(@mail($to, $subject, $message, $headers))
{
  echo "Mail Sent Successfully";
}else{
  echo "Mail Not Sent";
}*/

	if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == 'post' ){
 
		$nombre     		= $_POST['nombre'];
		$apellidos     		= $_POST['apellidos'];
		$email     			= $_POST['email'];
		$telefono 			= $_POST['telefono'];
 		$ciudad 			= $_POST['ciudad-residencia'];
 		//$escuela 			= $_POST['escuela-ih'];
 		$curso 				= $_POST['cursos-ih'];

		global $error_array;
		$error_array = array();
 		
 		if (empty($nombre)) $error_array[]='Escribe tu nombre';
		if (empty($apellidos)) $error_array[]='Escribe tus Apellidos.';
		if (empty($ciudad)) $error_array[]='Selecciona tu Ciudad';
		if (empty($email)) $error_array[]='Agrega un correo electrónico';
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		  $error_array[] ="Correo no válido"; 
		};
        
 
		if (count($error_array) == 0){
			global $wpdb;	
			$table_name = $wpdb->prefix . 'iels_users';
			$time = current_time('mysql');
			$wpdb->insert( $table_name, array('nombre' => $nombre, 'apellidos'=>$apellidos, 'email' => $email, 'telefono' => $telefono, 'ciudad' => $ciudad, 'curso' => $curso, 'time'=>$time, 'Status'=>'Nuevo','Asesor'=>'Sin asignar asesor') );
			//SEND MAIL NOTIFICATION
			$to = get_site_option('receiver_iels');
			$emailhidden = 'antonio.maranon@ihmexico.com';
			$headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers .= 'From: "IELTS Costa Rica" <'.get_site_option('remitente_iels').'>'. "\r\n";
			$headers .= "Bcc: $emailhidden\r\n";		
			$message = '<html>
				        <head>
				        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				            <title></title>
				        </head>
				        <body>
				        Usted cuenta con un registro nuevo en su Base de Datos'.get_bloginfo('name').' <hr>
				        <table width="100%" border="0" style="border-color:#FFF">
						  <tr>
						    <td width="50%"><strong>Nombre</strong></td>
						    <td width="50%">'.$nombre.'</td>
						  </tr>
						  <tr>
						    <td><strong>Apellidos</strong></td>
						    <td>'.$apellidos.'</td>
						  </tr>
						  <tr>
						    <td><strong>Email</strong></td>
						    <td>'.$email.'</td>
						  </tr>
						  <tr>
						    <td><strong>Teléfono</strong></td>
						    <td>'.$telefono.'</td>
						  </tr>
						  <tr>
						    <td><strong>Ciudad de Residencia</strong></td>
						    <td>'.$ciudad.'</td>
						  </tr>
						  <tr>
						    <td><strong>Curso de Interés</strong></td>
						    <td>'.$curso.'</td>
						  </tr>
						</table>
				        </body>
        				</html>
						';
			$subject = "Registro en ".get_bloginfo('name');
			if(mail($to, $subject, $message, $headers))
			{	

			  //echo "Mail Sent Successfully";
			  global $notice_array;
				$notice_array = array();
				$notice_array[] = "Su mensaje se ha enviado satisfactoriamente";
			  add_action('iels-form-notice', 'Iels_form_notices');
			  	
			}else{
			  //echo "Mail Not Sent";
			  add_action('iels-form-notice', 'Iels_form_errors');
			}
		    //wp_mail($to, $subject, $message, $headers);
 			//wp_redirect(network_site_url().'/registro-exitoso/');	
 			//header("Location: ".network_site_url()."/registro-exitoso/");
 			//echo "<script type='text/javascript'>window.top.location='".network_site_url()."/registro-exitoso/';</script>"; exit;
				//exit();
			
			

		} else {
			add_action('iels-form-notice', 'Iels_form_errors');
			
		}
		$txt = utf8_decode('Gracias por Registrarte en IELTS Costa Rica, Pronto un asesor se comunicará con usted.');
		$to = $email ;
			
			$headers = 'IELTS Costa Rica';	
			
			
			$message = $txt;
			$subject = "Registro en IELTS Costa Rica";
			@mail($to, $subject, $message, $headers);
	}
}

	/////////////////////// ADMIN SECTION 

	

?>
