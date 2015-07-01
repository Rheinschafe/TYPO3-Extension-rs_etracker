<?php

namespace Rheinschafe\RsEtracker\Controller;

/*
 * This file is part of the Rheinschafe/Etracker project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use Rheinschafe\RsEtracker\Utility\Etracker;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

/**
 * Etracker controller.
 *
 * @package    rs_etracker
 * @subpackage Controller
 * @author     Daniel Hürtgen <huertgen@rheinschafe.de>
 */
class EtrackerController extends ActionController {

	/**
	 * @var \TYPO3\CMS\Extbase\Service\TypoScriptService
	 * @inject
	 */
	protected $typoScriptService;

	/**
	 * Etracker code action.
	 *
	 * @return string
	 */
	public function codeAction() {
		if (empty($this->settings['securityCode'])) {
			return '';
		}

		$cObject = $this->configurationManager->getContentObject();

		$params = array();
		$securityCode = trim($this->settings['securityCode']);

		// area
		$area = '';
		if (!empty($this->settings['area'])) {
			$area = trim($this->settings['area']);
		}
		if (!empty($this->settings['areaStdWrap'])) {
			$area = $cObject->stdWrap($area, $this->typoScriptService->convertPlainArrayToTypoScriptArray($this->settings['areaStdWrap']));
		}
		if (!empty($area)) {
			$params['et_areas'] = $area;
		}

		// page name
		if (!empty($this->settings['pageName'])) {
			$pageName = $this->settings['pageName'];
		} else {
			$pageName = !empty($this->getTyposcriptFrontendController()->altPageTitle) ? $this->getTyposcriptFrontendController()->altPageTitle : $this->getTyposcriptFrontendController()->page['title'];
		}
		if (!empty($this->settings['pageNameStdWrap'])) {
			$pageName = $cObject->stdWrap($pageName, $this->typoScriptService->convertPlainArrayToTypoScriptArray($this->settings['pageNameStdWrap']));
		}
		if (!empty($this->settings['pageNamePrefix'])) {
			$prefixGlue = !empty($this->settings['pageNamePrefixGlue']) ? $this->settings['pageNamePrefixGlue'] : '';
			$pageName = $this->settings['pageNamePrefix'] . ' ' . (!empty($prefixGlue) ? ($prefixGlue . ' ') : '') . $pageName;
		}
		if (!empty($this->settings['prefixDomainAndLanguageKey'])) {
			$host = strtolower(GeneralUtility::getIndpEnv('TYPO3_HOST_ONLY'));
			$langKey = $this->getTyposcriptFrontendController()->sys_language_isocode ? strtolower($this->getTyposcriptFrontendController()->sys_language_isocode) : '';
			if (!empty($this->settings['defaultLanguageKey']) && empty($langKey)) {
				$langKey = trim($this->settings['defaultLanguageKey']);
			}
			$pageName = '[' . $host . (!empty($langKey) ? ('/' . $langKey) : '') . '] ' . $pageName;
		}
		if (!empty($this->settings['rootPageId']) && $this->getTyposcriptFrontendController()->id == $this->settings['rootPageId']) {
			$pageName = '__INDEX__' . $pageName;
		}
		if (!empty($pageName)) {
			$params['et_pagename'] = $pageName;
		}

		// utf8 decode fix
		if ($this->settings['enableUTF8DecodeFix']) {
			foreach ($params as $key => $value) {
				$params[$key] = utf8_decode($value);
			}
		}

		return Etracker::getCode($securityCode, $params);
	}

	/**
	 * Getter for the TSFE.
	 *
	 * @return TypoScriptFrontendController
	 */
	protected function getTyposcriptFrontendController() {
		return $GLOBALS['TSFE'];
	}

}
