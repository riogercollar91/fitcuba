<?php global $wp_locale;
if (isset($wp_locale)) {
	$wp_locale->text_direction = 'ltr';
} ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset') ?>" />
<title><?php wp_title('|', true, 'right'); bloginfo('name'); ?></title>
<!-- Created by Artisteer v4.1.0.59861 -->
<meta name="viewport" content="initial-scale = 1.0, maximum-scale = 1.0, user-scalable = no, width = device-width">
<!--[if lt IE 9]><script src="https://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
 

<link rel="icon" href="<?php bloginfo('siteurl'); ?>/favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="<?php bloginfo('siteurl'); ?>/favicon.ico" type="image/x-icon" />

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url') ?>" media="screen" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
  
<?php
remove_action('wp_head', 'wp_generator');
if (is_singular() && get_option('thread_comments')) {
	wp_enqueue_script('comment-reply');
}

wp_head();
?>

  

  
  
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />

<link rel="stylesheet" href="/wp-content/plugins/slider/template.css" type="text/css" />
  <link rel="stylesheet" href="/wp-content/plugins/slider/rs-plugin/css/settings.css" type="text/css" />
 

  <script src="/wp-content/plugins/slider/jquery.min.js" type="text/javascript"></script>
  <script src="/wp-content/plugins/slider/jquery-noconflict.js" type="text/javascript"></script>
  <script src="/wp-content/plugins/slider/jquery-migrate.min.js" type="text/javascript"></script>
  <script src="/wp-content/plugins/slider/tabs-state.js" type="text/javascript"></script>
  <script src="/wp-content/plugins/slider/fileuploader.min.js" type="text/javascript"></script>
  <script src="/wp-content/plugins/slider/core.js" type="text/javascript"></script>
  <script src="/wp-content/plugins/slider/chosen.jquery.min.js" type="text/javascript"></script>
  <script src="/wp-content/plugins/slider/caption.js" type="text/javascript"></script>
  <script src="/wp-content/plugins/slider/widgetkit-0f2ed7e3.js" type="text/javascript"></script>
  <script src="/wp-content/plugins/slider/bootstrap.min.js" type="text/javascript"></script>
  <script src="/wp-content/plugins/slider/template.js" type="text/javascript"></script>
  <script src="/wp-content/plugins/slider/rs-plugin/js/jquery.themepunch.plugins.min.js" type="text/javascript"></script>
  <script src="/wp-content/plugins/slider/rs-plugin/js/jquery.themepunch.revolution.min.js" type="text/javascript"></script>

  
  <script type="text/javascript">
jQuery(window).on('load',  function() {
				new JCaption('img.caption');
			});
jQuery(document).ready(function()
				{
					jQuery('.hasTooltip').tooltip({"html": true,"container": "body"});
				});
  </script>     

  

</head>
<body <?php body_class(); ?>>

<div id="art-main">



<div class="header"> 

     <?php 

function qtrans_generateLanguageSelectCode($style='', $id=''){ return qtranxf_generateLanguageSelectCode($style,$id); }

     echo qtrans_generateLanguageSelectCode('image'); 

     ?>

            <!--  <div id="menu_rss" style="float: right;">  <?php echo show_rss_menu(); ?> </div> -->



        <div class="container">     
            
            <a href="javascript:void(0);" class="liga-logo-767">
                <img alt="FITCuba" src="/wp-content/uploads/2015/10/logo-767.png" class="img-logo-767">
            </a> 
            
            <div class="navigation-top">
                


	<?php
		$uri = $_SERVER['REQUEST_URI'];
		
		if(strpos($uri, "/en/") !== FALSE){
			$idioma = "en";
		}
    else if(strpos($uri, "/fr/") !== FALSE){
      $idioma = "fr";
    }
        else {
      $idioma = "es";
    }
	?>

	
	<?php
	if($idioma == "es"){
	?>
	<div class="search">
    <form class="form-inline" method="post" action="/">
         <input type="image" onclick="this.form.searchword.focus();" src="/wp-content/uploads/2015/10/icon-search.png" class="button" value="Buscar">
		  <input type="text" onfocus="if (this.value=='Buscar...') this.value='';" onblur="if (this.value=='') this.value='';" size="20" class="inputbox search-query" maxlength="20" id="mod-search-searchword" name="s"> 
		 <input type="hidden" value="search" name="task">
        <input type="hidden" value="com_search" name="option">
        <input type="hidden" value="102" name="Itemid">
    </form>
</div>
	
                <ul class="nav menu">	
<li class="item-102 current active"><a href="/es/">Inicio</a></li><li class="item-108"><a href="/es/faqs/">FAQS</a></li><li class="item-109"><a href="/es/mapa-del-sitio">Mapa del Sitio</a></li><li class="item-110"><a href="/es/contacto">Contacto</a></li></ul>
<?php
	}
