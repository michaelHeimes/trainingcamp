<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package trainingcamp
 */
get_header(); ?>
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-dev">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport"
		  content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
	<meta name="apple-mobile-web-app-capable" content="yes"/>
	<link rel="shortcut icon" href="<?php trainingcamp_images_uri('apple-icon.png') ?>" type="image/x-icon">
	<link rel="icon" href="<?= trainingcamp_images_uri('favicon.ico') ?>" type="image/x-icon">
	<link rel="apple-touch-icon" href="<?= trainingcamp_images_uri('apple-icon.png') ?>"/>
	<meta content="telephone=no" name="format-detection">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="stylesheet" id="trainingcamp-404-style-css" href="<?= get_template_directory_uri() ?>/slice/dist/css/error-page.min.css" type="text/css" media="all">
</head>
<body>

<main class="wrapper">

	<div class="page">
		<div class="section section-right" style="background-image: url('<?= get_template_directory_uri() ?>/slice/dist/images/error-page-bg.jpg');">
			<div class="container">
				<h1>404</h1>
				<h3>oops, we are reorganizing!</h3>
				<h3>The page you're looking has moved.  <br>We recently updated our website.  <br>Please navigate using the menu above.</h3>
				<a href="<?= site_url() ?>" class="btn btn-white">back to home</a>
				<a href="<?= site_url() ?>" id="link-home" style="display: none;">back to home</a>
			</div>
		</div>

		<div class="section section-left" style="background-color:black">
			<h2><span>new</span> <span>website</span> <span>alert</span></h2>
		</div>
	</div>

</main>
<div class="popups"></div>
<?php
get_footer();

