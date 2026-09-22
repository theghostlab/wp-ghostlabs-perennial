<?php


namespace GHOSTLABS\PERENNIAL\Service;

use WP_Block;
use WP_Block_Type;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class CopyrightBlock {

	private const CSS_BASE = 'ghostlabs-perennial';

	private const ALLOWED_OWNER_HTML = [
		'a'      => [
			'href'   => true,
			'title'  => true,
			'rel'    => true,
			'target' => true,
		],
		'strong' => [],
		'em'     => [],
		'b'      => [],
		'i'      => [],
		'br'     => [],
		'span'   => [],
	];

	public function register(): void {
		$block_type = register_block_type(
			GHOSTLABS_PERENNIAL_PLUGIN_PATH . 'build/blocks/notice',
			[ 'render_callback' => [ $this, 'render' ] ]
		);

		if ( $block_type instanceof WP_Block_Type ) {
			$this->registerScriptTranslations( $block_type );
		}
	}

	private function registerScriptTranslations( WP_Block_Type $block_type ): void {
		foreach ( $block_type->editor_script_handles as $handle ) {
			wp_set_script_translations(
				$handle,
				'ghostlabs-perennial',
				GHOSTLABS_PERENNIAL_PLUGIN_PATH . 'languages'
			);
		}
	}

	public function render( array $attributes, string $content = '', ?WP_Block $block = null ): string {
		$owner = self::resolveOwner(
			(string) ( $attributes['owner'] ?? '' ),
			(string) get_bloginfo( 'name' )
		);

		$statement_of_rights = ! empty( $attributes['statementOfRights'] );

		$year_style = safecss_filter_attr( self::yearInlineStyle( $attributes ) );

		$parts = [
			sprintf(
				'<span class="%s"%s>%s</span>',
				esc_attr( self::yearClassNames( $attributes ) ),
				'' === $year_style ? '' : sprintf( ' style="%s"', esc_attr( $year_style ) ),
				esc_html( self::yearLabel( (string) ( $attributes['from'] ?? '' ), (string) current_time( 'Y' ) ) )
			),
			sprintf(
				'<span class="%s__owner">%s</span>',
				esc_attr( self::CSS_BASE ),
				wp_kses( self::ownerLabel( $owner, $statement_of_rights ), self::ALLOWED_OWNER_HTML )
			),
		];

		if ( $statement_of_rights ) {
			$parts[] = sprintf(
				'<span class="%s__rights">%s</span>',
				esc_attr( self::CSS_BASE ),
				esc_html__( 'All rights reserved.', 'ghostlabs-perennial' )
			);
		}

		return sprintf(
			'<p %s>%s</p>',
			get_block_wrapper_attributes(),
			implode( ' ', $parts )
		);
	}

	public static function yearClassNames( array $attributes ): string {
		$classes = [ self::CSS_BASE . '__year' ];

		$preset_color = self::slug( $attributes['yearColor'] ?? '' );
		$custom_color = trim( (string) ( $attributes['customYearColor'] ?? '' ) );

		if ( '' !== $preset_color || '' !== $custom_color ) {
			$classes[] = 'has-text-color';
		}

		if ( '' !== $preset_color ) {
			$classes[] = sprintf( 'has-%s-color', $preset_color );
		}

		$preset_font_size = self::slug( $attributes['yearFontSize'] ?? '' );

		if ( '' !== $preset_font_size ) {
			$classes[] = sprintf( 'has-%s-font-size', $preset_font_size );
		}

		return implode( ' ', $classes );
	}

	public static function yearInlineStyle( array $attributes ): string {
		$declarations = [
			'color'       => trim( (string) ( $attributes['customYearColor'] ?? '' ) ),
			'font-size'   => trim( (string) ( $attributes['customYearFontSize'] ?? '' ) ),
			'font-weight' => trim( (string) ( $attributes['yearFontWeight'] ?? '' ) ),
		];

		$css = '';

		foreach ( $declarations as $property => $value ) {
			if ( '' !== $value ) {
				$css .= sprintf( '%s:%s;', $property, $value );
			}
		}

		return $css;
	}

	private static function slug( $value ): string {
		return (string) preg_replace( '/[^a-z0-9-]/', '', strtolower( (string) $value ) );
	}

	public static function resolveOwner( string $owner, string $siteName ): string {
		$owner = trim( $owner );

		return '' === $owner ? $siteName : $owner;
	}

	public static function yearLabel( string $from, string $currentYear ): string {
		if ( '' !== $from && $from !== $currentYear ) {
			return sprintf(
				/* translators: 1: start year, 2: current year. The separator is an en dash (U+2013), the convention for ranges — change it if your language spaces or punctuates ranges differently. */
				_x( '© %1$s – %2$s', 'copyright year range', 'ghostlabs-perennial' ),
				$from,
				$currentYear
			);
		}

		return sprintf(
			/* translators: %s: the current year. */
			_x( '© %s', 'copyright year', 'ghostlabs-perennial' ),
			$currentYear
		);
	}

	public static function ownerLabel( string $owner, bool $statementOfRights ): string {
		if ( ! $statementOfRights ) {
			return $owner;
		}

		if ( '.' === substr( rtrim( wp_strip_all_tags( $owner ) ), -1 ) ) {
			return $owner;
		}

		return $owner . '.';
	}
}
