<?php get_header(); ?>
			<?php get_sidebar('top'); ?>
				

				<?php if ( !is_front_page() ) { ?>
				<ul class="breadcrumb">
				<?php if ( function_exists('yoast_breadcrumb') ) {

yoast_breadcrumb('<p id="breadcrumbs">','</p>');

} ?>
</ul>
				<?php } ?>



			<?php

			if (have_posts()) {
				/* Start the Loop */
				while (have_posts()) {
					the_post();
					get_template_part('content', 'page');
				}
			} else {
				theme_404_content();
			}
			?>	


			
<!--<div class="custom">	
<div class="redes" dir="rtl">
<ul class="items-redes">
<li><a target="_blank" href="https://www.facebook.com/events/751415718201881/" class="red-facebook"><em>FACEBOOK</em></a></li>
<li><a target="_blank" href="https://twitter.com/search?q=FITCuba_2014" class="red-twitter"><em>TWITTER</em></a></li>
<li><a target="_blank" href="https://www.youtube.com/channel/UC_9X-fFax1rCHVYcLvQqJZQ" class="red-youtube"><em>YOUTUBE</em></a></li>
<li><a target="_blank" href="http://www.rss.com" class="red-rss"><em>RSS</em></a></li>
</ul>
</div>
</div>-->
	
	
	
			<?php get_sidebar('bottom'); ?>
			
			
			
<?php
		$uri = $_SERVER['REQUEST_URI'];
		
		if(strpos($uri, "/en/") !== FALSE){
			$idioma = "en";
		}
    else if(strpos($uri, "/fr/") !== FALSE){
      $idioma = "fr";
    }
    		else {
		// else{
			$idioma = "es";
		}
	?>
	
	<?php
	if($idioma == "es"){
	?>
                <div class="art-postcontent clearfix">
			<div class="textwidget">
			<div class="custom">
						<div class="custom art-post">
<div class="border-blocks-squads">&nbsp;</div>
<div class="row-fluid blocks-squads">
<div class="span4 block-squad"  style="height: 100px;">
<div class="header-block">
<h3 style="height: 18px;">País invitado</h3>
<?php

// obtencion de los titulos de los resumenes
$patronesp=':es]'; 
global $wpdb;
$querypaisesp = " SELECT post_title FROM wp_posts where post_name='pais-invitado' and post_status='publish'";
$titlepaisesp = $wpdb->get_var($querypaisesp);  
$title_paisesp1=devolver_titulo($patronesp, $titlepaisesp);

$querydestesp = " SELECT post_title FROM wp_posts where post_name='destino' and post_status='publish'";
$titledestesp = $wpdb->get_var($querydestesp);    
$title_destesp1=devolver_titulo($patronesp, $titledestesp);

$queryprodesp = " SELECT post_title FROM wp_posts where post_name='producto' and post_status='publish'";
$titleprodesp = $wpdb->get_var($queryprodesp);    
$title_prodesp1=devolver_titulo($patronesp, $titleprodesp);

// obtencion del contenido de los resumenes
$querypaisesp = " SELECT post_content FROM wp_posts where post_name='pais-invitado' and post_status='publish'";
$contpaisesp = $wpdb->get_var($querypaisesp);  
$cont_paisesp1=devolver_contenido($patronesp, $contpaisesp);

$querydestesp = " SELECT post_content FROM wp_posts where post_name='destino' and post_status='publish'";
$contdestesp = $wpdb->get_var($querydestesp);  
$cont_destesp1=devolver_contenido($patronesp, $contdestesp);

$queryprodesp = " SELECT post_content FROM wp_posts where post_name='producto' and post_status='publish'";
$contprodesp = $wpdb->get_var($queryprodesp);  
$cont_prodesp1=devolver_contenido($patronesp, $contprodesp);

?>

<h2><a hreflang="es" href="/pais-invitado/"><?php  echo $title_paisesp1;?></a></h2>
</div>
<div class="content-image-block">
<img class="alignnone size-full wp-image-67" src="/wp-content/uploads/2015/10/canada.png" alt="torre" width="40" height="57" /></div>
<p style="height: auto; margin-top:137px;"><?php  echo $cont_paisesp1;?></p>
<a hreflang="es" href="/pais-invitado/" class="link-more"><img class="alignnone size-full wp-image-67" src="/wp-content/uploads/2015/10/arrow-cuadros.png" alt="arrow" width="50" height="57" /></a></div>
<div class="span4 block-squad" style="height: 100px;">
<div class="header-block">
<h3 style="height: 18px;">Destino</h3>
<h2><a hreflang="es" href="/destino/"><?php  echo $title_destesp1;?></a></h2>
</div>
<div class="content-image-block"><img class="alignnone size-full wp-image-67" src="/wp-content/uploads/2015/10/morro.png" alt="flamenco" width="40" height="57" /></div>
<p style="height: auto; margin-top:137px;"><?php  echo $cont_destesp1;?> </p>
<a hreflang="es" href="/destino/" class="link-more"><img class="alignnone size-full wp-image-67" src="/wp-content/uploads/2015/10/arrow-cuadros.png" alt="arrow" width="50" height="57" /></a></div>
<div class="span4 block-squad"  style="height: 100px;">
<div class="header-block">
<h3 style="height: 18px;">Producto</h3>
<h2><a hreflang="es" href="/producto/"><?php  echo $title_prodesp1;?></a></h2>
</div>
<div class="content-image-block"><img class="alignnone size-full wp-image-67" src="/wp-content/uploads/2015/10/cultura.png" alt="velero" width="40" height="57" /></div>
<p style="height: auto; margin-top:137px;"><?php  echo $cont_prodesp1;?></p>
<a hreflang="es" href="/producto/" class="link-more"><img class="alignnone size-full wp-image-67" src="/wp-content/uploads/2015/10/arrow-cuadros.png" alt="arrow" width="50" height="57" /></a></div>
</div>
<div class="border-blocks-squads">&nbsp;</div>
</div>
		</div>
		</div>
		</div>
<?php
	}
