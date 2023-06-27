/*
	The config file for the plugin
 */
const { registerBlockType } = wp.blocks
/* To use translation in admin -> const { __ } = wp.i18n */

/*
* Include module for the register block
* Don't forget to also add the needed module in the info-bulle-block.php file
*/
const { useBlockProps, RichText, InspectorControls } = wp.blockEditor
const { MenuGroup, MenuItemsChoice } = wp.components
const { useState } = wp.element


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
	edit ({ className, attributes, setAttributes }) {
		const [ mode, setMode ] = useState( 'visual' );
		const choices = [
			{
				value: '#FDEFE1',
				label: 'Orange',
			},
			{
				value: '#E6F4FA',
				label: 'Blue',
			},
		];
		const style = {
			'color': attributes.color,
			'background-color': attributes.backgroundColor,
		};
		className += ' info-bulle-component';
		console.log(attributes)
		return <div className={ className } style={style}>
			<InspectorControls>
				<MenuGroup label="Predefine settings" className="info-bulle-inspector">
					<MenuItemsChoice
						choices={ choices }
						value={ attributes.backgroundColor }
						onSelect={
						( newMode ) => setAttributes(
							{backgroundColor: newMode},
							setMode( newMode )
						)
					}
						onClick={( newMode ) => console.log(newMode)}
					/>
				</MenuGroup>
			</InspectorControls>
			<RichText
				placeholder={ 'Placeholder' } // Display this text before any content has been added by the user
				allowedFormats={ [ 'core/bold', 'core/italic' ] } // Allow the content to be made bold or italic, but do not allow other formatting options
				onChange={ ( content ) => setAttributes( { content } ) } // Store updated content as a block attribute
				value={ attributes.content }
			/>
		</div>

	},

	/* Specify what html code will be generated in front end
	* if we want to make a dynamic block, leave the return to null
	*/
	save () {
		return null
	}
})