<?php


namespace GHOSTLABS\PERENNIAL\Service;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class YearRollover {

	private const OPTION = 'ghostlabs_perennial_year';

	public function register(): void {
		add_action( 'wp_loaded', [ $this, 'maybePurge' ] );
	}

	public function maybePurge(): void {
		if ( wp_installing() ) {
			return;
		}

		$current = (string) current_time( 'Y' );
		$stored  = (string) get_option( self::OPTION, '' );

		if ( $stored === $current ) {
			return;
		}

		update_option( self::OPTION, $current, true );

		if ( ! self::isRollover( $stored, $current ) ) {
			return;
		}

		do_action( 'ghostlabs_perennial_year_rolled_over', $current, $stored );

		if ( ! apply_filters( 'ghostlabs_perennial_purge_on_rollover', true ) ) {
			return;
		}

		self::purge();
	}

	public static function isRollover( string $stored, string $current ): bool {
		return '' !== $stored && '' !== $current && $stored !== $current;
	}

	private static function purge(): void {
		
		self::callIfExists( 'rocket_clean_domain' );

		self::callIfExists( 'w3tc_flush_all' );

		self::callIfExists( 'wp_cache_clear_cache' );

		do_action( 'litespeed_purge_all' ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound -- LiteSpeed's own hook, fired to ask it to purge; prefixing it would address nobody.
	}

	private static function callIfExists( string $function ): void {
		if ( function_exists( $function ) ) {
			call_user_func( $function );
		}
	}
}
