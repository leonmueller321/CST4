<?php
/**
 * @package   T3 Blank
 * @copyright Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license   GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;



?>

<!-- HEADER -->
<header id="t3-header">
	<?php if ($this->getParam('addon_offcanvas_enable')) : ?>
				<?php $this->loadBlock ('off-canvas') ?>
			<?php endif ?>
	<div class="container">
	<div class="row">
			<div class="col-xs-12 col-sm-12">
				<?php if ($this->countModules('head-social')) : ?>
					<!-- HEAD social -->
					<div class="head-social col-xs-12 col-sm-5 <?php $this->_c('head-social') ?>">
						<jdoc:include type="modules" name="<?php $this->_p('head-social') ?>" style="raw" />
					</div>
					<!-- //HEAD social -->
				<?php endif ?>
                
				<?php if ($this->countModules('head-contact')) : ?>
					<!-- head-contac -->
					<div class="head-contac col-xs-12 col-sm-2 <?php $this->_c('head-contact') ?>">
						<jdoc:include type="modules" name="<?php $this->_p('head-contact') ?>" style="raw" />
					</div>
					<!-- //head-contac -->
				<?php endif ?>
                <?php if ($this->countModules('head-login')) : ?>
					<!-- head-login -->
					<div class="head-login col-xs-12 col-sm-3 <?php $this->_c('head-login') ?>">
						<jdoc:include type="modules" name="<?php $this->_p('head-login') ?>" style="raw" />
					</div>
					<!-- //head-login-->
				<?php endif ?>
                <?php if ($this->countModules('head-search')) : ?>
					<!-- head-search -->
					<div class="head-search col-xs-12 col-sm-2 <?php $this->_c('head-search') ?>">
						<jdoc:include type="modules" name="<?php $this->_p('head-search') ?>" style="raw" />
					</div>
					<!-- //head-search -->
				<?php endif ?>
			</div>
	</div>
    </div>
</header>
<!-- //HEADER -->
