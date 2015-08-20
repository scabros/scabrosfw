<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo TITLE; ?></title>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo URL; ?>css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo URL; ?>css/clean-blog.min.css" rel="stylesheet">

    <!-- Notifyit CSS -->
    <link href="<?php echo URL; ?>css/notifIt.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
	<?php echo $cabecera; ?>
	<?php echo $contenido; ?>
	<?php echo $footer; ?>
  <!-- jQuery -->
  <script src="<?php echo URL; ?>js/jquery.js"></script>
  <!-- NotifIt Javascript -->
  <script src="<?php echo URL; ?>js/notify.min.js"></script>
  <!-- Bootstrap Core JavaScript -->
  <script src="<?php echo URL; ?>js/bootstrap.min.js"></script>
  <!-- Custom Theme JavaScript -->
  <script src="<?php echo URL; ?>js/clean-blog.min.js"></script>
  <!-- Custom Functions JavaScript -->
  <script src="<?php echo URL; ?>js/common.js"></script>

  <?php getNotification(); ?>
  <div id="darkLayer" class="darkClass" style="display:none"><!--Cargando...--></div>
</body>

</html>
