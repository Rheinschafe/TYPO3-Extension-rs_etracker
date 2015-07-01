<?php

/*
 * This file is part of the Rheinschafe/Etracker project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

/**
 * Autoloading file of the rs_etracker package.
 *
 * @package    rs_etracker
 */

$extensionPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('rs_etracker');
return array(
	'etracker' => $extensionPath . 'Resources/PHP/Etracker/etracker.inc.php'
);
