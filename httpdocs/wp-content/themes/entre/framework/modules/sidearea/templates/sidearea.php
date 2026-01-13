<section class="mkd-side-menu">
	<div class="mkd-close-side-menu-holder">
		<a class="mkd-side-menu-button-opener mkd-close-side-menu" href="#" target="_self">
			<span class="mkd-sm-lines">
	            <span class="mkd-sm-line mkd-line-1"></span>
	            <span class="mkd-sm-line mkd-line-2"></span>
	            <span class="mkd-sm-line mkd-line-3"></span>
	        </span>
		</a>
	</div>
	<?php if ( is_active_sidebar( 'sidearea' ) ) {
		dynamic_sidebar( 'sidearea' );
	} ?>
</section>