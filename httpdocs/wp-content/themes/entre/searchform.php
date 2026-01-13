<form role="search" method="get" class="searchform" id="searchform-<?php echo esc_attr(rand(0, 1000)); ?>" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="screen-reader-text"><?php esc_html_e( 'Search for:', 'entre' ); ?></label>
	<div class="input-holder clearfix">
		<input type="search" class="search-field" placeholder="<?php esc_attr_e( 'Search', 'entre' ); ?>" value="" name="s" title="<?php esc_attr_e( 'Search for:', 'entre' ); ?>"/>
		<button type="submit" class="mkd-search-submit"><img src="<?php echo MIKADO_ASSETS_ROOT . '/img/search_icon_dark.png' ?>" alt="search-icon"></button>
	</div>
</form>