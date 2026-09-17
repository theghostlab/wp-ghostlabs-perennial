import { date } from '@wordpress/date';
import { __, _x, sprintf } from '@wordpress/i18n';
import {
	ContrastChecker,
	FontSizePicker,
	InspectorControls,
	PanelColorSettings,
	RichText,
	useBlockProps,
	withColors,
	withFontSizes,
} from '@wordpress/block-editor';
import {
	PanelBody,
	SelectControl,
	TextControl,
	ToggleControl,
} from '@wordpress/components';
import { compose } from '@wordpress/compose';
import { useSelect } from '@wordpress/data';
import { store as coreStore } from '@wordpress/core-data';

import './editor.scss';

const CSS_BASE = 'ghostlabs-dynamic-copyright';
const YEAR_LENGTH = 4;

const FONT_SIZE_UNITS = [ 'rem', 'em', 'ch', '%' ];

const FONT_WEIGHTS = [
	{ label: __( 'Default', 'ghostlabs-dynamic-copyright' ), value: '' },
	{ label: __( 'Light (300)', 'ghostlabs-dynamic-copyright' ), value: '300' },
	{
		label: __( 'Regular (400)', 'ghostlabs-dynamic-copyright' ),
		value: '400',
	},
	{
		label: __( 'Medium (500)', 'ghostlabs-dynamic-copyright' ),
		value: '500',
	},
	{
		label: __( 'Semi-bold (600)', 'ghostlabs-dynamic-copyright' ),
		value: '600',
	},
	{ label: __( 'Bold (700)', 'ghostlabs-dynamic-copyright' ), value: '700' },
];

const sanitiseYear = ( value ) =>
	value.replace( /\D/g, '' ).slice( 0, YEAR_LENGTH );

const yearLabel = ( from ) => {
	const currentYear = date( 'Y' );

	return from && from !== currentYear
		? sprintf(
				/* translators: 1: start year, 2: current year. The separator is an en dash (U+2013), the convention for ranges — change it if your language spaces or punctuates ranges differently. */
				_x(
					'© %1$s – %2$s',
					'copyright year range',
					'ghostlabs-dynamic-copyright'
				),
				from,
				currentYear
		  )
		: sprintf(
				/* translators: %s: the current year. */
				_x( '© %s', 'copyright year', 'ghostlabs-dynamic-copyright' ),
				currentYear
		  );
};

const needsPeriod = ( owner, statementOfRights ) =>
	statementOfRights &&
	! owner
		.replace( /<[^>]*>/g, '' )
		.trimEnd()
		.endsWith( '.' );

function Edit( {
	attributes,
	setAttributes,
	yearColor,
	setYearColor,
	yearFontSize,
	setYearFontSize,
	backgroundColor,
} ) {
	const { from, owner, statementOfRights, yearFontWeight } = attributes;

	const resolvedBackground =
		attributes.style?.color?.background ?? backgroundColor?.color;

	const siteTitle = useSelect(
		( select ) =>
			select( coreStore ).getEntityRecord( 'root', 'site' )?.title ?? '',
		[]
	);

	const blockProps = useBlockProps();

	const placeholder =
		siteTitle || __( 'Add a name', 'ghostlabs-dynamic-copyright' );

	const yearClassName = [
		`${ CSS_BASE }__year`,
		yearColor.color && 'has-text-color',
		yearColor.class,
		yearFontSize.class,
	]
		.filter( Boolean )
		.join( ' ' );

	const yearStyle = {
		color: yearColor.slug ? undefined : yearColor.color,
		fontSize: yearFontSize.slug ? undefined : yearFontSize.size,
		fontWeight: yearFontWeight || undefined,
	};

	return (
		<>
			<InspectorControls>
				<PanelBody
					title={ __( 'Settings', 'ghostlabs-dynamic-copyright' ) }
				>
					<TextControl
						__nextHasNoMarginBottom
						label={ __(
							'From year',
							'ghostlabs-dynamic-copyright'
						) }
						help={ __(
							'Optional. Shows a range, for example 2001 – 2026.',
							'ghostlabs-dynamic-copyright'
						) }
						value={ from }
						inputMode="numeric"
						onChange={ ( value ) =>
							setAttributes( { from: sanitiseYear( value ) } )
						}
					/>
					<ToggleControl
						__nextHasNoMarginBottom
						label={ __(
							'Statement of rights',
							'ghostlabs-dynamic-copyright'
						) }
						help={ __(
							'Appends "All rights reserved."',
							'ghostlabs-dynamic-copyright'
						) }
						checked={ statementOfRights }
						onChange={ ( value ) =>
							setAttributes( { statementOfRights: value } )
						}
					/>
				</PanelBody>
			</InspectorControls>

			<InspectorControls group="styles">
				<PanelBody
					title={ __(
						'Year typography',
						'ghostlabs-dynamic-copyright'
					) }
				>
					<FontSizePicker
						__nextHasNoMarginBottom
						value={ yearFontSize.size }
						onChange={ setYearFontSize }
						units={ FONT_SIZE_UNITS }
					/>
					<SelectControl
						__nextHasNoMarginBottom
						label={ __( 'Weight', 'ghostlabs-dynamic-copyright' ) }
						value={ yearFontWeight ?? '' }
						options={ FONT_WEIGHTS }
						onChange={ ( value ) =>
							setAttributes( {
								yearFontWeight: value || undefined,
							} )
						}
					/>
				</PanelBody>

				<PanelColorSettings
					title={ __( 'Year color', 'ghostlabs-dynamic-copyright' ) }
					colorSettings={ [
						{
							value: yearColor.color,
							onChange: setYearColor,
							label: __(
								'Year text',
								'ghostlabs-dynamic-copyright'
							),
						},
					] }
				>
					{ }
					<ContrastChecker
						textColor={ yearColor.color }
						backgroundColor={ resolvedBackground }
						fontSize={ yearFontSize.size }
					/>
				</PanelColorSettings>
			</InspectorControls>

			<p { ...blockProps }>
				<span className={ yearClassName } style={ yearStyle }>
					{ yearLabel( from ) }
				</span>{ ' ' }
				<RichText
					tagName="span"
					className={ `${ CSS_BASE }__owner` }
					value={ owner }
					placeholder={ placeholder }
					allowedFormats={ [
						'core/bold',
						'core/italic',
						'core/link',
					] }
					onChange={ ( value ) => setAttributes( { owner: value } ) }
				/>
				{ needsPeriod( owner || placeholder, statementOfRights ) &&
					'.' }
				{ statementOfRights && (
					<>
						{ ' ' }
						<span className={ `${ CSS_BASE }__rights` }>
							{ __(
								'All rights reserved.',
								'ghostlabs-dynamic-copyright'
							) }
						</span>
					</>
				) }
			</p>
		</>
	);
}

export default compose(
	withColors( { yearColor: 'color' }, 'backgroundColor' ),
	withFontSizes( 'yearFontSize' )
)( Edit );
