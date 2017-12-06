<?php
	require_once($_SERVER['DOCUMENT_ROOT'] .   '/wp-config.php');
	require_once($_SERVER['DOCUMENT_ROOT'] .   '/wp-load.php');
	global $wpdb; 
	$url_dominio = network_site_url('','http');
	if($_GET['a']==1){
		if(isset($_POST['submit_fields'])){
			update_site_option( 'asunto_iels', $_POST['asunto'] );
			update_site_option( 'remitente_iels', $_POST['remitente'] );
      update_site_option( 'destinatario_iels', $_POST['destinatario'] );
			header("Location: ".$url_dominio."/wp-admin/admin.php?page=iels-form-plugin&status=settings_ok");
		}
		
