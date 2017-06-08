<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_search
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
require_once __DIR__ . '/helper.php';
$document = JFactory::getDocument();
$document->addStyleSheet('modules/mod_oschangetemplatestyle/asset/cpanel.css');
$document->addScript('modules/mod_oschangetemplatestyle/asset/cpanel.js');
$ThemOSptravel = new ThemeOSptravelHelper($params);
require JModuleHelper::getLayoutPath('mod_oschangetemplatestyle', $params->get('layout', 'default'));
