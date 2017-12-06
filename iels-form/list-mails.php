<?php 

global $wpdb;   

if ($_POST['date_start1']) {
    $date_start1 = date('Y-m-d',strtotime($_POST['date_start1']));
        $date_end1 = date('Y-m-d',strtotime($_POST['date_end1']));
} else {
    $date_end1 = date('Y-m-d', strtotime(' +1 day'));
    $date_start1 = date('Y-m-d', strtotime(' -29 day'));
}

$table_name = $wpdb->prefix . 'iels_users';
//echo $date_start1 . '-----'.$date_end1;
//$check = $wpdb->get_results("SELECT * FROM $table_name WHERE report IS NOT NULL AND TRIM(report) <> ''" WHERE time + INTERVAL 30 DAY <= NOW());
$check = $wpdb->get_results("SELECT * FROM $table_name WHERE time between '$date_start1' and '$date_end1'" );

if(!empty($_GET['status'])){
    switch($_GET['status']){
        case 'succ':
            $statusMsgClass = 'alert-success';
            $statusMsg = 'Se insertaron nuevos registros.';
            break;
        case 'err':
            $statusMsgClass = 'alert-danger';
            $statusMsg = 'Ocurrio un error, intente de nuevo.';
            break;
        case 'settings_ok':
            $statusMsgClass = 'alert-success';
            $statusMsg = 'Ajustes actualizados correctamente';
            break;
        default:
            $statusMsgClass = '';
            $statusMsg = '';
    }
}

?>
<div class="wrap">
            <div class="float-right"><?php echo '<img src="'.plugin_dir_url( __FILE__ ).'../assets/img/ielts-logotipo.png" />' ?></div>
            <h1>Bienvenido al Sistema de Formularios y Taxonomias de IELS</h1>
            <hr>
        <div class="about-text wpem-welcome">
            <p>A continuación usted cuenta con un listado de registros que corresponden al lapso de 1 mes. </p><p>Adicional a esto, este sistema genera un shortcode del que puede hacer uso para insertar un formulario de contacto el cual se introduce así: <b>[IELS_FORM]</b>.</p>

            <p>Si así lo desea también puede modificar el Asunto en la sección de Ajustes que se presenta adelante.</p></div>

            <?php if(!empty($statusMsg)){
                echo '<div class="alert '.$statusMsgClass.' alert-dismissible" role="alert">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <strong>'.$statusMsg.'</strong>
                    </div>';
                } ?>


        <div class="panel panel-primary">
            <div class="tab panel-heading">
              <button class="tablinks" onclick="openCity(event, 'Registro')" id="defaultOpen">Registro de Correos</button>
              <button class="tablinks" onclick="openCity(event, 'Ajustes')">Ajustes</button>
              
            </div>

            <div id="Registro" class="tabcontent">
                <div class="changelog">
                    <form method="post">
                    <table border="0" cellspacing="5" cellpadding="5">
                        <tbody><tr>
                            <td>Fecha Inicio:</td>
                            <td><input type="date" name="date_start1" id="date_start1" value="<?php echo $date_start1 ?>" /></td>

                        </tr>
                        <tr>
                            <td>Fecha Fin:</td>
                            <td><input type="date" name="date_end1" id="date_end1" value="<?php echo $date_end1 ?>" /></td>
                        </tr>
                        <tr>
                            <td colspan="2"><input type="submit" value="Consultar" /></td>
                        </tr>
                    </tbody></table></form>
                    <table id="users-list" class="table table-striped hover table-bordered compact order-column" cellspacing="0" width="100%">
                        <thead>
                            <tr class="danger">
                                <th title="" data-container="body">ID</th>
                                <th title="" data-container="body">Nombre</th>
                                <th title="" data-container="body">Email</th>
                                <th title="" data-container="body">Asesor</th>
                                <th title="" data-container="body">Status</th>
                                <th title="" data-container="body">Teléfono</th>
                                <th title="" data-container="body">Ciudad</th>
                                <th title="" data-container="body">Curso</th>
                                <th title="" data-container="body">Fecha</th>
                                
                            </tr>
                        </thead>
                        <tfoot>
                            <tr class="danger">
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th >Asesor</th>
                                <th >Status</th>
                                <th>Teléfono</th>
                                <th>Ciudad</th>
                                <th>Curso</th>
                                <th>Fecha</th>
                        </tfoot>
                        <tbody> 
                        <?php 
                            if ($check) {
                                //global $post;
                                foreach ( $check as $item)
                                {
                                  ?> 
                                    <tr>
                                        <td><?php echo $item->id ?></td>
                                        <td data-container="body" class="tooltipme"><?php echo $item->nombre.' '.$item->apellidos; ?></td>
                                        <td><?php echo $item->email ?></td>
                                        <td><?php echo $item->Status ?></td>
                                        <td><?php echo $item->Asesor ?></td>
                                        <td><?php echo $item->telefono ?></a></td>
                                        <td><?php echo $item->ciudad  ?></a></td>
                                        <td><?php echo $item->curso ?></a></td>
                                        <td><?php echo $item->time ?></td>
                                    </tr>
                                  <?php
                                //endwhile;
                                }
                            }
                            ?>
                        </tbody>
                    </table>

                </div>
            </div>

            <div id="Ajustes" class="tabcontent">
                <div class="changelog point-releases">
                        
                    <form action="<?php echo plugins_url();?>/my-iels/update.php?a=1" method="post" id="demoFrm" >
                            <?php
                                if (add_site_option( 'asunto_iels', 'IELS Notifica') || add_site_option( 'remitente_iels', 'no-reply@iels.com.mx') || add_site_option( 'destinatario_iels', 'pisd14@gmail.com') ) {
                                   $asunto = get_site_option( 'asunto_iels' );
                                }
                            ?> 
                            Introduzca el Asunto de los Mensajes
                            <div>
                                <input type="text" name="asunto" id="asunto" class="form-control" placeholder="Asunto" value="<?php echo get_site_option('asunto_iels') ?>" />
                            </div>
                            <p>&nbsp;</p>
                            Introduzca el Destinatario de los Correos
                            <div>
                                <input type="text" name="destinatario" id="destinatario" class="form-control" placeholder="destinatario" value="<?php echo get_site_option('destinatario_iels') ?>" />
                            </div>
                            <p>&nbsp;</p>
                            Introduzca el Remitente de Correos
                            <div>
                                <input type="text" name="remitente" id="remitente" class="form-control" placeholder="Remitente" value="<?php echo get_site_option('remitente_iels') ?>" />
                            </div>
                            <p>&nbsp;</p>
                            <p></p>
                            <p><input type="submit" id="submit_fields" name="submit_fields" class="button button-primary" value="Guardar Ajustes"></p>
                        </form>

                </div>
                
            </div>
            <script type="text/javascript">
            function openCity(evt, cityName) {
                // Declare all variables
                var i, tabcontent, tablinks;

                // Get all elements with class="tabcontent" and hide them
                tabcontent = document.getElementsByClassName("tabcontent");
                for (i = 0; i < tabcontent.length; i++) {
                    tabcontent[i].style.display = "none";
                }

                // Get all elements with class="tablinks" and remove the class "active"
                tablinks = document.getElementsByClassName("tablinks");
                for (i = 0; i < tablinks.length; i++) {
                    tablinks[i].className = tablinks[i].className.replace(" active", "");
                }

                // Show the current tab, and add an "active" class to the button that opened the tab
                document.getElementById(cityName).style.display = "block";
                evt.currentTarget.className += " active";
            }
            document.getElementById("defaultOpen").click();
        </script>
    </div>
