<?php


namespace GHOSTLABS\PERENNIAL;

use GHOSTLABS\PERENNIAL\Service\CopyrightBlock;
use GHOSTLABS\PERENNIAL\Service\YearRollover;
use GHOSTLABS\PERENNIAL\Traits\Singleton;

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
