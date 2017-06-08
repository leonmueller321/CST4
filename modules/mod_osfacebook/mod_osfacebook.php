<?php 
/* 
* @author Dang Thuc Dam
* Email : damdt@joomservices.com
* URL : www.joomdonation.com
* Description : This allows you to like and share on many networks.
* Copyright (c) 2013 Ossolution
* License GNU GPL
***/

/// no direct access 

defined('_JEXEC') or die('Restricted access');

error_reporting(0);

$document =& JFactory::getDocument();
$mod = JURI::base() . 'modules/mod_osfacebook/';
$document->addStyleSheet(JURI::base() . 'modules/mod_osfacebook/style.css');

$url = urlencode("http://".$_SERVER['HTTP_HOST'] ). getenv('REQUEST_URI');
$title = urlencode($document->getTitle());
$url = urldecode($url);
$title = urldecode($title);


	$fbflag = '';


	$moduleclass_sfx    	= $params->get('moduleclass_sfx','');
	$credits      		= $params->get('credits','no');

    	$fbcss		= $params->get('css','');

	$fboutput		= $params->get('fboutput');
	$fbappid		= $params->get('fbappid');
	$fburl		= $params->get('fburl');
	$fbheight		= $params->get('fbheight');
	$fbwidth		= $params->get('fbwidth');
	$fbtheme		= $params->get('fbtheme');
	$fbfaces		= $params->get('fbfaces');
	$fbbordercol	= $params->get('fbbordercol');
	$bkdropborder	= $params->get('bkdropborder');
	$bkdropborwidth	= $params->get('bkdropborwidth');
	$fbbackcol		= $params->get('fbbackcol');
	$fbstream		= $params->get('fbstream');
	$fbheader		= $params->get('fbheader');
	$fbforcewall	= $params->get('fbforcewall');
	$support		= $params->get('support');
	$fbconnections	= $params->get('fbconnections');
	$fblocale		= $params->get('fblocale');
	$fbfont		= $params->get('fbfont');
	$fbjembed		= $params->get('fbjembed');
	$fbheadheight	= $params->get('fbheadheight');
	$fblogoheight	= $params->get('fblogoheight');
	$fblogowidth	= $params->get('fblogowidth');
	$fblogoalign	= $params->get('fblogoalign');
	$fblogourl		= $params->get('fblogourl');
	$fbheadcol		= $params->get('fbheadcol');

	global $fbflag;
	if((($fbjembed == 'everytime') || ($fbjembed == 'once')) && ($fbflag != 'yes')) {
		if($fbjembed == 'once'){
			$fbflag = 'yes';
		}else{
			$fbflag = 'no';	
			}
		$fbjs = '<script> (function(d, s, id) {var js, fjs = d.getElementsByTagName(s)[0]; if (d.getElementById(id)) {return}; js = d.createElement(s); js.id = id; js.async = true; js.src = "//connect.facebook.net/'.$fblocale.'/all.js#xfbml=1&appId='.$fbappid.'"; fjs.parentNode.insertBefore(js, fjs); }(document, "script", "facebook-jssdk")); </script>';
	}else{
		$fbjs = '';
	}



$fbheight2 = (intval($fbheight) - 23);	

if(($fbheader == 'yes') || ($fbheader == 'both')){
	$headtf = 'true';
		}else{
	$headtf = 'false';
	}


