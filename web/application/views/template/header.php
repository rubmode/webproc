<!doctype html>
<html lang="es">
	<head>
		<meta charset="utf-8">
	    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
		<title></title>
		<meta name="description" content="">
		<meta name="author" content="">
		<?php
			foreach ($style as $key => $value) {
			 	echo '<link rel="stylesheet" href="'.base_url().'assets/'.$value.'.css" type="text/css">';
		 	}
		 ?>
		<!--[if lt IE 9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
	</head>
    <body>
    	<section id="wp-content" class="container-fluid">