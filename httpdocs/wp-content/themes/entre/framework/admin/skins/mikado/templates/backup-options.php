<div class="mkd-tabs-content">
	<div class="tab-content">
		<div class="tab-pane fade in active" id="import">
			<div class="mkd-tab-content">
				<h2 class="mkd-page-title"><?php esc_html_e('Backup Options', 'entre'); ?></h2>
				<form method="post" class="mkd_ajax_form mkd-backup-options-page-holder">
					<div class="mkd-page-form">
						<div class="mkd-page-form-section-holder">
							<h3 class="mkd-page-section-title"><?php esc_html_e('Export/Import Options', 'entre'); ?></h3>
							<div class="mkd-page-form-section">
								<div class="mkd-field-desc">
									<h4><?php esc_html_e('Export', 'entre'); ?></h4>
									<p><?php esc_html_e('Copy the code from this field and save it to a textual file to export your options. Save that textual file somewhere so you can later use it to import options if necessary.', 'entre'); ?></p>
								</div>
								<div class="mkd-section-content">
									<div class="container-fluid">
										<div class="row">
											<div class="col-lg-12">
												<textarea name="export_options" id="export_options" class="form-control mkd-form-element" rows="10" readonly><?php echo mkd_core_export_options(); ?></textarea>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="mkd-page-form-section">
								<div class="mkd-field-desc">
									<h4><?php esc_html_e('Import', 'entre'); ?></h4>
									<p><?php esc_html_e('To import options, just paste the code you previously saved from the "Export" field into this field, and then click the "Import" button.', 'entre'); ?></p>
								</div>
								<div class="mkd-section-content">
									<div class="container-fluid">
										<div class="row">
											<div class="col-lg-12">
												<textarea name="import_theme_options" id="import_theme_options" class="form-control mkd-form-element" rows="10"></textarea>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="mkd-page-form-section">
								<div class="mkd-field-desc">
									<button type="button" class="btn btn-primary btn-sm " name="import" id="mkd-import-theme-options-btn"><?php esc_html_e('Import', 'entre'); ?></button>
									<?php wp_nonce_field('mkd_import_theme_options_secret_value', 'mkd_import_theme_options_secret', false); ?>
									<span class="mkd-bckp-message"></span>
								</div>
							</div>
							<div class="mkd-page-form-section mkd-import-button-wrapper">
								<div class="alert alert-warning">
									<strong><?php esc_html_e('Important notes:', 'entre') ?></strong>
									<ul>
										<li><?php esc_html_e('Please note that import process will overide all your existing options.', 'entre'); ?></li>
									</ul>
								</div>
							</div>
						</div>
						<div class="mkd-page-form-section-holder">
							<h3 class="mkd-page-section-title"><?php esc_html_e('Export/Import Custom Sidebars', 'entre'); ?></h3>
							<div class="mkd-page-form-section">
								<div class="mkd-field-desc">
									<h4><?php esc_html_e('Export', 'entre'); ?></h4>
									<p><?php esc_html_e('Copy the code from this field and save it to a textual file to export your options. Save that textual file somewhere so you can later use it to import options if necessary.', 'entre'); ?></p>
								</div>
								<div class="mkd-section-content">
									<div class="container-fluid">
										<div class="row">
											<div class="col-lg-12">
												<textarea name="export_options" id="export_options" class="form-control mkd-form-element" rows="10" readonly><?php echo mkd_core_export_custom_sidebars(); ?></textarea>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="mkd-page-form-section">
								<div class="mkd-field-desc">
									<h4><?php esc_html_e('Import', 'entre'); ?></h4>
									<p><?php esc_html_e('To import options, just paste the code you previously saved from the "Export" field into this field, and then click the "Import" button.', 'entre'); ?></p>
								</div>
								<div class="mkd-section-content">
									<div class="container-fluid">
										<div class="row">
											<div class="col-lg-12">
												<textarea name="import_custom_sidebars" id="import_custom_sidebars" class="form-control mkd-form-element" rows="10"></textarea>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="mkd-page-form-section">
								<div class="mkd-field-desc">
									<button type="button" class="btn btn-primary btn-sm " name="import" id="mkd-import-custom-sidebars-btn"><?php esc_html_e('Import', 'entre'); ?></button>
									<?php wp_nonce_field('mkd_import_custom_sidebars_secret_value', 'mkd_import_custom_sidebars_secret', false); ?>
									<span class="mkd-bckp-message"></span>
								</div>
							</div>
							<div class="mkd-page-form-section mkd-import-button-wrapper">
								<div class="alert alert-warning">
									<strong><?php esc_html_e('Important notes:', 'entre') ?></strong>
									<ul>
										<li><?php esc_html_e('Please note that import process will override all your existing custom sidebars.', 'entre'); ?></li>
									</ul>
								</div>
							</div>
						</div>
						<div class="mkd-page-form-section-holder">
							<h3 class="mkd-page-section-title"><?php esc_html_e('Export/Import Widgets', 'entre'); ?></h3>
							<div class="mkd-page-form-section">
								<div class="mkd-field-desc">
									<h4><?php esc_html_e('Export', 'entre'); ?></h4>
									<p><?php esc_html_e('Copy the code from this field and save it to a textual file to export your options. Save that textual file somewhere so you can later use it to import options if necessary.', 'entre'); ?></p>
								</div>
								<div class="mkd-section-content">
									<div class="container-fluid">
										<div class="row">
											<div class="col-lg-12">
												<textarea name="export_widgets" id="export_widgets" class="form-control mkd-form-element" rows="10" readonly><?php echo mkd_core_export_widgets_sidebars(); ?></textarea>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="mkd-page-form-section">
								<div class="mkd-field-desc">
									<h4><?php esc_html_e('Import', 'entre'); ?></h4>
									<p><?php esc_html_e('To import options, just paste the code you previously saved from the "Export" field into this field, and then click the "Import" button.', 'entre'); ?></p>
								</div>
								<div class="mkd-section-content">
									<div class="container-fluid">
										<div class="row">
											<div class="col-lg-12">
												<textarea name="import_widgets" id="import_widgets" class="form-control mkd-form-element" rows="10"></textarea>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="mkd-page-form-section">
								<div class="mkd-field-desc">
									<button type="button" class="btn btn-primary btn-sm " name="import" id="mkd-import-widgets-btn"><?php esc_html_e('Import', 'entre'); ?></button>
									<?php wp_nonce_field('mkd_import_widgets_secret_value', 'mkd_import_widgets_secret', false); ?>
									<span class="mkd-bckp-message"></span>
								</div>
							</div>
							<div class="mkd-page-form-section mkd-import-button-wrapper">
								<div class="alert alert-warning">
									<strong><?php esc_html_e('Important notes:', 'entre') ?></strong>
									<ul>
										<li><?php esc_html_e('Please note that import process will override all your existing widgets.', 'entre'); ?></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>