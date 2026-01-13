<?php

//if accessed directly exit
if(!defined('ABSPATH')) exit;

class MikadoSkin extends EntreMikadoSkinAbstract {
    /**
     * Skin constructor. Hooks to entre_mikado_admin_scripts_init and entre_mikado_enqueue_admin_styles
     */
    public function __construct() {
        $this->skinName = 'mikado';

        //hook to
        add_action('entre_mikado_admin_scripts_init', array($this, 'registerStyles'));
        add_action('entre_mikado_admin_scripts_init', array($this, 'registerScripts'));

        add_action('entre_mikado_enqueue_admin_styles', array($this, 'enqueueStyles'));
        add_action('entre_mikado_enqueue_admin_scripts', array($this, 'enqueueScripts'));

        add_action('entre_mikado_enqueue_meta_box_styles', array($this, 'enqueueStyles'));
        add_action('entre_mikado_enqueue_meta_box_scripts', array($this, 'enqueueScripts'));

		add_action( 'admin_enqueue_scripts', array( $this, 'setShortcodeJSParams' ), 5 ); // 5 is set to be same permission as Gutenberg plugin have
    }

    /**
     * Method that registers skin scripts
     */
	public function registerScripts() {

        //This part is required for field type address
        $enable_google_map_in_admin = apply_filters('entre_mikado_google_maps_in_backend', false);
        if($enable_google_map_in_admin) {
            //include google map api script
            $google_maps_api_key          = entre_mikado_options()->getOptionValue( 'google_maps_api_key' );
            $google_maps_extensions       = '';
            $google_maps_extensions_array = apply_filters( 'entre_mikado_google_maps_extensions_array', array() );
            if ( ! empty( $google_maps_extensions_array ) ) {
                $google_maps_extensions .= '&libraries=';
                $google_maps_extensions .= implode( ',', $google_maps_extensions_array );
            }
            if ( ! empty( $google_maps_api_key ) ) {
                wp_register_script( 'mkd-admin-maps', '//maps.googleapis.com/maps/api/js?key=' . esc_attr( $google_maps_api_key ) . $google_maps_extensions, array(), false, true );
                $this->scripts['jquery.geocomplete.min'] = array(
                    'path'       => 'assets/js/mkd-ui/jquery.geocomplete.min.js',
                    'dependency' => array( 'mkd-admin-maps' )
                );
            }
        }

		$this->scripts['bootstrap.min']          = array(
			'path'       => 'assets/js/bootstrap.min.js',
			'dependency' => array()
		);
		$this->scripts['jquery.nouislider.min']  = array(
			'path'       => 'assets/js/mkd-ui/jquery.nouislider.min.js',
			'dependency' => array()
		);
		$this->scripts['mkd-ui-admin']         = array(
			'path'       => 'assets/js/mkd-ui/mkd-ui.js',
			'dependency' => array()
		);
		$this->scripts['mkd-bootstrap-select'] = array(
			'path'       => 'assets/js/mkd-ui/mkd-bootstrap-select.min.js',
			'dependency' => array()
		);
		$this->scripts['select2']                = array(
			'path'       => 'assets/js/mkd-ui/select2.min.js',
			'dependency' => array()
		);

		foreach ( $this->scripts as $scriptHandle => $script ) {
			entre_mikado_register_skin_script( $scriptHandle, $script['path'], $script['dependency'] );
		}
	}

    /**
     * Method that registers skin styles
     */
    public function registerStyles() {
        $this->styles['mkd-bootstrap'] = 'assets/css/mkd-bootstrap.css';
        $this->styles['mkd-page-admin'] = 'assets/css/mkd-page.css';
        $this->styles['mkd-options-admin'] = 'assets/css/mkd-options.css';
        $this->styles['mkd-meta-boxes-admin'] = 'assets/css/mkd-meta-boxes.css';
        $this->styles['mkd-ui-admin'] = 'assets/css/mkd-ui/mkd-ui.css';
        $this->styles['mkd-forms-admin'] = 'assets/css/mkd-forms.css';
        $this->styles['mkd-import'] = 'assets/css/mkd-import.css';
        $this->styles['font-awesome-admin'] = 'assets/css/font-awesome/css/font-awesome.min.css';
        $this->styles['select2'] = 'assets/css/select2.min.css';

        foreach ($this->styles as $styleHandle => $stylePath) {
            entre_mikado_register_skin_style($styleHandle, $stylePath);
        }
    }

