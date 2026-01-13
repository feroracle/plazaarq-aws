<div class="mkd-fullscreen-search-holder">
	<a class="mkd-fullscreen-search-close" href="javascript:void(0)">
		<?php echo entre_mikado_icon_collections()->renderIcon( 'lnr-cross', 'linear_icons' ); ?>
	</a>
	<div class="mkd-fullscreen-search-table">
		<div class="mkd-fullscreen-search-cell">
			<div class="mkd-fullscreen-search-inner">
				<form action="<?php echo esc_url( home_url( '/' ) ); ?>" class="mkd-fullscreen-search-form" method="get">
					<div class="mkd-form-holder">
						<div class="mkd-form-holder-inner">
							<div class="mkd-field-holder">
								<input type="text" placeholder="<?php esc_attr_e( 'search', 'entre' ); ?>" name="s" class="mkd-search-field" autocomplete="off"/>
							</div>
							<button type="submit" class="mkd-search-submit">
								<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
									  width="21px" height="21px" viewBox="0 0 149.391 149.39" enable-background="new 0 0 149.391 149.39"
									  xml:space="preserve">
									<g>
									 <path fill="#434343" d="M62.344,12.468c-27.5,0-49.875,22.375-49.875,49.875c0,1.723,1.394,3.118,3.117,3.118
									  s3.117-1.395,3.117-3.118c0-24.062,19.578-43.64,43.641-43.64c1.722,0,3.121-1.396,3.121-3.117
									  C65.465,13.863,64.066,12.468,62.344,12.468L62.344,12.468z M62.344,12.468"/>
									 <path fill="#434343" d="M108.508,104.101c10.02-11.065,16.184-25.687,16.184-41.758C124.691,27.968,96.723,0,62.344,0
									  C27.969,0,0,27.968,0,62.343c0,34.379,27.969,62.348,62.344,62.348c16.07,0,30.687-6.163,41.757-16.184l40.879,40.883l4.41-4.41
									  L108.508,104.101z M62.344,118.457c-30.938,0-56.11-25.172-56.11-56.114c0-30.937,25.172-56.109,56.11-56.109
									  c30.941,0,56.113,25.172,56.113,56.109C118.457,93.285,93.285,118.457,62.344,118.457L62.344,118.457z M62.344,118.457"/>
									</g>
								</svg>
							</button>
							<div class="mkd-line"></div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>