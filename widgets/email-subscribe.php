<?php
/**
 * WordPress Nav Menu Widget
 *
 * @package dtbaker-elementor
 */

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) { exit; // Exit if accessed directly
}

/**
 * Creates our custom Elementor widget
 *
 * Class Widget_Dtbaker_WP_Menu
 *
 * @package Elementor
 */
class Widget_Dtbaker_Email_Subscribe extends Widget_Base {


    public function __construct( array $data = [], array $args = null ) {

	    wp_enqueue_style( 'stylepress-email', DTBAKER_ELEMENTOR_URI . 'widgets/email-subscribe/subscribe.css', false );
	    wp_enqueue_script( 'stylepress-email-script', DTBAKER_ELEMENTOR_URI . 'widgets/email-subscribe/subscribe.js', array('jquery') );

	    wp_localize_script( 'stylepress-email-script', 'stylepress_email',
		    array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );

        parent::__construct( $data, $args );
    }

	/**
	 * Get Widgets name
	 *
	 * @return string
	 */
	public function get_name() {
		return 'stylepress_email_subscribe';
	}

	/**
	 * Get widgets title
	 *
	 * @return string
	 */
	public function get_title() {
		return __( 'Email Subscribe', 'stylepress' );
	}

	/**
	 * Get the current icon for display on frontend.
	 * The extra 'dtbaker-elementor-widget' class is styled differently in frontend.css
	 *
	 * @return string
	 */
	public function get_icon() {
		return 'dtbaker-stylepress-elementor-widget';
	}

	/**
	 * Get available categories for this widget. Which is our own category for page builder options.
	 *
	 * @return array
	 */
	public function get_categories() {
		return [ 'dtbaker-elementor' ];
	}

	/**
	 * We always show this item in the panel.
	 *
	 * @return bool
	 */
	public function show_in_panel() {
		return true;
	}

	/**
	 * This registers our controls for the widget. Currently there are none but we may add options down the track.
	 */
	protected function _register_controls() {

		$this->start_controls_section(
			'section_dtbaker_wp_menu',
			[
				'label' => __( 'Email Subscribe', 'stylepress' ),
			]
		);



		$this->add_control(
			'desc',
			[
				'label' => __( 'Create an API Key from <a href="https://admin.mailchimp.com/account/api/" target="_blank">https://admin.mailchimp.com/account/api/</a> and find your List ID from the "Lists" page..', 'stylepress' ),
				'type' => Controls_Manager::RAW_HTML,
			]
		);


		$this->add_control(
			'mailchimp_api_key',
			[
				'label'   => esc_html__( 'MailChimp API Key', 'stylepress' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '',
				'placeholder' => __( 'Enter your API Key.', 'stylepress' ),
			]
		);

		$this->add_control(
			'mailchimp_list_id',
			[
				'label'   => esc_html__( 'MailChimp List ID', 'stylepress' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '',
				'placeholder' => __( 'Enter your List ID.', 'stylepress' ),
			]
		);


		$this->add_control(
			'thank_you',
			[
				'label'   => esc_html__( 'Thank You Message', 'stylepress' ),
				'type'    => Controls_Manager::TEXT,
				'default' => 'Subscribed. Please check your email.',
				'placeholder' => __( 'Thank You.', 'stylepress' ),
			]
		);


		$this->end_controls_section();

		do_action( 'stylepress_email_subscribe_options', $this );

	}


	/**
	 * Render our custom menu onto the page.
	 */
	protected function render() {
		$settings = $this->get_settings();
		ob_start();
		?>
        <div class="stylepress-email-subscribe" data-elm="<?php echo $this->get_id();?>" data-post="<?php echo get_the_ID();?>">
            <div class="loading"></div>
            <div class="stylepress-email-status"></div>
            <input type="email" name="email" value="" placeholder="Your Email" class="stylepress-subscribe-email">
            <input type="button" name="subscribe" value="Subscribe" class="stylepress-subscribe-send">
        </div>
        <?php
        echo apply_filters('stylepress_email_form',ob_get_clean());

	}

	/**
	 * This is outputted while rending the page.
	 */
	protected function content_template() {
		?>
		<div class="stylepress-email-subscribe">
		Email Subscribe Form Here
		</div>
		<?php
	}

}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_Dtbaker_Email_Subscribe() );