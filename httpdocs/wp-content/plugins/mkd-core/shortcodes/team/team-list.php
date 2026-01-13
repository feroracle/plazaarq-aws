<?php
namespace MikadoCore\CPT\Shortcodes\Team;

use MikadoCore\Lib;
/**
 * Class Team
 */
class Team implements Lib\ShortcodeInterface
{
    /**
     * @var string
     */
    private $base;

    public function __construct() {
        $this->base = 'mkd_team';

        add_action('vc_before_init', array($this, 'vcMap'));
    }

    /**
     * Returns base for shortcode
     * @return string
     */
    public function getBase() {
        return $this->base;
    }

    /**
     * Maps shortcode to Visual Composer. Hooked on vc_before_init
     *
     * @see mkd_core_get_carousel_slider_array_vc()
     */
    public function vcMap()	{

        $team_social_icons_array = array();
        for ($x = 1; $x<6; $x++) {
            $teamIconCollections = entre_mikado_icon_collections()->getCollectionsWithSocialIcons();
            foreach($teamIconCollections as $collection_key => $collection) {

                $team_social_icons_array[] = array(
                    'type' => 'dropdown',
                    'heading' => esc_html__('Social Icon ', 'mkd-core') .$x,
                    'param_name' => 'team_social_'.$collection->param.'_'.$x,
                    'value' => $collection->getSocialIconsArrayVC(),
                    'dependency' => Array('element' => 'team_social_icon_pack', 'value' => array($collection_key))
                );

            }

            $team_social_icons_array[] = array(
                'type' => 'textfield',
                'heading' => esc_html__('Social Icon ', 'mkd-core').$x. esc_html__(' Link', 'mkd-core'),
                'param_name' => 'team_social_icon_'.$x.'_link',
                'dependency' => array('element' => 'team_social_icon_pack', 'value' => entre_mikado_icon_collections()->getIconCollectionsKeys())
            );

            $team_social_icons_array[] = array(
                'type' => 'dropdown',
                'heading' => esc_html__('Social Icon ', 'mkd-core').$x. esc_html__(' Target', 'mkd-core'),
                'param_name' => 'team_social_icon_'.$x.'_target',
                'value' => array(
                    '' => '',
                    esc_html__('Self', 'mkd-core') => '_self',
                    esc_html__('Blank', 'mkd-core') => '_blank'
                ),
                'dependency' => Array('element' => 'team_social_icon_'.$x.'_link', 'not_empty' => true)
            );

        }

        vc_map( array(
            'name' => esc_html__('Mikado Team', 'mkd-core'),
            'base' => $this->base,
            'category' => 'by MIKADO',
            'icon' => 'icon-wpb-team extended-custom-icon',
            'allowed_container_element' => 'vc_row',
            'params' => array_merge(
                array(
                    array(
                        'type' => 'dropdown',
                        'admin_label' => true,
                        'heading' => esc_html__('Layout type', 'mkd-core'),
                        'param_name' => 'type',
                        'value' => array(
                            esc_html__('Info below' ,'mkd-core')    => 'below-image',
                            esc_html__('Info on hover','mkd-core')  => 'on-hover'
                        ),
                    ),
                    array(
                        'type' => 'dropdown',
                        'admin_label' => true,
                        'heading' => esc_html__('Skin', 'mkd-core'),
                        'param_name' => 'skin',
                        'value' => array(
                            esc_html__('Default' ,'mkd-core')    => '',
                            esc_html__('Light' ,'mkd-core')    => 'light',
                            esc_html__('Dark','mkd-core')  => 'dark'
                        ),
                        'dependency' => array('element' => 'type', 'value' => array('below-image')),
                        'save_always' => true
                    ),
                    array(
                        'type' => 'attach_image',
                        'heading' => esc_html__('Image', 'mkd-core'),
                        'param_name' => 'team_image'
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__('Name', 'mkd-core'),
                        'admin_label' => true,
                        'param_name' => 'team_name'
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__('Name Tag', 'mkd-core'),
                        'param_name' => 'team_name_tag',
                        'value' => array(
                            esc_html__( 'Default', 'mkd-core' ) => '',
                            'h2' => 'h2',
                            'h3' => 'h3',
                            'h4' => 'h4',
                            'h5' => 'h5',
                            'h6' => 'h6',
                        ),
                        'dependency' => array('element' => 'team_name', 'not_empty' => true)
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__('Email', 'mkd-core'),
                        'admin_label' => true,
                        'param_name' => 'team_email'
                    ),
                    array(
                        'type'       => 'colorpicker',
                        'param_name' => 'email_color',
                        'heading'    => esc_html__( 'Email Text Color', 'mkd-core' )
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__('Position', 'mkd-core'),
                        'admin_label' => true,
                        'param_name' => 'team_position'
                    ),
                    array(
                        'type'       => 'colorpicker',
                        'param_name' => 'position_color',
                        'heading'    => esc_html__( 'Position Text Color', 'mkd-core' )
                    ),
                    array(
                        'type' => 'textarea',
                        'heading' => esc_html__('Description', 'mkd-core'),
                        'admin_label' => true,
                        'param_name' => 'team_description'
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__('Social Icon Pack', 'mkd-core'),
                        'param_name' => 'team_social_icon_pack',
                        'admin_label' => true,
                        'value' => array_merge(array('' => ''),entre_mikado_icon_collections()->getIconCollectionsVCExclude(array('dripicons', 'linea_icons','linear_icons'))),
                        'save_always' => true
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__('Social Icons Type', 'mkd-core'),
                        'param_name' => 'team_social_icon_type',
                        'value' => array(
                            esc_html__('Normal', 'mkd-core') => 'normal',
                            esc_html__('Circle', 'mkd-core') => 'circle',
                            esc_html__('Square', 'mkd-core') => 'square'
                        ),
                        'save_always' => true,
                        'dependency' => array('element' => 'team_social_icon_pack', 'value' => entre_mikado_icon_collections()->getIconCollectionsKeys())
                    ),
                ),
                $team_social_icons_array
            )
        ) );

    }

