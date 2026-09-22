<?php


if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

$ghostlabs_perennial_option = 'ghostlabs_perennial_year';

delete_option( $ghostlabs_perennial_option );

if ( is_multisite() ) {
	$ghostlabs_perennial_sites = get_sites(
		[
			'fields' => 'ids',
			'number' => 0,
		]
	);

	foreach ( $ghostlabs_perennial_sites as $ghostlabs_perennial_site_id ) {
		switch_to_blog( (int) $ghostlabs_perennial_site_id );
		delete_option( $ghostlabs_perennial_option );
		restore_current_blog();
	}
}
