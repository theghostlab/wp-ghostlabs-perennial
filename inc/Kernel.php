<?php


namespace GHOSTLABS\DYNAMIC_COPYRIGHT;

use GHOSTLABS\DYNAMIC_COPYRIGHT\Service\CopyrightBlock;
use GHOSTLABS\DYNAMIC_COPYRIGHT\Service\YearRollover;
use GHOSTLABS\DYNAMIC_COPYRIGHT\Traits\Singleton;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Kernel {

	use Singleton;

	private CopyrightBlock $block;

	private YearRollover $rollover;

	public function init(): self {
		$this->block    = new CopyrightBlock();
		$this->rollover = new YearRollover();

		return $this;
	}

	public function run(): void {
		add_action( 'init', [ $this->block, 'register' ] );

		$this->rollover->register();
	}
}
