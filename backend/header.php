<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Backend Generator V2</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- special jquery jQuery 2.1.3 -->
    <script src="<?=base_admin();?>assets/plugins/jQuery/jQuery-2.1.3.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?=base_admin();?>assets/plugins/jquery-ui/jquery-ui.min.css">
    <!-- boostrap check style -->
    <link rel="stylesheet" href="<?=base_admin();?>assets/dist/css/build.css">
    <!--chosen select -->
    <link href="<?=base_admin();?>assets/plugins/chosen/chosen.min.css" rel="stylesheet" type="text/css" />
         <!-- Bootstrap 3.3.2 -->
    <link href="<?=base_admin();?>assets/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="<?=base_admin();?>assets/plugins/chosen/chosen-bootstrap.css" rel="stylesheet" type="text/css" />
    <!--home assets -->
    <!-- Font Awesome Icons -->
    <link href="<?=base_admin();?>assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="<?=base_admin();?>assets/plugins/ionic/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Morris chart -->
    <link href="<?=base_admin();?>assets/plugins/morris/morris.css" rel="stylesheet" type="text/css" />
    <!-- jvectormap -->
    <link href="<?=base_admin();?>assets/plugins/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
    <!-- Daterange picker -->
    <link href="<?=base_admin();?>assets/plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="<?=base_admin();?>assets/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins
    folder instead of downloading all of them to reduce the load. -->
    <link href="<?=base_admin();?>assets/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
    <!-- DATA TABLES -->
    <link href="<?=base_admin();?>assets/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="<?=base_admin();?>assets/plugins/datatables/extensions/Responsive/css/dataTables.responsive.css" rel="stylesheet" type="text/css" />
    <!-- i just place it DATA TABES SCRIPT here-->
    <script src="<?=base_admin();?>assets/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
    <script src="<?=base_admin();?>assets/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
    <script src="<?=base_admin();?>assets/plugins/datatables/dataTables.tableTools.js" type="text/javascript"></script>
 
    <link rel="stylesheet" type="text/css" href="<?=base_admin();?>assets/plugins/datatables/extensions/TableTools/css/dataTables.tableTools.css">
    <link rel="stylesheet" type="text/css" href="<?=base_admin();?>assets/plugins/datatables/extensions/Buttons/css/buttons.dataTables.min.css">
    <script type="text/javascript" language="javascript" src="<?=base_admin();?>assets/plugins/datatables/extensions/Buttons/js/dataTables.buttons.min.js">
    </script>
    <script type="text/javascript" language="javascript" src="<?=base_admin();?>assets/plugins/datatables/extensions/Buttons/js/buttons.flash.min.js">
    </script>
    <script type="text/javascript" language="javascript" src="<?=base_admin();?>assets/plugins/datatables/jszip.min.js">
    </script>
    <script type="text/javascript" language="javascript" src="<?=base_admin();?>assets/plugins/datatables/pdfmake.min.js">
    </script>
    <script type="text/javascript" language="javascript" src="<?=base_admin();?>assets/plugins/datatables/vfs_fonts.js">
    </script>
    <script type="text/javascript" language="javascript" src="<?=base_admin();?>assets/plugins/datatables/extensions/Buttons/js/buttons.html5.min.js">
    </script>
    <script type="text/javascript" language="javascript" src="<?=base_admin();?>assets/plugins/datatables/extensions/Buttons/js/buttons.print.min.js">
    </script>
    <script src="<?=base_admin();?>assets/plugins/datatables/extensions/Responsive/js/dataTables.responsive.min.js" type="text/javascript"></script>
    <!--form asset -->
    <link href="<?=base_admin();?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
    <!-- date picker -->
    <link href="<?=base_admin();?>assets/plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
    <!-- Bootstrap time Picker -->
    <link rel="stylesheet" href="<?=base_admin();?>assets/plugins/timepicker/bootstrap-timepicker.min.css">
    <!--switch button -->
    <link href="<?=base_admin();?>assets/plugins/switch/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
    <!--fancy box -->
    <link href="<?=base_admin();?>assets/plugins/fancybox/jquery.fancybox.css" rel="stylesheet" type="text/css" />
    <!--always show up -->
    <link href="<?=base_admin();?>assets/plugins/fakeloader/fakeLoader.css" rel="stylesheet" type="text/css" />
    <!--image preview -->
    <link href="<?=base_admin();?>assets/plugins/holder/jasny-bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?=base_admin();?>assets/dist/css/overide.css" rel="stylesheet" type="text/css" />
    <style type="text/css">
    /* remove this style if you want standar font size */
      body {
        font-size: 13px;
      }
    </style>
  </head>
   <body class="skin-blue">
    <div class="fakeloader"></div>
    <div id="loadnya" style="display:none">
      <img src="<?=base_admin();?>assets/dist/img/loadnya.gif" class="ajax-loader"/>
    </div>
    <!--notif here -->
    <div class="notif_top" style="display:none">
      <div class="alert alert-success" style="margin-left:0">
        <button class="close" data-dismiss="alert">×</button>
        <center>
        <strong>Data Berhasil di Tambahkan</strong>
        </center>
      </div>
    </div>
    <div class="notif_top_up" style="display:none">
      <div class="alert alert-success" style="margin-left:0">
        <button class="close" data-dismiss="alert">×</button>
        <center>
        <strong>Data Berhasil di Perbaharui</strong>
        </center>
      </div>
    </div>
    <div class="wrapper">
      <?php
      include "top_bar.php";
      include "left_nav.php";
      ?>
