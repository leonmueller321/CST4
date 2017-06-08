<?php
/**
 * @package   T3 Blank
 * @copyright Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license   GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;



?>

<!-- slideshow -->
<header id="t3-slideshow">
	<div class="slideshow-container">

				<?php if ($this->countModules('slideshow')) : ?>
					<!-- slideshow-->
					<div class="slideshow-slide <?php $this->_c('slideshow') ?>">
						<jdoc:include type="modules" name="<?php $this->_p('slideshow') ?>" style="raw" />
					</div>
					<!-- //slideshow -->
				<?php endif ?>
                <?php if ($this->countModules('advance-search')) : ?>
					<!-- advance-search-->
					<div class="advance-search<?php $this->_c('advance-search') ?>">
						<jdoc:include type="modules" name="<?php $this->_p('advance-search') ?>" style="raw" />
					</div>
					<!-- //advance-search -->
				<?php endif ?>
    </div>
</header>
<!-- //slideshow -->
