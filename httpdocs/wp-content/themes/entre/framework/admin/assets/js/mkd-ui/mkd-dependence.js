(function ($) {
	
	$(document).ready(function () {
		mkdInitSelectChange();
		mkdInitIconSelectChange();
		mkdInitRadioChange();
	});
	
	function mkdInitSelectChange() {
		$(document).on('change', 'select.dependence', function (e) {
			var thisItem = $(this),
				valueSelected = this.value.replace(/ /g, '');
			
			$(thisItem.data('hide-' + valueSelected)).fadeOut();
			$(thisItem.data('show-' + valueSelected)).fadeIn();
		});
	}
	
	function mkdInitIconSelectChange() {
		$(document).on('change', 'select.icon-dependence', function (e) {
			var valueSelected = this.value.replace(/ /g, '');
			
			$('.row.mkd-icon-collection-holder').fadeOut();
			$('.row.mkd-icon-collection-holder[data-icon-collection="' + valueSelected + '"]').fadeIn();
		});
	}
	
	function mkdInitRadioChange() {
		$(document).on('change', 'input[type="radio"].dependence', function () {
			var thisItem = $(this),
				dataHide = thisItem.data('hide'),
				dataShow = thisItem.data('show');
			
			if (typeof(dataHide) !== 'undefined' && dataHide !== '') {
				var elementsToHide = dataHide.split(',');
				
				$.each(elementsToHide, function (index, value) {
					$(value).fadeOut();
				});
			}
			
			if (typeof(dataShow) !== 'undefined' && dataShow !== '') {
				var elementsToShow = dataShow.split(',');
				
				$.each(elementsToShow, function (index, value) {
					$(value).fadeIn();
				});
			}
		});
	}
	
})(jQuery);