<?php
/*------------------------------------------------------------------------
# fieldgroup.php - Ossolution Property
# ------------------------------------------------------------------------
# author    Dang Thuc Dam
# copyright Copyright (C) 2010 joomdonation.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.joomdonation.com
# Technical Support:  Forum - http://www.joomdonation.com/forum.html
*/

// No direct access.
defined('_JEXEC') or die;

/**
 * Field group table
 *
 * @package		Joomla.Administrator
 * @subpackage	com_osproperty
 * @since		1.5
 */
class OspropertyTableFieldgroup extends JTable
{
	var $id = null;
	var $group_name = null;
	var $access = null;
	var $ordering = null;
	var $published = null;
	/**
	 * Constructor
	 *
	 * @since	1.5
	 */
	
	function __construct(&$_db)
	{
		parent::__construct('#__osrs_fieldgroups', 'id', $_db);
	}
}