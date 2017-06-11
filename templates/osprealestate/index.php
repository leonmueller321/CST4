<?php
/** 
 *------------------------------------------------------------------------------
 * @package       T3 Framework for Joomla!
 *------------------------------------------------------------------------------
 * @copyright     Copyright (C) 2004-2013 JoomlArt.com. All Rights Reserved.
 * @license       GNU General Public License version 2 or later; see LICENSE.txt
 * @authors       JoomlArt, JoomlaBamboo, (contribute to this project at github 
 *                & Google group to become co-author)
 * @Google group: https://groups.google.com/forum/#!forum/t3fw
 * @Link:         http://t3-framework.org 
 *------------------------------------------------------------------------------
 */
 
// no direct access
defined('_JEXEC') or die;

$doc = JFactory::getDocument(); // chances are this line is already in the file - don't add it twice
$doc->addScript('templates/' . $this->template . '/js/main.js');
$doc->addStyleSheet('templates/' . $this->template . '/css/toast.css');
$doc->addStyleSheet('templates/' . $this->template . '/css/liststyle.css');

//check if t3 plugin is existed
if (!defined('T3')) {
	if (JError::$legacy) {
		JError::setErrorHandling(E_ERROR, 'die');
		JError::raiseError(500, JText::_('T3_MISSING_T3_PLUGIN'));
		exit;
	} else {
		throw new Exception(JText::_('T3_MISSING_T3_PLUGIN'), 500);
	}
}

$t3app = T3::getApp($this);
// test css
$app    = JFactory::getApplication();
$input  = $app->input;
$t3app->setParam('theme', $input->get('theme',$t3app->getParam('theme','')));

// get configured layout
//$layout = $t3app->getLayout();
$layout = $input->get('mainlayout',$t3app->getLayout());

$t3app->loadLayout($layout);