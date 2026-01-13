(function($) {
	
	$(document).ready(function(){
		mkdInitWidgetFieldColorPicker();
	});
	
	$(window).on('load', function() {
		mkdButtonWidgetFieldDependency();
		mkdIconWidgetFieldDependency();
		mkdImageGalleryWidgetFieldDependency();
		mkdSocialIconWidgetFieldDependency();
	});
	
	$( document ).on( 'widget-added widget-updated', mkdColorPickeronFormUpdate );

	function mkdInitColorPicker(widget) {
		if (widget.find('.wp-picker-container').length <= 0) {
			widget.find('input.mkd-color-picker-field').wpColorPicker({
				change: _.throttle(function () { // For Customizer
					$(this).trigger('change');
				}, 3000)
			});
		}
	}
	
	function mkdColorPickeronFormUpdate( event, widget ) {
		mkdInitColorPicker( widget );
	}
	
	function mkdInitWidgetFieldColorPicker() {
		var colorPicker = $('.mkd-widget-color-picker');
		
		if (colorPicker.length && colorPicker.find('.wp-picker-container').length <= 0) {
			colorPicker.each(function(){
				var thisColorPicker = $(this);
				
				mkdInitColorPicker( thisColorPicker );
			});
		}
	}
	
	/**
	 * Render field dependency for button widget
	 */
	function mkdButtonWidgetFieldDependency() {
		var buttons = {
			'solid': ['size', 'background_color', 'border_color'],
			'outline': ['size', 'background_color', 'border_color']
		};
		
		mkdUpdateWidgetSelection('mkd_button_widget', 'type', buttons);
	}
	
	/**
	 * Render field dependency for icon widget
	 */
	function mkdIconWidgetFieldDependency() {
		var iconPacks = {
			'font_awesome': 'fa_icon',
			'font_elegant': 'fe_icon',
			'ion_icons': 'ion_icon',
			'linea_icons': 'linea_icon',
			'linear_icons': 'linear_icon',
			'simple_line_icons': 'simple_line_icon',
            'dripicons': 'dripicon'
		};

		mkdUpdateWidgetSelection('mkd_icon_widget', 'icon_pack', iconPacks);
	}
	
	/**
	 * Render field dependency for image gallery widget
	 */
	function mkdImageGalleryWidgetFieldDependency() {
		var imageBehavior = {
			'custom-link': ['custom_links', 'custom_link_target']
		};
		
		mkdUpdateWidgetSelection('mkd_image_gallery_widget', 'image_behavior', imageBehavior);
		
		var imageType = {
			'grid': ['number_of_columns', 'space_between_columns'],
			'slider': ['slider_navigation', 'slider_pagination']
		};
		
		mkdUpdateWidgetSelection('mkd_image_gallery_widget', 'type', imageType);
	}
	
	/**
	 * Render field dependency for socialIcon widget
	 */
	function mkdSocialIconWidgetFieldDependency() {
		var iconPacks = {
			'font_awesome': 'fa_icon',
			'font_elegant': 'fe_icon',
			'ion_icons': 'ion_icon',
			'simple_line_icons': 'simple_line_icon'
		};

		mkdUpdateWidgetSelection('mkd_social_icons_group_widget', 'icon_pack', iconPacks);
		mkdUpdateWidgetSelection('mkd_social_icon_widget', 'icon_pack', iconPacks);
	}

    /**
     * Function that shows/hides fields based on selection
     *
     * @param string widgetId is unique id of widget
     * @param string optionName is widget option name which trigger dependency
     * @param object optionDependencyArray is object where keys are values of option with dependency and values are options you want to show/hide
     */
    function mkdUpdateWidgetSelection(widgetId, optionName, optionDependencyArray) {
	    mkdWidgetFields(widgetId, optionName, optionDependencyArray);

	    $('body').on('change', 'select[name*="'+widgetId+'"]', function() {
	    	if( $(this).attr('name').search(optionName) !== -1 ) {
			    var thisWidget    = $(this).closest('.widget'),
				    selectedValue = $(this).find('option:selected').val();

			    mkdHideFields(thisWidget, optionDependencyArray);
			    mkdShowFields(thisWidget, optionDependencyArray, selectedValue);
		    }
        });
    }

	/**
	 * Core function which initialy loops for dependancy fields and hide non-selected ones
	 *
	 * @param string widgetId is unique id of widget
	 * @param string optionName is widget option name which trigger dependency
	 * @param object optionDependencyArray is object where keys are values of option with dependency and values are options you want to show/hide
	 */
	function mkdWidgetFields(widgetId, optionName, optionDependencyArray) {
		$('div[id*="'+widgetId+'"]').each(function(){
			var selectedValue = $(this).find('select[id*="'+optionName+'"]').val(),
				saveButton = $(this).find('.widget-control-save');

			saveButton.on('click', {widget: $(this), optionDependencyArray: optionDependencyArray, optionName: optionName}, mkdTrackAjaxChange);

			mkdHideFields($(this), optionDependencyArray);
			mkdShowFields($(this), optionDependencyArray, selectedValue);
		});
	}

	/**
	 * Core function which hides non selected fields and shows selected one
	 *
	 * @param object thisWidget is current widget
	 * @param object optionDependencyArray is object where keys are values of option with dependency and values are options you want to show/hide
	 */
	function mkdHideFields(thisWidget, optionDependencyArray) {
		$.each(optionDependencyArray, function(key, value) {
			if( typeof value === 'string' ) {
				thisWidget.find('[id*="' + value + '"]').parent().hide();
			} else if (typeof value === 'object') {
				$.each(value, function(arrayKey, arrayValue){
					thisWidget.find('[id*="'+arrayValue+'"]').parent().hide();
				});
			}
		});
	}

	/**
	 * Core function which shows non selected fields and shows selected one
	 *
	 * @param object thisWidget is current widget
	 * @param object optionDependencyArray is object where keys are values of option with dependency and values are options you want to show/hide
	 * @param string/object selectedValue is selected value of optionName
	 */
	function mkdShowFields(thisWidget, optionDependencyArray, selectedValue) {
		if( typeof optionDependencyArray[selectedValue] === 'string' ) {
			thisWidget.find('[id*="'+optionDependencyArray[selectedValue]+'"]').parent().show();
		} else {
			$.each(optionDependencyArray[selectedValue], function(key, value){
				thisWidget.find('[id*="'+value+'"]').parent().show();
			});
		}
	}

	/**
	 * Core function which checks for spinner once a save button is clicked
	 */
	function mkdTrackAjaxChange(event) {
    	var widget = event.data.widget,
		    optionDependencyArray = event.data.optionDependencyArray,
		    optionName = event.data.optionName,
		    spinner = widget.find('.spinner');

	    var timer = setInterval(function(){
		    if( spinner.hasClass('is-active') ) {
			    clearInterval(timer);
			    mkdAfterAjaxReset(widget, optionName, spinner, optionDependencyArray);
		    }
	    }, 20);
	}

	/**
	 * Core function which runs after ajax save is reloaded
	 *
	 * @param object thisWidget is current widget
	 * @param string optionName is widget option name which trigger dependency
	 * @param object spinner is native widget spinner when you click to save widget
	 * @param object optionDependencyArray is object where keys are values of option with dependency and values are options you want to show/hide
	 */
	function mkdAfterAjaxReset(thisWidget, optionName, spinner, optionDependencyArray) {
		var timer = setInterval(function(){
			if( ! spinner.hasClass('is-active') ) {
				var selectedValue = thisWidget.find('select[id*="'+optionName+'"]').val();

				clearInterval(timer);
				mkdHideFields(thisWidget, optionDependencyArray);
				mkdShowFields(thisWidget, optionDependencyArray, selectedValue);
			}
		}, 20);
	}

})(jQuery);