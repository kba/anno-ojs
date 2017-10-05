<?php

// vim: sw=2 ts=2 noet

/**
 * @file plugins/generic/anno/AnnoPlugin.inc.php
 *
 * Copyright (c) 2013-2015 Simon Fraser University Library
 * Copyright (c) 2003-2015 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class AnnoPlugin
 * @ingroup plugins_generic_anno
 *
 * @brief anno annotation/discussion integration
 */


import('lib.pkp.classes.plugins.GenericPlugin');

class AnnoPlugin extends GenericPlugin {
	/**
	 * Register the plugin, if enabled; note that this plugin
	 * runs under both Journal and Site contexts.
	 * @param $category string
	 * @param $path string
	 * @return boolean
	 */
	function register($category, $path) {
		HookRegistry::register('ArticleHandler::download', array(&$this, 'callback'));
		HookRegistry::register('Templates::Article::Footer::PageFooter', array($this, 'callback'));
		HookRegistry::register('Templates::Issue::Issue::Article', array($this, 'callback'));
		//
		// return true;
		// if (parent::register($category, $path)) {
		//   HookRegistry::register('ArticleHandler::download', array(&$this, 'callback'));
		//   HookRegistry::register('Templates::Issue::Issue::Article', array($this, 'insertFooter'));
		//   return true;
		// }
		// return false;
	}

	/**
	 * Hook callback function for TemplateManager::display
	 * @param $hookName string
	 * @param $args array
	 * @return boolean
	 */
	function callback($hookName, $args) {
		// $galley =& $args[1];
		// if (!$galley || $galley->getFileType() != 'text/html') return false;

		$cdn = 'https://www.ub.uni-heidelberg.de/cdn/';
		$scripts = [
			'anno-frontend/dev/anno-frontend.js'
		];
		$scripts_block = '';
		foreach ($scripts as $script) {
			$scripts_block .= '<script src="' . $cdn . $script . '"><script>';
		}

		ob_start(function($buffer) {
			return str_replace('</body>', $scripts_block . '</body>', $buffer);
		});

		return false;
	}

	/**
	 * Get the display name of this plugin
	 * @return string
	 */
	function getDisplayName() {
		return __('plugins.generic.anno.name');
	}

	/**
	 * Get the description of this plugin
	 * @return string
	 */
	function getDescription() {
		return __('plugins.generic.anno.description');
	}
}

?>
