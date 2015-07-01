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
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Rheinschafe.RsEtracker',
	'code',
	array('Etracker' => 'code')
);
