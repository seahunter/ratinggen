<?php

namespace App\Core;

class I18n
{
	public function __construct()
	{
		/**
		 * Create plugin textdomain
		 *
		 * @see add_text_domain()
		 */
		add_action('plugins_loaded', [$this, 'add_text_domain']);
	}

	/**
	 * Text domain of current plugin
	 */
	public function add_text_domain()
	{
		load_plugin_textdomain(
			'ratinggen',
			false,
			dirname(dirname(plugin_basename(__FILE__))) . '/Core/languages/'
		);
	}
}