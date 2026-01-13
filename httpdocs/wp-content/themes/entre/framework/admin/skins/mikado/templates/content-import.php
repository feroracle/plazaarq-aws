<div class="mkd-tabs-content">
	<div class="tab-content">
		<div class="tab-pane fade in active" id="import">
			<div class="mkd-tab-content">
				<h2 class="mkd-page-title"><?php esc_html_e('Import', 'entre'); ?></h2>
				<form method="post" class="mkd_ajax_form mkd-import-page-holder" data-confirm-message="<?php esc_html_e('Are you sure, you want to import Demo Data now?', 'entre'); ?>">
					<div class="mkd-page-form">
						<div class="mkd-page-form-section-holder">
							<h3 class="mkd-page-section-title"><?php esc_html_e('Import Demo Content', 'entre'); ?></h3>
							<div class="mkd-page-form-section">
								<div class="mkd-field-desc">
									<h4><?php esc_html_e('Import', 'entre'); ?></h4>
									<p><?php esc_html_e('Choose demo content you want to import', 'entre'); ?></p>
								</div>
								<div class="mkd-section-content">
									<div class="container-fluid">
										<div class="row">
											<div class="col-lg-3">
												<select name="import_example" id="import_example" class="form-control mkd-form-element dependence">
													<option value="entre"><?php esc_html_e('Entre', 'entre'); ?></option>
												</select>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="mkd-page-form-section">
								<div class="mkd-field-desc">
									<h4><?php esc_html_e('Import Type', 'entre'); ?></h4>
									<p><?php esc_html_e('Import Type', 'entre'); ?></p>
								</div>
								<div class="mkd-section-content">
									<div class="container-fluid">
										<div class="row">
											<div class="col-lg-3">
												<select name="import_option" id="import_option" class="form-control mkd-form-element">
													<option value=""><?php esc_html_e('Please Select', 'entre'); ?></option>
													<option value="complete_content"><?php esc_html_e('All', 'entre'); ?></option>
													<option value="content"><?php esc_html_e('Content', 'entre'); ?></option>
													<option value="widgets"><?php esc_html_e('Widgets', 'entre'); ?></option>
													<option value="options"><?php esc_html_e('Options', 'entre'); ?></option>
												</select>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="mkd-page-form-section">
								<div class="mkd-field-desc">
									<h4><?php esc_html_e('Import attachments', 'entre'); ?></h4>
									<p><?php esc_html_e('Do you want to import media files?', 'entre'); ?></p>
								</div>
								<div class="mkd-section-content">
									<div class="container-fluid">
										<div class="row">
											<div class="col-lg-12">
												<p class="field switch">
													<label class="cb-enable dependence"><span><?php esc_html_e('Yes', 'entre'); ?></span></label>
													<label class="cb-disable selected dependence"><span><?php esc_html_e('No', 'entre'); ?></span></label>
													<input type="checkbox" id="import_attachments" class="checkbox" name="import_attachments" value="1">
												</p>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="mkd-page-form-section">
								<div class="mkd-field-desc">
									<input type="submit" class="btn btn-primary btn-sm " value="<?php esc_html_e('Import', 'entre'); ?>" name="import" id="mkd-import-demo-data" />
								</div>
								<div class="mkd-section-content">
									<div class="container-fluid">
										<div class="row">
											<div class="col-lg-12">
												<div class="mkd-import-load"><span><?php esc_html_e('The import process may take some time. Please be patient.', 'entre') ?> </span><br />
													<div class="mkd-progress-bar-wrapper html5-progress-bar">
														<div class="progress-bar-wrapper">
															<progress id="progressbar" value="0" max="100"></progress>
														</div>
														<div class="progress-value">0%</div>
														<div class="progress-bar-message">
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="mkd-page-form-section mkd-import-button-wrapper">
								<div class="alert alert-warning">
									<strong><?php esc_html_e('Important notes:', 'entre') ?></strong>
									<ul>
										<li><?php esc_html_e('Please note that import process will take time needed to download all attachments from demo web site.', 'entre'); ?></li>
										<li> <?php esc_html_e('If you plan to use shop, please install WooCommerce before you run import.', 'entre')?></li>
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