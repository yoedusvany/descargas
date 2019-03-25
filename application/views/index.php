<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Sistema Inform&aacute;tico para las descargas centralizadas</title>

        <script type="text/javascript">
            var BASE_PATH = '<?php echo base_url(); ?>';
            var usuario = '<?php echo $usuario; ?>';
            var rol = '<?php echo $rol; ?>';
            var email = '<?php echo $email; ?>';
        </script>

        <link rel="shortcut icon" type="image/ico" href="<? echo base_url(); ?>web/images/favicon.ico" />

        <!--<link rel="stylesheet" type="text/css" href="<? echo base_url(); ?>ext/classic/theme-crisp/resources/theme-crisp-all.css">-->
        <link rel="stylesheet" type="text/css" href="<? echo base_url(); ?>ext/classic/theme-triton/resources/theme-triton-all.css">

        <script src="<? echo base_url(); ?>ext/ext-all.js"></script>
        <script src="<? echo base_url(); ?>ext/classic/locale/locale-es.js" type="text/javascript"></script>
        <script src="<? echo base_url(); ?>ext/classic/theme-crisp/theme-crisp.js"></script>
        <script type="text/javascript" src="<? echo base_url(); ?>ext/packages/charts/classic/charts.js"></script>
        <link type="text/css" href="<? echo base_url(); ?>ext/packages/charts/classic/triton/resources/charts-all.css">

        <script type ="text/javascript" src="<? echo base_url(); ?>web/backend/app.js"></script>


        <script language="javascript">
            if (history.forward(1)) {
                location.replace(history.forward(1))
            }
        </script>

        <style type="text/css">
            .icon-ayuda {
                background-image:url(<?php echo base_url(); ?>web/images/help.png) !important;
            }
            .icon-acercade {
                background-image:url(<?php echo base_url(); ?>web/images/acercade.ico) !important;
            }
            .icon-salir {
                background-image:url(<?php echo base_url(); ?>web/images/salir.png) !important;
            }
            .app-header {
                //background-color: #7fad33;
                background-color: #112D41;
                font-size: 22px;
                font-weight: 200;
                padding: 8px 15px;
                text-shadow: 0 1px 0 #fff;
            }
            .icon-reporteyoe {
                background-image:url(<?php echo base_url(); ?>web/images/reportes.png) !important;
                height:32px!important;
                width:32px!important;
            }
            .icon-stats {
                background-image:url(<?php echo base_url(); ?>web/images/stats.png) !important;
                height:32px!important;
                width:32px!important;
            }

            .icon-usuarios {
                background-image:url(<?php echo base_url(); ?>web/images/usuarios.png) !important;
                height:32px!important;
                width:32px!important;
            }
            .icon-descargandoahora {
                background-image:url(<?php echo base_url(); ?>web/images/descargas-ahora.png) !important;
                height:32px!important;
                width:32px!important;
            }
            .icon-opciones-gen {
                background-image:url(<?php echo base_url(); ?>web/images/opciones-gen1.png) !important;
                height:32px!important;
                width:32px!important;
            }
            .icon-descargas {
                background-image:url(<?php echo base_url(); ?>web/images/descargas.png) !important;
                height:32px!important;
                width:32px!important;
            }
            .icon-descargas1 {
                background-image:url(<?php echo base_url(); ?>web/images/downloads.png) !important;
                height:32px!important;
                width:32px!important;
            }
            .icon-searchtab {
                background-image:url(<?php echo base_url(); ?>web/images/searchtab.png) !important;
                height:32px!important;
                width:32px!important;
            }
            .icon-pregunta {
                background-image:url(<?php echo base_url(); ?>web/images/pregunta32.png) !important;
                height:32px!important;
                width:32px!important;
            }
            .icon-logs {
                background-image:url(<?php echo base_url(); ?>web/images/log32.png) !important;
                height:32px!important;
                width:32px!important;
            }
            .icon-openFile {
                background-image:url(<?php echo base_url(); ?>web/images/openFile1.ico) !important;
            }
            .icon-reset {
                background-image:url(<?php echo base_url(); ?>web/images/reset.png) !important;
            }

            




            /*.menu-title{
                margin:-2px -2px 0;
                color:#FFFFFF;
                font:bold 15px tahoma,arial,verdana,sans-serif;
                display:block;
                padding:3px;
            }



            .icon-descargasRealTime {
                background-image:url(<?php echo base_url(); ?>web/images/favicon.ico) !important;
            }

            .icon-grid {
                background-image:url(<?php echo base_url(); ?>web/images/grid.png) !important;
            }

            .icon-form {
                background-image:url(<?php echo base_url(); ?>web/images/application_go.png) !important;
            }

            .icon-logs {
                background-image:url(<?php echo base_url(); ?>web/images/logs1.ico) !important;
            }

            .icon-reportes {
                background-image:url(<?php echo base_url(); ?>web/images/reportes.ico) !important;
            }

            .icon-stats {
                background-image:url(<?php echo base_url(); ?>web/images/stats.ico) !important;
            }

            .icon-all-descargas {
                background-image:url(<?php echo base_url(); ?>web/images/all-descargas.ico) !important;
            }

            .icon-todas {
                background-image:url(<?php echo base_url(); ?>web/images/todas.ico) !important;
            }

            .icon-cancel {
                background-image:url(<?php echo base_url(); ?>web/images/cancel.gif) !important;
            }

            .icon-add {
                background-image:url(<?php echo base_url(); ?>web/images/add.png) !important;
            }
            .icon-rtf {
                background-image:url(<?php echo base_url(); ?>web/images/report_add.png) !important;
            }




            .icon-usuario {
                background: transparent url(<?php echo base_url(); ?>web/images/usuario.png) no-repeat;
                padding-left: 20px;
            }

            .icon-opciones {
                background-image:url(<?php echo base_url(); ?>web/images/opciones.ico) !important;
            }

            .icon-OG {
                background-image:url(<?php echo base_url(); ?>web/images/og.png) !important;
            }

            .icon-search {
                background-image:url(<?php echo base_url(); ?>web/images/search.png) !important;
            }
            .icon-search1 {
                background-image:url(<?php echo base_url(); ?>web/images/search1.png) !important;
            }



            .icon-ultimas-descargas {
                background-image:url(<?php echo base_url(); ?>web/images/ultimas-descargas.png) !important;
            }

            .icon-sugerencias {
                background-image:url(<?php echo base_url(); ?>web/images/sugerencias.png) !important;
            }

            .icon-abrir {
                background-image:url(<?php echo base_url(); ?>web/images/abrir.ico) !important;
            }

            .icon-infodescarga {
                background-image:url(<?php echo base_url(); ?>web/images/info1.png) !important;
            }




            .style1 {color: #FFFFFF}*/

        </style>


    </head>
    <body>

    </body>
</html>