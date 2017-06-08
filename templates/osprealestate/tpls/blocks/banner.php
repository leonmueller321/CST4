<?php
/**
 * @package   T3 Blank
 * @copyright Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license   GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>

<?php if ($this->countModules('banner')) : ?>
	<!-- banner -->
	<div class="t3-banner<?php $this->_c('banner') ?>">
		<div class="container">
			<jdoc:include type="modules" name="<?php $this->_p('banner') ?>" style="T3xhtml" />
		</div>
	</div>
	<!-- //banner -->
<?php endif ?>