?>
<?php
	if($idioma == "en"){
	?>
                <div class="art-postcontent clearfix">
			<div class="textwidget">
			<div class="custom">
						<div class="custom art-post">
<div class="border-blocks-squads">&nbsp;</div>
<div class="row-fluid blocks-squads">
<div class="span4 block-squad"  style="height: 100px;">
<div class="header-block">
<h3 style="height: 18px;">Guest Country</h3>

<?php
// obtencion de los titulos de los resumenes
$patroneng=':en]'; 
global $wpdb;
$querypaiseng = " SELECT post_title FROM wp_posts where post_name='pais-invitado' and post_status='publish'";
$titlepaiseng = $wpdb->get_var($querypaiseng);  
$title_paiseng1=devolver_titulo($patroneng, $titlepaiseng);

$querydesteng = " SELECT post_title FROM wp_posts where post_name='destino' and post_status='publish'";
$titledesteng = $wpdb->get_var($querydesteng);    
$title_desteng1=devolver_titulo($patroneng, $titledesteng);

$queryprodeng = " SELECT post_title FROM wp_posts where post_name='producto' and post_status='publish'";
$titleprodeng = $wpdb->get_var($queryprodeng);    
$title_prodeng1=devolver_titulo($patroneng, $titleprodeng);

// obtencion del contenido de los resumenes
$querypaiseng = " SELECT post_content FROM wp_posts where post_name='pais-invitado' and post_status='publish'";
$contpaiseng = $wpdb->get_var($querypaiseng);  
$cont_paiseng1=devolver_contenido($patroneng, $contpaiseng);

$querydesteng = " SELECT post_content FROM wp_posts where post_name='destino' and post_status='publish'";
$contdesteng = $wpdb->get_var($querydesteng);  
$cont_desteng1=devolver_contenido($patroneng, $contdesteng);

$queryprodeng = " SELECT post_content FROM wp_posts where post_name='producto' and post_status='publish'";
$contprodeng = $wpdb->get_var($queryprodeng);  
$cont_prodeng1=devolver_contenido($patroneng, $contprodeng);
?>

<h2><a hreflang="es" href="/pais-invitado/"><?php  echo $title_paiseng1;?></a></h2>
</div>
<div class="content-image-block">
<img class="alignnone size-full wp-image-67" src="/wp-content/uploads/2015/10/canada.png" alt="torre" width="40" height="57" /></div>
<p style="height: auto; margin-top:137px;"><?php  echo $cont_paiseng1;?></p>
<a hreflang="es" href="/pais-invitado/" class="link-more"><img class="alignnone size-full wp-image-67" src="/wp-content/uploads/2015/10/arrow-cuadros.png" alt="arrow" width="50" height="57" /></a></div>
<div class="span4 block-squad" style="height: 100px;">
<div class="header-block">
<h3 style="height: 18px;">Destination</h3>
<h2><a hreflang="es" href="/destino/"><?php  echo $title_desteng1;?></a></h2>
</div>
<div class="content-image-block"><img class="alignnone size-full wp-image-67" src="/wp-content/uploads/2015/10/morro.png" alt="flamenco" width="40" height="57" /></div>
<p style="height: auto; margin-top:137px;"><?php  echo $cont_desteng1;?></p>
<a hreflang="es" href="/destino/" class="link-more"><img class="alignnone size-full wp-image-67" src="/wp-content/uploads/2015/10/arrow-cuadros.png" alt="arrow" width="50" height="57" /></a></div>
<div class="span4 block-squad"  style="height: 100px;">
<div class="header-block">
<h3 style="height: 18px;">Product</h3>
<h2><a hreflang="es" href="/producto/"><?php  echo $title_prodeng1;?></a></h2>
</div>
<div class="content-image-block"><img class="alignnone size-full wp-image-67" src="/wp-content/uploads/2015/10/cultura.png" alt="velero" width="40" height="57" /></div>
<p style="height: auto; margin-top:137px;"><?php  echo $cont_prodeng1;?> </p>
<a hreflang="es" href="/producto/" class="link-more"><img class="alignnone size-full wp-image-67" src="/wp-content/uploads/2015/10/arrow-cuadros.png" alt="arrow" width="50" height="57" /></a></div>
</div>
<div class="border-blocks-squads">&nbsp;</div>
</div>
		</div>
		</div>
		</div>
<?php
	}