    /**
     * Method that renders options page
     *
     * @see MikadoSkin::getHeader()
     * @see MikadoSkin::getPageNav()
     * @see MikadoSkin::getPageContent()
     */
    public function renderOptions() {
        global $entre_mikado_Framework;
        $tab    		= entre_mikado_get_admin_tab();
        $active_page 	= $entre_mikado_Framework->mkdOptions->getAdminPageFromSlug($tab);
        $current_theme 	= wp_get_theme();

        if ($active_page == null) return;
        ?>
        <div class="mkd-options-page mkd-page">
            <?php $this->getHeader($current_theme->get('Name'), $current_theme->get('Version')); ?>
            <div class="mkd-page-content-wrapper">
                <div class="mkd-page-content">
                    <div class="mkd-page-navigation mkd-tabs-wrapper vertical left clearfix">
                        <?php $this->getPageNav($tab); ?>
                        <?php $this->getPageContent($active_page, $tab); ?>
                    </div>
                </div>
            </div>
        </div>
        <a id='back_to_top' href='#'>
            <span class="fa-stack">
                <span class="fa fa-angle-up"></span>
            </span>
        </a>
    <?php }

    /**
     * Method that renders header of options page.
     * @param string $themeName - theme name to display
     * @param string $themeVersion -  version to display
     * @param bool $showSaveButton - whether to show save button or not
     *
     * @see EntreMikadoSkinAbstract::loadTemplatePart()
     */
    public function getHeader($themeName, $themeVersion, $showSaveButton = true) {
        $this->loadTemplatePart('header', array(
            'themeName' => $themeName,
            'themeVersion' => $themeVersion,
            'showSaveButton' => $showSaveButton)
        );
    }

    /**
     * Method that loads page navigation
     * @param string $tab current tab
     * @param bool $isImportPage if is import page highlighted that tab
     *
     * @see EntreMikadoSkinAbstract::loadTemplatePart()
     */
    public function getPageNav($tab, $isImportPage = false, $isBackupOptionsPage = false) {
        $this->loadTemplatePart('navigation', array(
            'tab' => $tab,
            'isImportPage' => $isImportPage,
            'isBackupOptionsPage' => $isBackupOptionsPage
        ));
    }

    /**
     * Method that loads current page content
     *
     * @param EntreMikadoAdminPage $page current page to load
     * @param string $tab current page slug
     * @param bool $showAnchors whether to show anchors template or not
     *
     * @see EntreMikadoSkinAbstract::loadTemplatePart()
     */
    public function getPageContent($page, $tab, $showAnchors = true) {
        $this->loadTemplatePart('content', array(
            'page' => $page,
            'tab' => $tab,
            'showAnchors' => $showAnchors
        ));
    }

    /**
     * Method that loads content for import page
     */
    public function getImportContent() {
        $this->loadTemplatePart('content-import');
    }

	/**
     * Method that loads content for import page
     */
    public function getBackupOptionsContent() {
        $this->loadTemplatePart('backup-options');
    }

    /**
     * Method that loads anchors and save button template part
     *
	 * @param EntreMikadoAdminPage $page current page to load
     *
     * @see EntreMikadoSkinAbstract::loadTemplatePart()
     */
    public function getAnchors($page) {
        $this->loadTemplatePart('anchors', array('page' => $page));
    }

	/**
	 * Method that renders backup options page
	 *
	 * @see MikadoSkin::getHeader()
	 * * @see MikadoSkin::getPageNav()
	 * * @see MikadoSkin::getImportContent()
	 */
	public function renderBackupOptions() { ?>
		<div class="mkd-options-page mkd-page">
			<?php $this->getHeader(entre_mikado_get_theme_info_item('Name'), entre_mikado_get_theme_info_item('Version'), false); ?>
			<div class="mkd-page-content-wrapper">
				<div class="mkd-page-content">
					<div class="mkd-page-navigation mkd-tabs-wrapper vertical left clearfix">
						<?php $this->getPageNav('backup_options', false, true); ?>
						<?php $this->getBackupOptionsContent(); ?>
					</div>
				</div>
			</div>
		</div>
	<?php }

    /**
     * Method that renders import page
     *
     * @see MikadoSkin::getHeader()
     * * @see MikadoSkin::getPageNav()
     * * @see MikadoSkin::getImportContent()
     */
    public function renderImport() { ?>
        <div class="mkd-options-page mkd-page">
            <?php $this->getHeader(entre_mikado_get_theme_info_item('Name'), entre_mikado_get_theme_info_item('Version'), false); ?>
            <div class="mkd-page-content-wrapper">
                <div class="mkd-page-content">
                    <div class="mkd-page-navigation mkd-tabs-wrapper vertical left clearfix">
                        <?php $this->getPageNav('tabimport', true); ?>
                        <?php $this->getImportContent(); ?>
                    </div>
                </div>
            </div>
        </div>
    <?php }
}
?>
