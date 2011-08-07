<?php

class Environment {
	const DEVELOPMENT = 1;
	const PRODUCTION = 2;	

	public static function init() {
		switch(Config::ENV) {
			case self::DEVELOPMENT:
				self::development_init(); 
				break;
			case self::PRODUCTION:
				self::production_init();
				break;
		}	

        set_time_limit(0);
        ini_set('user_agent', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US) AppleWebKit/525.13 (KHTML, like Gecko) Chrome/0.A.B.C Safari/525.13');
	}

	private static function development_init() {
		error_reporting(E_ALL ^ E_NOTICE);
        ini_set('display_errors', 'on');
	}

	private static function production_init() {
		error_reporting(0);
        ini_set('display_errors', 'off');
	}
}