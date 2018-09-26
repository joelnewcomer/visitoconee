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
							name: 'buttonStyle',
							label: 'Button Style',
							'values': [
								{text: 'Primary', value: 'primary'},
								{text: 'Secondary', value: 'secondary'},
								{text: 'Tertiary', value: 'tertiary'}
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
						editor.insertContent( '[button align="' + e.data.buttonAlign + '" type="' + e.data.buttonStyle + '" size="' + e.data.buttonSize + '"]' + '<a href="' + e.data.buttonURL + '">' + e.data.buttonText + '</a>[/button]');
					}
				});
			}
		});
	});
})();