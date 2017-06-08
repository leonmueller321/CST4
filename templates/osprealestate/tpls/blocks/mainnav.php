<?php
/**
 * @package   T3 Blank
 * @copyright Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license   GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
// get params
$sitename  = $this->params->get('sitename');
$slogan    = $this->params->get('slogan', '');
$logotype  = $this->params->get('logotype', 'text');
$logoimage = $logotype == 'image' ? $this->params->get('logoimage', 'templates/' . T3_TEMPLATE . '/images/logo.png') : '';

if (!$sitename) {
	$sitename = JFactory::getConfig()->get('sitename');
}
$logosize = 'col-sm-4';
if ($this->getParam('navigation_collapse_enable')) {
	$logosize = 'col-xs-12';
}

?>

<nav id="t3-mainnav" class="wrap navbar navbar-default t3-mainnav">
				
	<div class="container">
    	<!-- LOGO -->
		<div class="<?php echo $logosize ?> col-sm-12  col-md-3 logo">
			<div class="logo-<?php echo $logotype ?>">
				<a href="<?php echo JURI::base(true) ?>" title="<?php echo strip_tags($sitename) ?>">
					<?php if($logotype == 'image'): ?>
						<img class="logo-img" src="<?php echo JURI::base(true) . '/' . $logoimage ?>" alt="<?php echo strip_tags($sitename) ?>" />
					<?php endif ?>
					<span><?php echo $sitename ?></span>
				</a>
				<small class="site-slogan"><?php echo $slogan ?></small>
			</div>
		</div>
		<!-- //LOGO -->
		<!-- MAIN NAVIGATION -->
		<div class="mainmenu">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
            
                <?php if ($this->getParam('navigation_collapse_enable', 1) && $this->getParam('responsive', 1)) : ?>
				<?php $this->addScript(T3_URL.'/js/nav-collapse.js'); ?>
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".t3-navbar-collapse">
					<i class="fa fa-bars"></i>
				</button>
			<?php endif ?>

			
    
                
    
            </div>
    
            <?php if ($this->getParam('navigation_collapse_enable')) : ?>
                <div class="t3-navbar-collapse navbar-collapse collapse"></div>
            <?php endif ?>
    
            <div class="t3-navbar navbar-collapse collapse">
                <jdoc:include type="<?php echo $this->getParam('navigation_type', 'megamenu') ?>" name="<?php echo $this->getParam('mm_type', 'mainmenu') ?>" />
            </div>
       </div>
	</div>
</nav>
<!-- //MAIN NAVIGATION -->
