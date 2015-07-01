<?php

/*
 * This file is part of the Rheinschafe/Etracker project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

/**
 * Configuration of the rs_etracker package.
 *
 * @package    rs_etracker
 */

// access restriction
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

// configure etracker code plugin
$extbaseEtrackerCodePluginConfiguration = array(
	'controllers' => array(
		'Etracker' => array(
			'actions' => array(
				'code'
			)
		)
	)
);
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['extbase']['extensions']['RsEtracker']['plugins']['Code'] = $extbaseEtrackerCodePluginConfiguration;
unset($extbaseEtrackerCodePluginConfiguration);