?>			
			



<?php
	if($idioma == "fr"){
	?>
                <div class="art-postcontent clearfix">
			<div class="textwidget">
			<div class="custom">
						<div class="custom art-post">
<div class="border-blocks-squads">&nbsp;</div>
<div class="row-fluid blocks-squads">
<div class="span4 block-squad"  style="height: 100px;">
<div class="header-block">
<h3 style="height: 18px;">Pays Invité</h3>

<?php
// obtencion de los titulos de los resumenes
$patronfr=':fr]'; 
global $wpdb;
$querypaisfr = " SELECT post_title FROM wp_posts where post_name='pais-invitado' and post_status='publish'";
$titlepaisfr = $wpdb->get_var($querypaisfr); 
$title_paisfr1=devolver_titulo($patronfr, $titlepaisfr);

$querydestfr = " SELECT post_title FROM wp_posts where post_name='destino' and post_status='publish'";
$titledestfr = $wpdb->get_var($querydestfr);    
$title_destfr1=devolver_titulo($patronfr, $titledestfr);

$queryprodfr = " SELECT post_title FROM wp_posts where post_name='producto' and post_status='publish'";
$titleprodfr = $wpdb->get_var($queryprodfr);    
$title_prodfr1=devolver_titulo($patronfr, $titleprodfr);

// obtencion del contenido de los resumenes
$querypaisfr = " SELECT post_content FROM wp_posts where post_name='pais-invitado' and post_status='publish'";
$contpaisfr = $wpdb->get_var($querypaisfr);  
$cont_paisfr1=devolver_contenido($patronfr, $contpaisfr);

$querydestfr = " SELECT post_content FROM wp_posts where post_name='destino' and post_status='publish'";
$contdestfr = $wpdb->get_var($querydestfr);  
$cont_destfr1=devolver_contenido($patronfr, $contdestfr);

$queryprodfr = " SELECT post_content FROM wp_posts where post_name='producto' and post_status='publish'";
$contprodfr = $wpdb->get_var($queryprodfr);  
$cont_prodfr1=devolver_contenido($patronfr, $contprodfr);
?>


<h2><a hreflang="es" href="/pais-invitado/"><?php  echo $title_paisfr1;?></a></h2>
</div>
<div class="content-image-block">
<img class="alignnone size-full wp-image-67" src="/wp-content/uploads/2015/10/canada.png" alt="torre" width="40" height="57" /></div>
<p style="height: auto; margin-top:137px;"><?php  echo $cont_paisfr1;?></p>
<a hreflang="es" href="/pais-invitado/" class="link-more"><img class="alignnone size-full wp-image-67" src="/wp-content/uploads/2015/10/arrow-cuadros.png" alt="arrow" width="50" height="57" /></a></div>
<div class="span4 block-squad" style="height: 100px;">
<div class="header-block">
<h3 style="height: 18px;">Destination</h3>
<h2><a hreflang="es" href="/destino/"><?php  echo $title_destfr1;?></a></h2>
</div>
<div class="content-image-block"><img class="alignnone size-full wp-image-67" src="/wp-content/uploads/2015/10/morro.png" alt="flamenco" width="40" height="57" /></div>
<p style="height: auto; margin-top:137px;"><?php  echo $cont_destfr1;?></p>
<a hreflang="es" href="/destino/" class="link-more"><img class="alignnone size-full wp-image-67" src="/wp-content/uploads/2015/10/arrow-cuadros.png" alt="arrow" width="50" height="57" /></a></div>
<div class="span4 block-squad"  style="height: 100px;">
<div class="header-block">
<h3 style="height: 18px;">Produit</h3>
<h2><a hreflang="es" href="/producto/"><?php  echo $title_prodfr1;?></a></h2>
</div>
<div class="content-image-block"><img class="alignnone size-full wp-image-67" src="/wp-content/uploads/2015/10/cultura.png" alt="velero" width="40" height="57" /></div>
<p style="height: auto; margin-top:137px;"><?php  echo $cont_prodfr1;?> </p>
<a hreflang="es" href="/producto/" class="link-more"><img class="alignnone size-full wp-image-67" src="/wp-content/uploads/2015/10/arrow-cuadros.png" alt="arrow" width="50" height="57" /></a></div>
</div>
<div class="border-blocks-squads">&nbsp;</div>
</div>
		</div>
		</div>
		</div>
<?php
	}
