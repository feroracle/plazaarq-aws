<?php entre_mikado_get_content_bottom_area(); ?>
</div> <!-- close div.content_inner -->
	</div>  <!-- close div.content -->
		<?php if($display_footer && ($display_footer_top || $display_footer_bottom)) { ?>
			<footer <?php entre_mikado_class_attribute( $footer_classes ); ?> >
				<?php
					if($display_footer_top) {
						entre_mikado_get_footer_top();
					}
					if($display_footer_bottom) {
						entre_mikado_get_footer_bottom();
					}
				?>
			</footer>
		<?php } ?>
	</div> <!-- close div.mkd-wrapper-inner  -->
</div> <!-- close div.mkd-wrapper -->
<?php wp_footer(); ?>
</body>
</html>