    /**
     * Renders shortcodes HTML
     *
     * @param $atts array of shortcode params
     * @param $content string shortcode content
     * @return string
     */
    public function render($atts, $content = null)
    {

        $args = array(
            'type' => 'below-image',
            'team_image' => '',
            'skin' => '',
            'team_name' => '',
            'team_name_tag' => 'h4',
            'team_email' => '',
            'email_color' => '',
            'team_position' => '',
            'position_color' => '',
            'team_description' => '',
            'team_social_icon_pack' => '',
            'team_social_icon_type' => 'normal_social'
        );

        $team_social_icons_form_fields = array();
        $number_of_social_icons = 5;

        for ($x = 1; $x <= $number_of_social_icons; $x++) {

            foreach (entre_mikado_icon_collections()->iconCollections as $collection_key => $collection) {
                $team_social_icons_form_fields['team_social_' . $collection->param . '_' . $x] = '';
            }

            $team_social_icons_form_fields['team_social_icon_'.$x.'_link'] = '';
            $team_social_icons_form_fields['team_social_icon_'.$x.'_target'] = '';

        }

        $args = array_merge($args, $team_social_icons_form_fields);

        $params = shortcode_atts($args, $atts);

        $params['number_of_social_icons'] = 5;
        $params['team_name_tag'] = $this->getTeamNameTag($params, $args);
        $params['team_social_icons'] = $this->getTeamSocialIcons($params);
        $params['position_styles'] = $this->getPositionStyles($params);
        $params['email_styles'] = $this->getEmailStyles($params);

        //Get HTML from template based on type of team
        $html = mkd_core_get_shortcode_module_template_part('templates/main-info-'.$params['type'], 'team', '', $params);

        return $html;

    }

    /**
     * Return correct heading value. If provided heading isn't valid get the default one
     *
     * @param $params
     * @return mixed
     */
    private function getTeamNameTag($params, $args) {

        $headings_array = array('h2', 'h3', 'h4', 'h5', 'h6');
        return (in_array($params['team_name_tag'], $headings_array)) ? $params['team_name_tag'] : $args['team_name_tag'];

    }

    private function getPositionStyles( $params ) {
        $styles = array();

        if ( ! empty( $params['position_color'] ) ) {
            $styles[] = 'color: ' . $params['position_color'];
        }

        return implode( ';', $styles );
    }

    private function getEmailStyles( $params ) {
        $styles = array();

        if ( ! empty( $params['email_color'] ) ) {
            $styles[] = 'color: ' . $params['email_color'];
        }

        return implode( ';', $styles );
    }

    private function getTeamSocialIcons($params) {

        extract($params);
        $social_icons = array();

        if ($team_social_icon_pack !== '') {

            $icon_pack = entre_mikado_icon_collections()->getIconCollection($team_social_icon_pack);
            $team_social_icon_type_label = 'team_social_' . $icon_pack->param;
            $team_social_icon_param_label = $icon_pack->param;

            for ( $i = 1; $i <= $number_of_social_icons; $i++ ) {

                $team_social_icon = ${$team_social_icon_type_label . '_' . $i};
                $team_social_link = ${'team_social_icon_' . $i . '_link'};
                $team_social_target = ${'team_social_icon_' . $i . '_target'};

                if ($team_social_icon !== '') {

                    $team_icon_params = array();
                    $team_icon_params['icon_pack'] = $team_social_icon_pack;
                    $team_icon_params[$team_social_icon_param_label] =   $team_social_icon;
                    $team_icon_params['link'] = ($team_social_link !== '') ? $team_social_link : '';
                    $team_icon_params['target'] = ($team_social_target !== '') ? $team_social_target : '';
                    $team_icon_params['type'] = ($team_social_icon_type !== '') ? $team_social_icon_type : '';



                    $social_icons[] = entre_mikado_execute_shortcode('mkd_icon', $team_icon_params);
                }

            }

        }

        return $social_icons;

    }

}