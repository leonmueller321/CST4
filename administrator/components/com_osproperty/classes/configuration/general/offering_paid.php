<?php 
/*------------------------------------------------------------------------
# offering_paid.php - Ossolution Property
# ------------------------------------------------------------------------
# author    Dang Thuc Dam
# copyright Copyright (C) 2010 joomdonation.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.joomdonation.com
# Technical Support:  Forum - http://www.joomdonation.com/forum.html
*/
// no direct access
defined('_JEXEC') or die;

?>
<fieldset>
	<legend><?php echo JTextOs::_('Offering Paid Listings')?></legend>
	<table width="100%" class="admintable">
		<tr>
			<td class="key" nowrap="nowrap">
				<span class="editlinktip hasTip" title="<?php echo JTextOs::_( 'Featured Upgrade amount' );?>::<?php echo JTextOs::_('The cost of upgrading a free property listing to a paid listing/ or featured upgrade.'); ?>">
					<label for="configuration[general_default_categories_order]">
					    <?php echo JTextOs::_( 'Featured Upgrade amount' ).':'; ?>
					</label>
				</span>
			</td>
			<td>
				<input type="text" class="input-mini" size="10" name="configuration[general_featured_upgrade_amount]" value="<?php echo isset($configs['general_featured_upgrade_amount'])? $configs['general_featured_upgrade_amount']:''; ?>">
			</td>
		</tr>
		<tr>
			<td class="key" nowrap="nowrap">
				<span class="editlinktip hasTip" title="<?php echo JTextOs::_( 'Paypal Testmode' );?>::<?php echo JTextOs::_('PAYPAL_TEST_MODE_EXPLAIN'); ?>">
					<label for="configuration[general_default_categories_order]">
					    <?php echo JTextOs::_( 'Paypal Testmode' ).':'; ?>
					 </label>
				</span>
			</td>
			<td>
				<?php
					$option_paypal_testmode = array();
					$option_paypal_testmode[] = JHtml::_('select.option',0,JTextOs::_('Testmode'));
					$option_paypal_testmode[] = JHtml::_('select.option',1,JTextOs::_('Live mode'));
					if (!isset($configs['general_paypal_testmode'])){
						$configs['general_paypal_testmode'] = 0;
					}
					echo JHtml::_('select.radiolist',$option_paypal_testmode,'configuration[general_paypal_testmode]','','value','text',$configs['general_paypal_testmode']) ;
				?>
			</td>
		</tr>
		<tr>
			<td class="key" nowrap="nowrap">
				<span class="editlinktip hasTip" title="<?php echo JTextOs::_( 'Paypal account' );?>::<?php echo JTextOs::_('PAYPAL_ACCOUNT_EXPLAIN'); ?>">
					<label for="configuration[general_default_properties_order]">
					    <?php echo JTextOs::_( 'Paypal account' ).':'; ?>
					</label>
				</span>
			</td>
			<td>
				<input type="text" size="40" name="configuration[general_paypal_account]" value="<?php echo isset($configs['general_paypal_account'])? $configs['general_paypal_account']:''; ?>">
			</td>
		</tr>
	</table>
</fieldset>