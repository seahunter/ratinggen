<?php

namespace App\Core;

use App\Front\Front;

class Core
{
	/**
	 * Main function that create instance of plugins classes.
	 */
	public function init()
	{
		new I18n();
		new Front();
	}
}