?>	




	

<?php
		$uri = $_SERVER['REQUEST_URI'];
		
		if(strpos($uri, "/en/") !== FALSE){
			$idioma = "en";
		}
    else if(strpos($uri, "/fr/") !== FALSE){
      $idioma = "fr";
    }
    		else{
			$idioma = "es";
		}
	?>



<!-- Seccion de noticias-->
<?php if ( is_front_page() ) { ?>	
<div class="span8">
                                <!-- Begin Content -->                    
                                <div class="article-custom-head click-me">
    <?php
	if($idioma == "es"){
	?>
<a href="/es/noticias-resumen">Noticias</a>

<?php
	}
?>

<?php
	if($idioma == "en"){
	?>
<a href="/e/noticias-resumen">News</a> 

<?php
	}
?>

<?php
	if($idioma == "fr"){
	?>
<a href="/fr/noticias-resumen">Nouvelles</a> 

<?php
	}
?>

    <span class="opened"></span>
</div>
<div style="display: block;" class="article-custom-content-footer">
    <div class="article-custom-content">
        <div style="overflow: hidden;" id="scroller" class="content mCustomScrollbar _mCS_1"><div class="mCustomScrollBox mCS-dark" id="mCSB_1" style="position: relative; height: 100%; overflow: hidden; max-width: 100%; max-height: 210px;"><div class="mCSB_container mCS_no_scrollbar" style="position: relative; top: 0px;">


			
	<?php if(function_exists("get_smooth_slider_recent")){get_smooth_slider_recent();}?>
				



        </div><div class="mCSB_scrollTools" style="position: absolute; display: none;"><div class="mCSB_draggerContainer"><div class="mCSB_dragger" style="position: absolute; top: 0px;" oncontextmenu="return false;"><div class="mCSB_dragger_bar" style="position:relative;"></div></div><div class="mCSB_draggerRail"></div></div></div></div></div>
    </div>
</div>

<script type="text/javascript" language="javascript">
    (function ($) {

        $(document).ready(function () {
            $('.click-me').on("click", function () {

                $obj = $(".article-custom-head span");
                $('.mod-evento-content').slideToggle();

                if ($obj.attr('class') == 'opened') {
                    $obj.removeClass().parent().parent().find('.article-custom-content-footer').slideToggle();
                    $obj.parent().find('strong').css('display', 'block');
                } else {
                    $obj.addClass('opened').parent().parent().find('.article-custom-content-footer').slideToggle();
                    $obj.parent().find('strong').css('display', 'none');
                    $("#scroller").mCustomScrollbar("update");
                }
                
            });
        });

  
    })(jQuery);
</script>

                                <!-- End Content -->
                            </div>
<?php } ?>
<!-- Seccion de noticias-->



<!-- Seccion de video-->
<?php if ( is_front_page() ) { ?>	
<div class="span4">                                
                                <div class="mod-evento-head click-me">
    <?php
	if($idioma == "es"){
	?>
<a href="/es/galeria/videos">En Vivo</a>

<?php
	}
?>

<?php
	if($idioma == "en"){
	?>
<a href="/en/galeria/videos">Live</a>

<?php
	}
?>

<?php
	if($idioma == "fr"){
	?>
<a href="/fr/galeria/videos">Vivre</a>

<?php
	}
?>

    <span class="opened"></span>
</div>

<div style="display: block;" class="mod-evento-content">

<?php 

echo do_shortcode('[chr-youtube-gallery order="DESC" orderby="date" posts="1" category="video-del-inicio"]'); 

?>

</div>
                            </div>
 <?php } ?>
<!-- Seccion de video-->


			
<?php get_footer(); ?>
