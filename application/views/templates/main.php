<?php $first = $this->uri->segment(1); ?>
<!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!-- Consider adding a manifest.appcache: h5bp.com/d/Offline -->
<!--[if gt IE 8]><!--> <html class="no-js" lang="fr"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<base href="<?php echo base_url(); ?>">

	<title><?php echo $title.' | '. config_item('site_name'); ?></title>
	<meta name="description" content="">
	<meta name="author" content="Robert Doucette">

	<!-- Mobile viewport optimized: j.mp/bplateviewport -->
	<meta name="viewport" content="width=device-width,initial-scale=1">

	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/jquery-ui-1.8.16.css">

	<!-- All JavaScript at the bottom, except this Modernizr build incl. Respond.js
		Respond is a polyfill for min/max-width media queries. Modernizr enables HTML5 elements & feature detects; 
		for optimal performance, create your own custom Modernizr build: www.modernizr.com/download/ -->
	<script src="js/libs/modernizr-2.0.6.min.js"></script>
</head>

<body>
		<header>
			<nav>
				<ul>
<?php echo list_nav('', $first, array(''=>'Accueil', 'bib'=>'Bibliothèque', 'cal'=>'Calendrier'), 5); ?>
				</ul>
			</nav>
			<div id="connexion_box">
<?php if($this->current_user->info()): ?>
				<p>Bienvenue, <strong><?php echo $this->current_user->info()->pseudo; ?></strong></p>
				<a href="logout">Se déconnecter</a>
<?php elseif($first !== 'connexion'): ?>
				<a href="connexion">Se connecter</a>
<?php endif; ?>
			</div>
		</header>
		<div id="main" role="main">
<?php $this->load->view($view.'_view'); ?>
		</div>
		<footer>

		</footer>


	<!-- JavaScript at the bottom for fast page loading -->

	<!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="js/libs/jquery-1.7.1.min.js"><\/script>')</script>
	<script src="js/libs/jquery-ui-1.8.16.js"></script>


	<!-- scripts concatenated and minified via build script -->
	<script defer src="js/plugins.js"></script>
	<script defer src="js/script.js"></script>
	<!-- end scripts -->


	<!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
			chromium.org/developers/how-tos/chrome-frame-getting-started -->
	<!--[if lt IE 7 ]>
		<script defer src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
		<script defer>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
	<![endif]-->

</body>
</html>