?>



<?php
	if($idioma == "en"){
	?>
	
<div class="search">
    <form class="form-inline" method="post" action="/en/">
         <input type="image" onclick="this.form.searchword.focus();" src="/wp-content/uploads/2015/10/icon-search.png" class="button" value="Buscar">
		  <input type="text" onfocus="if (this.value=='Buscar...') this.value='';" onblur="if (this.value=='') this.value='';" size="20" class="inputbox search-query" maxlength="20" id="mod-search-searchword" name="s"> 
		 <input type="hidden" value="search" name="task">
        <input type="hidden" value="com_search" name="option">
        <input type="hidden" value="102" name="Itemid">
    </form>
</div>
                <ul class="nav menu">	
<li class="item-102 current active"><a href="/en/"> Home </a></li><li class="item-108"><a href="/en/faqs/"> FAQS </a></li><li class="item-109"><a href="/en/mapa-del-sitio">Sitemap </a></li><li class="item-110"><a href="/en/contacto"> Contact </a></li></ul>
<?php
	}
?>

<?php
  if($idioma == "fr"){
  ?>
  
<div class="search">
    <form class="form-inline" method="post" action="/fr/">
         <input type="image" onclick="this.form.searchword.focus();" src="/wp-content/uploads/2015/10/icon-search.png" class="button" value="Buscar">
      <input type="text" onfocus="if (this.value=='Buscar...') this.value='';" onblur="if (this.value=='') this.value='';" size="20" class="inputbox search-query" maxlength="20" id="mod-search-searchword" name="s"> 
     <input type="hidden" value="search" name="task">
        <input type="hidden" value="com_search" name="option">
        <input type="hidden" value="102" name="Itemid">
    </form>
</div>
                <ul class="nav menu"> 
<li class="item-102 current active"><a href="/fr/"> Début </a></li><li class="item-108"><a href="/fr/faqs/"> FAQS </a></li><li class="item-109"><a href="/fr/mapa-del-sitio">Plan du site </a></li><li class="item-110"><a href="/fr/contacto"> Contacts </a></li></ul>
<?php
  }
?>




 
                
            </div>
            <a href="/inicio/" class="liga-logo">
                <img alt="FITCuba" src="/wp-content/uploads/2015/10/logo-fix.png" class="img-logo">
            </a> 
                        
        </div>	
    </div>

	

<?php if ( function_exists( 'easingslider' ) ) { easingslider( 1456 ); } ?>

<div class="art-sheet clearfix">
<nav class="art-nav">
    <?php
	echo theme_get_menu(array(
			'source' => theme_get_option('theme_menu_source'),
			'depth' => theme_get_option('theme_menu_depth'),
			'menu' => 'primary-menu',
			'class' => 'art-hmenu'
		)
	);
	get_sidebar('nav'); 
?> 
    </nav>
<div class="art-layout-wrapper">
                <div class="art-content-layout">
                    <div class="art-content-layout-row">
                        <div class="art-layout-cell art-content">