if($fboutput == "iframe") {
	$fburl2 = "//www.facebook.com/plugins/likebox.php?locale=" . $fblocale . "&amp;href=" . $fburl . "&amp;width=" . $fbwidth . "&amp;height=" . $fbheight . "&amp;connections=" .$fbconnections . "&amp;colorscheme=" . $fbtheme . "&amp;show_faces=" . $fbfaces . "&amp;border_color=" . $fbbordercol = "&amp;stream=" . $fbstream . "&amp;header=" . $headtf . "&amp;appId=" . $fbappid . "&amp;font=" . $fbfont . "&amp;force_wall=" .$fbforcewall;
			$posv = intval($fbheight) + intval($bkdropborwidth);
			$posh = intval($bkdropborwidth);

			if($fbheader == 'custom'){
				$posv2 = intval($fbheight) + intval($bkdropborwidth) + intval($fbheadheight);
				$fbnewheight = intval($fbheight) + intval($fbheadheight);
				echo '<div style="border-style: '.$bkdropborder.'; border-width: '.$bkdropborwidth.'px; border-color: '.$fbbordercol.'; display:block; width:'.$fbwidth.'px; height:'.$fbnewheight.'px; background-color: '.$fbbackcol.';'. $fbcss .'"></div>';
				echo '<div style="text-align: '.$fblogoalign.'; position: relative; top: -'.$posv2.'px; left: '.$posh.'px; display:block; width:'.$fbwidth.'px; height:'.$fbheadheight.'px; background-color: '.$fbheadcol.';"><img src="'.$fblogourl.'" height="'.$fblogoheight.'" width="'.$fblogowidth.'" /></div>';
				echo '<div style="position: relative; margin-top: -'.$fbheadheight.'px; left: '.$posh.'px;"></div>';
			}else{
				$posv2 = intval($fbheight) + intval($bkdropborwidth);
				$fbnewheight = intval($fbheight);

				echo '<div style="border-style: '.$bkdropborder.'; border-width: '.$bkdropborwidth.'px; border-color: '.$fbbordercol.'; display:block; width:'.$fbwidth.'px; height:'.$fbnewheight.'px; background-color: '.$fbbackcol.';'. $fbcss .'"></div>';

				echo '<div style="position: relative; top: -'.$posv2.'px; left: '.$posh.'px; "><img src="'.$fblogourl.'" height="0" width="0" /></div>';
				echo '<div style="position: relative; margin-top: -0px; left: '.$posh.'px;"></div>';
			}
			
		echo '<div style="position: relative; margin-top: -'.$posv2.'px; left: '.$posh.'px;"><iframe src="'.$fburl2.'" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:'.$fbwidth.'px; height:'.$fbheight2.'px;" allowTransparency="true" style="z-index:1001;'.$fbcss.'" ></iframe></div>';

		}elseif($fboutput == 'html5') {
			$posv = intval($fbheight) + intval($bkdropborwidth);
			$posh = intval($bkdropborwidth);
			echo '<div id="fb-root"></div>' . $fbjs;
			if($fbheader == 'custom'){
				$posv2 = intval($fbheight) + intval($bkdropborwidth) + intval($fbheadheight);
				$fbnewheight = intval($fbheight) + intval($fbheadheight);
				echo '<div style="border-style: '.$bkdropborder.'; border-width: '.$bkdropborwidth.'px; border-color: '.$fbbordercol.'; display:block; width:'.$fbwidth.'px; height:'.$fbnewheight.'px; background-color: '.$fbbackcol.';'. $fbcss .'"></div>';
				echo '<div style="text-align: '.$fblogoalign.'; position: relative; top: -'.$posv2.'px; left: '.$posh.'px; display:block; width:'.$fbwidth.'px; height:'.$fbheadheight.'px; background-color: '.$fbheadcol.';"><img src="'.$fblogourl.'" height="'.$fblogoheight.'" width="'.$fblogowidth.'" /></div>';
				echo '<div style="position: relative; margin-top: -'.$fblogoheight.'px; left: '.$posh.'px;"></div>';
			}else{
				echo '<div style="border-style: '.$bkdropborder.'; border-width: '.$bkdropborwidth.'px; border-color: '.$fbbordercol.'; display:block; width:'.$fbwidth.'px; height:'.$fbheight.'px; background-color: '.$fbbackcol.';'. $fbcss .'"></div>';
			}
			echo '<div style="position: relative; top: -'.$posv.'px; left: '.$posh.'px; '. $fbcss .'" class="fb-like-box" data-href="'.$fburl.'" data-width="'.$fbwidth.'" data-height="'.$fbheight.'" data-show-faces="'.$fbfaces.'" data-stream="'.$fbstream.'" data-header="'.$headtf.'" data-colorscheme="'.$fbtheme.'" data-force_wall="'.$fbforcewall.'" data-connections="'.$fbconnections.'" data-border-color="'.$fbbordercol.'"></div>';
			echo '<div style="position: relative; margin-top: -'.$posv.'px;"></div>';
		}else{
			$posv = intval($fbheight) + intval($bkdropborwidth);
			$posh = intval($bkdropborwidth);
			echo '<div id="fb-root"></div>' . $fbjs;
			if($fbheader == 'custom'){
				$posv2 = intval($fbheight) + intval($bkdropborwidth) + intval($fbheadheight);
				$fbnewheight = intval($fbheight) + intval($fbheadheight);
				echo '<div style="border-style: '.$bkdropborder.'; border-width: '.$bkdropborwidth.'px; border-color: '.$fbbordercol.'; display:block; width:'.$fbwidth.'px; height:'.$fbnewheight.'px; background-color: '.$fbbackcol.';'. $fbcss .'"></div>';
				echo '<div style="text-align: '.$fblogoalign.'; position: relative; top: -'.$posv2.'px; left: '.$posh.'px; display:block; width:'.$fbwidth.'px; height:'.$fbheadheight.'px; background-color: '.$fbheadcol.';"><img src="'.$fblogourl.'" height="'.$fblogoheight.'" width="'.$fblogowidth.'" /></div>';
				$posv = $posv2;
			}else{
				echo '<div style="border-style: '.$bkdropborder.'; border-width: '.$bkdropborwidth.'px; border-color: '.$fbbordercol.'; display:block; width:'.$fbwidth.'px; height:'.$fbheight.'px; background-color: '.$fbbackcol.';'. $fbcss .'"></div>';
			}
			echo '<div style="position: relative; margin-top: -'.$posv.'px; left: '.$posh.'px; '. $fbcss .' width: '.$fbwidth.'px; height :'.$fbheight.'px;"><fb:like-box href="'.
$fburl.'" width="'.$fbwidth.'" height="'.$fbheight.'" show_faces="'.$fbfaces.'" stream="'.$fbstream.'" header="'.$headtf.'" colorscheme="'.$fbtheme.'" force_wall="'.$fbforcewall.'" connections="'.$fbconnections.'" border_color="'.$fbbordercol.'"></fb:like></div>';
	}



echo '<div style="clear: both;"></div>';


echo '<div style="margin-left: 10px; text-align: center; font-size: 10px; color: #999999;">';

		 echo '<a style="color:#999999;"
		 href="http://www.joomdonation.com/"
		 title="http://www.joomdonation.com/" target="_blank">Ossolution</a>';

echo '</div>';

?>