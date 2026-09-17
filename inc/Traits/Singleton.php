<?php


namespace GHOSTLABS\DYNAMIC_COPYRIGHT\Traits;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

trait Singleton {

	private static ?self $instance = null;

	final private function __construct() {}

	final public function __clone() {
		_doing_it_wrong(
			__FUNCTION__,
			esc_html__( 'Cloning this class is not allowed.', 'ghostlabs-dynamic-copyright' ),
			'1.0.0'
		);
	}

	final public function __wakeup() {
		_doing_it_wrong(
			__FUNCTION__,
			esc_html__( 'Unserializing this class is not allowed.', 'ghostlabs-dynamic-copyright' ),
			'1.0.0'
		);
	}

	final public static function getInstance(): self {
		return self::$instance ??= new self();
	}
}
