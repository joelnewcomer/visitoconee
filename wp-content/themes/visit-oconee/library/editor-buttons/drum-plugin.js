(function() {
	tinymce.PluginManager.add('drum_mce_button', function( editor, url ) {
		editor.addButton('drum_mce_button', {
			icon: 'drum-mce-icon',
			onclick: function() {
				editor.windowManager.open( {
					title: 'Insert Button',
					body: [
						{
							type: 'textbox',
							name: 'buttonText',
							label: 'Button Text'
						},
						{
							type: 'textbox',
							name: 'buttonURL',
							label: 'Button URL'
						},
						{
							type: 'listbox',
							name: 'buttonSize',
							label: 'Button Size',
							'values': [
								{text: 'Normal', value: 'normal'},
								{text: 'Small', value: 'small'},
								{text: 'Large', value: 'large'},
								{text: 'Full-Width', value: 'full-width'}
							]
						},
						{
							type: 'listbox',
							name: 'buttonColor',
							label: 'Button Color',
							'values': [
								{text: 'Brown', value: 'brown'},
								{text: 'Blue', value: 'blue'},
								{text: 'Orange', value: 'orange'},
								{text: 'Green', value: 'green'}
							]
						},
						{
							type: 'listbox',
							name: 'buttonStyle',
							label: 'Button Style',
							'values': [
								{text: 'Default', value: 'primary'},
								{text: 'Secondary', value: 'secondary'},
								{text: 'Rounded', value: 'rounded'}
							]
						},
						{
							type: 'listbox',
							name: 'buttonAlign',
							label: 'Button Alignment',
							'values': [
								{text: 'Left', value: 'text-left'},
								{text: 'Right', value: 'text-right'},
								{text: 'Center', value: 'text-center'}
							]
						}
					],
					onsubmit: function( e ) {
						editor.insertContent( '[button align="' + e.data.buttonAlign + '" type="' + e.data.buttonStyle + '" color="' + e.data.buttonColor + '" size="' + e.data.buttonSize + '"]' + '<a href="' + e.data.buttonURL + '">' + e.data.buttonText + '</a>[/button]');
					}
				});
			}
		});
	});
})();