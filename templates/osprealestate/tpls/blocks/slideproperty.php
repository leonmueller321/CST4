<?php
/**
 * @package   T3 Blank
 * @copyright Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license   GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>

<?php if ($this->countModules('slideproperty')) : ?>
	<!-- NAV HELPER -->
	<nav class="t3-slideproperty <?php $this->_c('slideproperty') ?>">
		<div class="container">
			<jdoc:include type="modules" name="<?php $this->_p('slideproperty') ?>" style="T3Xhtml" />
		</div>
	</nav>
	<!-- //NAV HELPER -->
<?php endif ?>
