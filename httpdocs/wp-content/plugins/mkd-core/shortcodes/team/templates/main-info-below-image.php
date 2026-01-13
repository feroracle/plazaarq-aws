<?php
/**
 * Team info below shortcode template
 */
?>
<div class="mkd-team main-info-below-image <?php echo esc_attr($skin) ?>">
	<div class="mkd-team-inner">
		<?php if ($team_image !== '') { ?>
			<div class="mkd-team-image">
                <?php echo wp_get_attachment_image($team_image,'full');?>
			</div>
		<?php } ?>

		<?php if ($team_name !== '' || $team_position !== '' || $team_description != "" || $team_email != "") { ?>
			<div class="mkd-team-info">
				<?php if ($team_name !== '' || $team_position !== '' || $team_email != "") { ?>
					<div class="mkd-team-title-holder <?php echo esc_attr($team_social_icon_type) ?>">
						<?php if ($team_name !== '') { ?>
							<<?php echo esc_attr($team_name_tag); ?> class="mkd-team-name">
								<?php echo esc_attr($team_name); ?>
							</<?php echo esc_attr($team_name_tag); ?>>
						<?php } ?>
					</div>
					<?php if ($team_position !== "") { ?>
						<span class="mkd-team-email" <?php echo entre_mikado_get_inline_style($email_styles); ?>><?php echo esc_attr($team_email) ?></span>
					<?php } ?>
					<?php if ($team_position !== "") { ?>
						<span class="mkd-team-position" <?php echo entre_mikado_get_inline_style($position_styles); ?>><?php echo esc_attr($team_position) ?></span>
					<?php } ?>
				<?php } ?>

				<?php if ($team_description != "") { ?>
					<div class='mkd-team-text'>
						<div class='mkd-team-text-inner'>
							<div class='mkd-team-description'>
								<p><?php echo esc_attr($team_description) ?></p>
							</div>
						</div>
					</div>
				<?php }
			} ?>

		<div class="mkd-team-social-holder-between">
			<div class="mkd-team-social <?php echo esc_attr($team_social_icon_type) ?>">
				<div class="mkd-team-social-inner">
					<div class="mkd-team-social-wrapp">

						<?php foreach( $team_social_icons as $team_social_icon ) {
							print entre_mikado_display_content_output($team_social_icon);
						} ?>

					</div>
				</div>
			</div>
		</div>

		</div>
	</div>
</div>