<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Sistema Inform&aacute;tico para las Descargas Centralizadas</title>
        <link rel="shortcut icon" type="image/ico" href="<? echo base_url(); ?>web/images/favicon.ico" />

<!--<link rel="stylesheet" type="text/css" href="<? echo base_url(); ?>ext/classic/theme-crisp/resources/theme-crisp-all.css">-->
            <link rel="stylesheet" type="text/css" href="<? echo base_url(); ?>ext/classic/theme-triton/resources/theme-triton-all.css">
            <script src="<? echo base_url(); ?>ext/ext-all.js"></script>
            <script src="<? echo base_url(); ?>ext/classic/locale/locale-es.js" type="text/javascript"></script>
            <!--<script src="<? echo base_url(); ?>ext/classic/theme-crisp/theme-crisp.js"></script>-->
            <script src="<? echo base_url(); ?>ext/classic/theme-crisp/theme-crisp.js"></script>
            <script type="text/javascript" src="<? echo base_url(); ?>ext/packages/charts/classic/charts.js"></script>
            <link type="text/css" href="<? echo base_url(); ?>ext/packages/charts/classic/triton/resources/charts-all.css">

            <script type ="text/javascript" src="<? echo base_url(); ?>web/frontend/app.js"></script>




        <script type="text/javascript">
            var BASE_PATH = '<?php echo base_url(); ?>';
            var SEDE = '<?php echo $sede; ?>';
        </script>

        <script language="javascript">
            if (history.forward(1)) {
                location.replace(history.forward(1))
            }
        </script>

        <style type="text/css">
            .icon-reset {
                background-image:url(<?php echo base_url(); ?>web/images/reset.png) !important;
            }
            .icon-openFile {
                background-image:url(<?php echo base_url(); ?>web/images/openFile1.ico) !important;
            }

            .app-header {
                //background-color: #7fad33;
                background-color: #112D41;
                font-size: 22px;
                font-weight: 200;
                padding: 8px 15px;
                text-shadow: 0 1px 0 #fff;
            }






            .icon-form {
                background-image:url(<?php echo base_url(); ?>web/images/application_go.png) !important;
            }

            .icon-cancel {
                background-image:url(<?php echo base_url(); ?>web/images/cancel.gif) !important;
            }

            .icon-add {
                background-image:url(<?php echo base_url(); ?>web/images/add.png) !important;
            }

            .icon-logo {
                background-image:url(<?php echo base_url(); ?>web/images/Download.ico) !important;
            }

            .style1 {color: #FFFFFF}

        </style>


    </head>
    <body>

    </body>
</html>
