const defaultConfig = require( '@wordpress/scripts/config/webpack.config' );

module.exports = {
	...defaultConfig,
	entry: {
		...( typeof defaultConfig.entry === 'function'
			? defaultConfig.entry()
			: defaultConfig.entry ),
	},
};
