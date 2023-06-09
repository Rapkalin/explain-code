/*
	The config file for the plugin
 */
const { registerBlockType } = wp.blocks
/* To use translation in admin -> const { __ } = wp.i18n */

/*
* Include module for the register block
* Don't forget to also add the needed module in the info-bulle-block.php file
*/
const { InnerBlocks, useBlockProps, RichText, InspectorControls } = wp.blockEditor
const { MenuGroup, MenuItemsChoice } = wp.components

registerBlockType('info-bulle-block/info-bulle-block', {
	/* The plugin title in the admin */
	title: "Info bulle",
	category: "widgets",

	/* What the plugin supports */
	supports: {
		html: false
	},

	/* Specify what html code will be generated in the admin
	* className var is automatically generated by Wordpress
	*/
	edit ({ className, attributes, setAttributes, blocks, setBlocks }) {

		/* Available choices for the info bulle plugin editor menu */
		const choices = [
			{
				value: 'information',
				label: 'Information',
			},
			{
				value: 'warning',
				label: 'Warning',
			},
			{
				value: 'alert',
				label: 'Alert',
			},
			{
				value: 'see-also',
				label: 'See also',
			},
		];

		/* Add specific class and style to handle different behavior for admin content display */
		className += ' info-bulle-component-back icon-' + attributes.bulleMode + '-back';
		const style = {
			'background-color': attributes.backgroundColor,
		};

		/* if see-also mode then add <span> before content */
		const readAlso = (attributes.bulleMode === 'see-also' && (attributes.content === ''|| attributes.content === undefined)) ? <span className="disable-read-also-span-back">Lire aussi : </span> : '';

		return <div className={ className } style={style}>
			<InspectorControls>
				<MenuGroup label="Predefine settings" className="info-bulle-inspector">
					<MenuItemsChoice
						choices={ choices }
						value={ attributes.bulleMode }
						onSelect={
							( newMode ) => setAttributes({backgroundColor: setBackgroundColor(newMode), bulleMode: newMode} )
						}
					/>
				</MenuGroup>
			</InspectorControls>

			{readAlso}<InnerBlocks placeholder={ 'Saisir un texte ici' }/>
		</div>

	},

	/* Specify what html code will be generated in front end
	* if we want to make a dynamic block, leave the return to null
	*/
	save () {
			return (
					< InnerBlocks.Content />
			);
		},

})

/**
 *
 * @param newMode
 * @returns {string}
 */
function setBackgroundColor(newMode)
{
	if (typeof newMode === 'string' || newMode instanceof String) {
		switch (newMode) {
			case "information":
				return'#E6F4FA';
			case "warning":
				return '#ffe1c4';
			case "alert":
				return '#ffc9d0';
			case "see-also":
				return '#2E3844';
		}
	}
}