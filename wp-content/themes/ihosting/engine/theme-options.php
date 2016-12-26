<?php
/**
 * ReduxFramework Sample Config File
 * For full documentation, please visit: https://github.com/ReduxFramework/ReduxFramework/wiki
 * */

if ( !class_exists( 'TheOne_Redux_Framework_config' ) ) {

	class TheOne_Redux_Framework_config
	{

		public $args     = array();
		public $sections = array();
		public $theme;
		public $ReduxFramework;

		public function __construct() {

			if ( !class_exists( "ReduxFramework" ) ) {
				return;
			}

			$this->initSettings();
		}

		public function initSettings() {

			// Just for demo purposes. Not needed per say.
			$this->theme = wp_get_theme();

			// Set the default arguments
			$this->setArguments();

			// Set a few help tabs so you can see how it's done
			$this->setHelpTabs();

			// Create the sections and fields
			$this->setSections();

			if ( !isset( $this->args['opt_name'] ) ) { // No errors please
				return;
			}

			// If Redux is running as a plugin, this will remove the demo notice and links
			//add_action( 'redux/loaded', array( $this, 'remove_demo' ) );

			// Function to test the compiler hook and demo CSS output.
			//add_filter('redux/options/'.$this->args['opt_name'].'/compiler', array( $this, 'compiler_action' ), 10, 2);
			// Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
			// Change the arguments after they've been declared, but before the panel is created
			//add_filter('redux/options/'.$this->args['opt_name'].'/args', array( $this, 'change_arguments' ) );
			// Change the default value of a field after it's been set, but before it's been useds
			//add_filter('redux/options/'.$this->args['opt_name'].'/defaults', array( $this,'change_defaults' ) );
			// Dynamically add a section. Can be also used to modify sections/fields
			add_filter( 'redux/options/' . $this->args['opt_name'] . '/sections', array( $this, 'dynamic_section' ) );

			$this->ReduxFramework = new ReduxFramework( $this->sections, $this->args );
		}

		/**
		 *
		 * This is a test function that will let you see when the compiler hook occurs.
		 * It only runs if a field   set with compiler=>true is changed.
		 * */
		function compiler_action( $options, $css ) {

		}

		function ts_redux_update_options_user_can_register( $options, $css ) {
			global $ihosting;
			$users_can_register = isset( $ihosting['opt-users-can-register'] ) ? $ihosting['opt-users-can-register'] : 0;
			update_option( 'users_can_register', $users_can_register );
		}

		/**
		 *
		 * Custom function for filtering the sections array. Good for child themes to override or add to the sections.
		 * Simply include this function in the child themes functions.php file.
		 *
		 * NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
		 * so you must use get_template_directory_uri() if you want to use any of the built in icons
		 * */
		function dynamic_section( $sections ) {
			//$sections = array();
			$sections[] = array(
				'title'  => esc_html__( 'Section via hook', 'ihosting' ),
				'desc'   => wp_kses( __( '<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'ihosting' ), array( 'p' => array( 'class' => array() ) ) ),
				'icon'   => 'el-icon-paper-clip',
				// Leave this as a blank section, no options just some intro text set above.
				'fields' => array(),
			);

			return $sections;
		}

		/**
		 *
		 * Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.
		 * */
		function change_arguments( $args ) {
			//$args['dev_mode'] = true;

			return $args;
		}

		/**
		 *
		 * Filter hook for filtering the default value of any given field. Very useful in development mode.
		 * */
		function change_defaults( $defaults ) {
			$defaults['str_replace'] = "Testing filter hook!";

			return $defaults;
		}

		// Remove the demo link and the notice of integrated demo from the redux-framework plugin
		function remove_demo() {

			// Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
			if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
				remove_filter( 'plugin_row_meta', array( ReduxFrameworkPlugin::instance(), 'plugin_metalinks' ), null, 2 );

				// Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
				remove_action( 'admin_notices', array( ReduxFrameworkPlugin::instance(), 'admin_notices' ) );

			}
		}

		public function setSections() {

			/**
			 * Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
			 * */
			// Background Patterns Reader
			$sample_patterns_path = ReduxFramework::$_dir . '../sample/patterns/';
			$sample_patterns_url = ReduxFramework::$_url . '../sample/patterns/';
			$sample_patterns = array();

			if ( is_dir( $sample_patterns_path ) ) :

				if ( $sample_patterns_dir = opendir( $sample_patterns_path ) ) :
					$sample_patterns = array();

					while ( ( $sample_patterns_file = readdir( $sample_patterns_dir ) ) !== false ) {

						if ( stristr( $sample_patterns_file, '.png' ) !== false || stristr( $sample_patterns_file, '.jpg' ) !== false ) {
							$name = explode( ".", $sample_patterns_file );
							$name = str_replace( '.' . end( $name ), '', $sample_patterns_file );
							$sample_patterns[] = array( 'alt' => $name, 'img' => $sample_patterns_url . $sample_patterns_file );
						}
					}
				endif;
			endif;

			ob_start();

			$ct = wp_get_theme();
			$this->theme = $ct;
			$item_name = $this->theme->get( 'Name' );
			$tags = $this->theme->Tags;
			$screenshot = $this->theme->get_screenshot();
			$class = $screenshot ? 'has-screenshot' : '';

			$customize_title = sprintf( __( 'Customize &#8220;%s&#8221;', 'ihosting' ), $this->theme->display( 'Name' ) );
			?>
			<div id="current-theme" class="<?php echo esc_attr( $class ); ?>">
				<?php if ( $screenshot ) : ?>
					<?php if ( current_user_can( 'edit_theme_options' ) ) : ?>
						<a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize"
						   title="<?php echo esc_attr( $customize_title ); ?>">
							<img src="<?php echo esc_url( $screenshot ); ?>"
							     alt="<?php esc_attr_e( 'Current theme preview', 'ihosting' ); ?>"/>
						</a>
					<?php endif; ?>
					<img class="hide-if-customize" src="<?php echo esc_url( $screenshot ); ?>"
					     alt="<?php esc_attr_e( 'Current theme preview', 'ihosting' ); ?>"/>
				<?php endif; ?>

				<h4>
					<?php echo sanitize_text_field( $this->theme->display( 'Name' ) ); ?>
				</h4>

				<div>
					<ul class="theme-info">
						<li><?php printf( __( 'By %s', 'ihosting' ), $this->theme->display( 'Author' ) ); ?></li>
						<li><?php printf( __( 'Version %s', 'ihosting' ), $this->theme->display( 'Version' ) ); ?></li>
						<li><?php echo '<strong>' . esc_html__( 'Tags', 'ihosting' ) . ':</strong> '; ?><?php printf( $this->theme->display( 'Tags' ) ); ?></li>
					</ul>
					<p class="theme-description"><?php echo esc_attr( $this->theme->display( 'Description' ) ); ?></p>
					<?php
					if ( $this->theme->parent() ) {
						printf(
							' <p class="howto">' . wp_kses( __( 'This <a href="%1$s">child theme</a> requires its parent theme, %2$s.', 'ihosting' ), array( 'a' => array( 'href' => array() ) ) ) . '</p>', esc_html__( 'http://codex.wordpress.org/Child_Themes', 'ihosting' ), $this->theme->parent()
							                                                                                                                                                                                                                                                                  ->display( 'Name' )
						);
					}
					?>

				</div>

			</div>

			<?php
			$item_info = ob_get_contents();

			ob_end_clean();

			$sampleHTML = '';

			$color_options = array(
				'show_input'             => true,
				'show_initial'           => true,
				'show_alpha'             => false,
				'show_palette'           => true,
				'show_palette_only'      => false,
				'show_selection_palette' => true,
				'max_palette_size'       => 10,
				'allow_empty'            => true,
				'clickout_fires_change'  => false,
				'choose_text'            => esc_html__( 'Choose', 'ihosting' ),
				'cancel_text'            => esc_html__( 'Cancel', 'ihosting' ),
				'show_buttons'           => true,
				'use_extended_classes'   => true,
				'palette'                => array(
					'#bda47d', '#ffffff', '#000000'
				),
				'input_text'             => esc_html__( 'Select Color', 'ihosting' ),
			);

			/*--General Settings--*/
			$this->sections[] = array(
				'icon'   => 'el-icon-cogs',
				'title'  => esc_html__( 'General Settings', 'ihosting' ),
				'fields' => array(
					array(
						'id'    => 'opt_general_introduction',
						'type'  => 'info',
						'style' => 'success',
						'title' => esc_html__( 'Welcome to iHosting Theme Option Panel', 'ihosting' ),
						'icon'  => 'el-icon-info-sign',
						'desc'  => esc_html__( 'From here you can config iHosting theme in the way you need.', 'ihosting' ),
					),
					array(
						'id'       => 'opt_general_logo',
						'type'     => 'media',
						'url'      => true,
						'title'    => esc_html__( 'Logo', 'ihosting' ),
						'compiler' => 'true',
						//'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
						'desc'     => esc_html__( 'Upload your logo image', 'ihosting' ),
						'subtitle' => esc_html__( 'Upload your custom logo image', 'ihosting' ),
						'default'  => array( 'url' => get_template_directory_uri() . '/assets/images/logo.png' ),
					),
					array(
						'id'       => 'opt_general_favicon',
						'type'     => 'media',
						'title'    => esc_html__( 'Favicon', 'ihosting' ),
						'desc'     => esc_html__( 'Upload a 16x16px .png or .gif image that will be your favicon.', 'ihosting' ),
						'subtitle' => esc_html__( 'Upload your custom favicon image', 'ihosting' ),
						'default'  => array( 'url' => get_template_directory_uri() . '/assets/images/favicon.png' ),

					),
					array(
						'id'       => 'opt_general_accent_color',
						'type'     => 'color_rgba',
						'title'    => esc_html__( 'Base color', 'ihosting' ),
						'subtitle' => esc_html__( 'Base color for all pages on the frontend', 'ihosting' ),
						'default'  => array(
							'color' => '#eec15b', // Contruction design
							'alpha' => 1,
						),
						'options'  => $color_options,
					),
					array(
						'id'                    => 'opt_body_bg',
						'type'                  => 'background',
						'title'                 => esc_html__( 'Body Background', 'ihosting' ),
						'subtitle'              => esc_html__( 'Body background with image pattern, color, etc.', 'ihosting' ),
						'transparent'           => false,
						'background-repeat'     => false,
						'background-attachment' => false,
						'background-position'   => false,
						'background-clip'       => false,
						'background-origin'     => false,
						'background-size'       => false,
						'default'               => array(
							'background-color' => '#ffffff',
						),
						'output'                => array( 'body, body:before, body:after' ),
					),
					array(
						'id'                => 'opt_inner_body_bg',
						'type'              => 'background',
						'title'             => esc_html__( 'Inner Body Background', 'ihosting' ),
						'subtitle'          => esc_html__( 'Inner body background with image, color, etc.', 'ihosting' ),
						'background-clip'   => false,
						'background-origin' => false,
						'background-size'   => false,
						'default'           => array(
							'background-color' => '#ffffff',
						),
						'output'            => array( 'body #page, body .site' ),
					),
					array(
						'id'      => 'opt_enable_smooth_scroll',
						'type'    => 'switch',
						'title'   => esc_html__( 'Enable Smooth Scroll', 'ihosting' ),
						'default' => '0',
						'on'      => esc_html__( 'Enable', 'ihosting' ),
						'off'     => esc_html__( 'Disable', 'ihosting' ),
					),
					array(
						'id'      => 'opt_how_to_load_custom_css',
						'type'    => 'button_set',
						'title'   => esc_html__( 'Load Custom CSS', 'ihosting' ),
						'options' => array(
							'wp_head'  => esc_html__( 'On Header', 'ihosting' ),
							'via_ajax' => esc_html__( 'Via Ajax', 'ihosting' ),
						),
						'default' => 'wp_head',
						'multi'   => false,
					),
					array(
						'id'       => 'opt_general_css_code',
						'type'     => 'ace_editor',
						'title'    => esc_html__( 'Custom CSS', 'ihosting' ),
						'subtitle' => esc_html__( 'Paste your custom CSS code here.', 'ihosting' ),
						'mode'     => 'css',
						'theme'    => 'monokai',
						'desc'     => 'Custom css code.',
						'default'  => "",
					),
					array(
						'id'       => 'opt_general_js_code',
						'type'     => 'ace_editor',
						'title'    => esc_html__( 'Custom JS ', 'ihosting' ),
						'subtitle' => esc_html__( 'Paste your custom JS code here.', 'ihosting' ),
						'mode'     => 'javascript',
						'theme'    => 'chrome',
						'desc'     => 'Custom javascript code',
						//'default' => "jQuery(document).ready(function(){\n\n});"
					),
				),
			);

			/*--Typograply Options--*/
			$this->sections[] = array(
				'icon'   => 'el-icon-font',
				'title'  => esc_html__( 'Typography Options', 'ihosting' ),
				'fields' => array(
					array(
						'id'       => 'opt_typography_body_font',
						'type'     => 'typography',
						'title'    => esc_html__( 'Body Font Setting', 'ihosting' ),
						'subtitle' => esc_html__( 'Specify the body font properties.', 'ihosting' ),
						'google'   => true,
						'output'   => 'body',
					),
					array(
						'id'       => 'opt_typography_menu_font',
						'type'     => 'typography',
						'title'    => esc_html__( 'Menu Item Font Setting', 'ihosting' ),
						'subtitle' => esc_html__( 'Specify the menu font properties.', 'ihosting' ),
						'output'   => array( 'nav', '.nav-menu' ),
						'google'   => true,
					),

					array(
						'id'       => 'opt_typography_h1_font',
						'type'     => 'typography',
						'title'    => esc_html__( 'Heading 1(H1) Font Setting', 'ihosting' ),
						'subtitle' => esc_html__( 'Specify the H1 tag font properties.', 'ihosting' ),
						'google'   => true,
						'output'   => 'h1',
					),

					array(
						'id'       => 'opt_typography_h2_font',
						'type'     => 'typography',
						'title'    => esc_html__( 'Heading 2(H2) Font Setting', 'ihosting' ),
						'subtitle' => esc_html__( 'Specify the H2 tag font properties.', 'ihosting' ),
						'google'   => true,
						'output'   => 'h2',
					),

					array(
						'id'       => 'opt_typography_h3_font',
						'type'     => 'typography',
						'title'    => esc_html__( 'Heading 3(H3) Font Setting', 'ihosting' ),
						'subtitle' => esc_html__( 'Specify the H3 tag font properties.', 'ihosting' ),
						'google'   => true,
						'output'   => 'h3',
					),

					array(
						'id'       => 'opt_typography_h4_font',
						'type'     => 'typography',
						'title'    => esc_html__( 'Heading 4(H4) Font Setting', 'ihosting' ),
						'subtitle' => esc_html__( 'Specify the H4 tag font properties.', 'ihosting' ),
						'google'   => true,
						'output'   => 'h4',
					),

					array(
						'id'       => 'opt_typography_h5_font',
						'type'     => 'typography',
						'title'    => esc_html__( 'Heading 5(H5) Font Setting', 'ihosting' ),
						'subtitle' => esc_html__( 'Specify the H5 tag font properties.', 'ihosting' ),
						'google'   => true,
						'output'   => 'h5',
					),

					array(
						'id'       => 'opt_typography_h6_font',
						'type'     => 'typography',
						'title'    => esc_html__( 'Heading 6(H6) Font Setting', 'ihosting' ),
						'subtitle' => esc_html__( 'Specify the H6 tag font properties.', 'ihosting' ),
						'google'   => true,
						'output'   => 'h6',
					),

					array(
						'id'       => 'opt_widget_title_font',
						'type'     => 'typography',
						'title'    => esc_html__( 'Widget Title Font Setting', 'ihosting' ),
						'subtitle' => esc_html__( 'Specify widget title font properties.', 'ihosting' ),
						'google'   => true,
						'output'   => array( '.widget-title' ),
					),
				),
			);

			/*--Header setting--*/

			$header_logos = array();
			for ( $i = 1; $i <= 3; $i++ ) {
				$default_logo_url = get_template_directory_uri() . '/assets/images/logo.png';
				$header_logos[] = array(
					'id'       => 'opt_header_style_' . esc_attr( $i ) . '_logo',
					'type'     => 'media',
					'url'      => true,
					'title'    => esc_html__( 'Logo', 'ihosting' ),
					'compiler' => 'true',
					//'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
					'desc'     => esc_html__( 'Upload or choose the logo image', 'ihosting' ),
					'subtitle' => sprintf( esc_html__( 'Logo for header style %d', 'ihosting' ), $i ),
					'default'  => array( 'url' => $default_logo_url, 'width' => 183, 'height' => 46 ),
					'required' => array( 'opt_header_layout', '=', 'style_' . esc_attr( $i ) ),
				);
			}

			$this->sections[] = array(
				'title'  => esc_html__( 'Header Settings', 'ihosting' ),
				'desc'   => esc_html__( 'Header Settings', 'ihosting' ),
				'icon'   => 'el-icon-credit-card',
				'fields' => array(
					array(
						'id'       => 'opt_header_layout',
						'type'     => 'image_select',
						'compiler' => true,
						'title'    => esc_html__( 'Header Layout', 'ihosting' ),
						'subtitle' => esc_html__( 'Select header layout style.', 'ihosting' ),
						'options'  => array(
							'style_1' => array( 'alt' => 'Header 1', 'img' => plugins_url( '/ihosting-core' ) . '/assets/images/headers-preview/header_1.jpg' ),
							'style_2' => array( 'alt' => 'Header 1', 'img' => plugins_url( '/ihosting-core' ) . '/assets/images/headers-preview/header_2.jpg' ),
							'style_3' => array( 'alt' => 'Header 1', 'img' => plugins_url( '/ihosting-core' ) . '/assets/images/headers-preview/header_3.jpg' ),
						),
						'default'  => 'style_1',
					),
					$header_logos[0],
					$header_logos[1],
					$header_logos[2],
					array(
						'id'       => 'opt_header_desc',
						'type'     => 'text',
						'title'    => esc_html__( 'Header Description', 'ihosting' ),
						'desc'     => esc_html__( 'A short text display on the header.', 'ihosting' ),
						'default'  => esc_html__( 'Trusted by over 10,000 website owners globally!', 'ihosting' ),
						'required' => array( 'opt_header_layout', '=', array( 'style_1', 'style_3' ) ),
					),
					array(
						'id'       => 'opt_header_contact_info',
						'type'     => 'multi_text',
						'title'    => esc_html__( 'Header Contact Information', 'ihosting' ),
						'validate' => 'html',
						'desc'     => esc_html__( 'Input short contact information. Html is allowed. Ex: <a href="#"><span class="menu-icon flaticon-new4"></span> Support@Luckyshop.com</a>', 'ihosting' ),
						'required' => array( 'opt_header_layout', '=', array( 'style_1', 'style_2', 'style_3' ) ),
					),
					array(
						'id'       => 'opt_show_login_link',
						'type'     => 'switch',
						'title'    => esc_html__( 'Show Login/Register Link', 'ihosting' ),
						'desc'     => esc_html__( 'Only work when "WooCommerce" plugin is installed and activated.', 'ihosting' ),
						'default'  => '1',
						'on'       => esc_html__( 'Show', 'ihosting' ),
						'off'      => esc_html__( 'Don\'t show', 'ihosting' ),
						'required' => array( 'opt_header_layout', '=', array( 'style_1', 'style_2', 'style_3' ) ),
					),
					array(
						'id'       => 'opt_show_language_swicher',
						'type'     => 'switch',
						'title'    => esc_html__( 'Show Language Switcher', 'ihosting' ),
						'desc'     => esc_html__( 'Only show if WPML plugin is installed and activated.', 'ihosting' ),
						'default'  => '1',
						'on'       => esc_html__( 'Show', 'ihosting' ),
						'off'      => esc_html__( 'Don\'t show', 'ihosting' ),
						'required' => array( 'opt_header_layout', '=', array( 'style_1', 'style_2', 'style_3' ) ),
					),
				),
			);

			/*-- Heading and Breadcrumbs setting (Header banner) --*/
			$this->sections[] = array(
				'title'    => esc_html__( 'Heading/Breadcrumbs', 'ihosting' ),
				'subtitle' => esc_html__( 'Page heading, breadcrumbs, banner settings', 'ihosting' ),
				'icon'     => 'el-icon-credit-card',
				'fields'   => array(
					array(
						'id'      => 'opt_show_page_heading',
						'type'    => 'switch',
						'title'   => esc_html__( 'Show Heading', 'ihosting' ),
						'desc'    => esc_html__( 'Show/Hide page/post... heading. Waring: If turn off this option, the heading of any post/page... may be not show.', 'ihosting' ),
						'default' => '1',
						'on'      => esc_html__( 'Show', 'ihosting' ),
						'off'     => esc_html__( 'Don\'t show', 'ihosting' )
					),
					array(
						'id'       => 'opt_page_heading_color',
						'type'     => 'color_rgba',
						'title'    => esc_html__( 'Heading Color', 'ihosting' ),
						'default'  => array(
							'color' => '#222',
							'alpha' => 1,
						),
						'options'  => $color_options,
						'output'   => array(
							'color' => '.ih-heading-banner .page-heading, .ih-page-heading'
						),
						'required' => array( 'opt_show_page_heading', '=', 1 ),
					),
					array(
						'id'      => 'opt_show_breadcrumbs',
						'type'    => 'switch',
						'title'   => esc_html__( 'Show Breadcrumbs', 'ihosting' ),
						'desc'    => esc_html__( 'Show/Hide breadcrumbs.', 'ihosting' ),
						'default' => '1',
						'on'      => esc_html__( 'Show', 'ihosting' ),
						'off'     => esc_html__( 'Don\'t show', 'ihosting' )
					),
					array(
						'id'       => 'opt_breadcrumbs_color',
						'type'     => 'color_rgba',
						'title'    => esc_html__( 'Breadcrumbs Color', 'ihosting' ),
						'default'  => array(
							'color' => '#222',
							'alpha' => 1,
						),
						'options'  => $color_options,
						'output'   => array(
							'color' => '.breadcrumb-wrap'
						),
						'required' => array( 'opt_show_breadcrumbs', '=', 1 ),
					),
					array(
						'id'      => 'opt_show_page_banner',
						'type'    => 'switch',
						'title'   => esc_html__( 'Show Banner', 'ihosting' ),
						'desc'    => esc_html__( 'Show/Hide banner.', 'ihosting' ),
						'default' => '1',
						'on'      => esc_html__( 'Show', 'ihosting' ),
						'off'     => esc_html__( 'Don\'t show', 'ihosting' )
					),
					array(
						'id'                => 'opt_heading_banner_bg',
						'type'              => 'background',
						'title'             => esc_html__( 'Heading Banner', 'ihosting' ),
						'subtitle'          => esc_html__( 'Heading banner background', 'ihosting' ),
						'background-clip'   => false,
						'background-origin' => false,
						'background-size'   => false,
						'output'            => array( '.ih-heading-banner.has-bg' ),
						'required'          => array( 'opt_show_page_banner', '=', 1 ),
					),
					array(
						'id'       => 'opt_heading_banner_height',
						'type'     => 'text',
						'title'    => esc_html__( 'Banner Height', 'ihosting' ),
						'default'  => '215',
						'desc'     => esc_html__( 'Default: 215. Unit is pixel.', 'ihosting' ),
						'required' => array( 'opt_show_page_banner', '=', 1 ),
					),
				)
			);

			/*--Footer setting--*/
			$this->sections[] = array(
				'title'  => esc_html__( 'Footer Settings', 'ihosting' ),
				'desc'   => esc_html__( 'Footer Settings', 'ihosting' ),
				'icon'   => 'el-icon-credit-card',
				'fields' => array(
					array(
						'id'      => 'opt_footer_bg_color',
						'type'    => 'color_rgba',
						'title'   => esc_html__( 'Footer Background Color', 'ihosting' ),
						'default' => array(
							'color' => '#141414', // Contruction design
							'alpha' => 1,
						),
						'options' => $color_options,
						'output'  => array(
							'background-color' => '.footer-global.site-footer'
						),
					),
					array(
						'id'       => 'opt_footer_layout_content',
						'type'     => 'select',
						'multi'    => true,
						'title'    => esc_html__( 'Footer Top Layout', 'ihosting' ),
						'subtitle' => esc_html__( 'Footer top can be built by using the footer post type', 'ihosting' ),
						'options'  => ihosting_select_post_by_post_types_for_redux( array( 'post_type' => 'footer' ) ),
						'multi'    => false,
					),
					array(
						'id'      => 'opt_enable_footer_mid',
						'type'    => 'switch',
						'title'   => esc_html__( 'Enable Footer Middle', 'ihosting' ),
						'default' => '1',
						'on'      => esc_html__( 'Enable', 'ihosting' ),
						'off'     => esc_html__( 'Disable', 'ihosting' ),
					),
					array(
						'id'       => 'opt_footer_copyright_text',
						'type'     => 'editor',
						'title'    => esc_html__( 'Footer Copyright Text', 'ihosting' ),
						'subtitle' => esc_html__( 'Copyright text', 'ihosting' ),
						'default'  => wp_kses( __( 'Copyright &copy; 2016 <a href="http://kute-themes.com/">Kutethemes</a>. All Rights Reserved.', 'ihosting' ), array( 'a' => array( 'href' => array() ) ) ),
						'required' => array( 'opt_enable_footer_mid', '=', '1' ),
					),
					array(
						'id'       => 'opt_show_footer_social_links',
						'type'     => 'switch',
						'title'    => esc_html__( 'Show Social Links', 'ihosting' ),
						'default'  => '1',
						'on'       => esc_html__( 'Show', 'ihosting' ),
						'off'      => esc_html__( 'Hide', 'ihosting' ),
						'required' => array( 'opt_enable_footer_mid', '=', '1' ),
					),
					array(
						'id'                => 'opt_show_footer_mid_bg',
						'type'              => 'background',
						'title'             => esc_html__( 'Footer Mid Background', 'ihosting' ),
						'subtitle'          => esc_html__( 'Background on the middle of footer', 'ihosting' ),
						'background-clip'   => false,
						'background-origin' => false,
						'background-size'   => false,
						'output'            => array( 'footer .footer-mid' ),
						'required'          => array( 'opt_enable_footer_mid', '=', '1' ),
					),
					array(
						'id'      => 'opt_enable_footer_bottom',
						'type'    => 'switch',
						'title'   => esc_html__( 'Enable Footer Bottom', 'ihosting' ),
						'default' => '1',
						'on'      => esc_html__( 'Enable', 'ihosting' ),
						'off'     => esc_html__( 'Disable', 'ihosting' ),
					),
					array(
						'id'       => 'opt_footer_bottom_text',
						'type'     => 'editor',
						'title'    => esc_html__( 'Footer Bottom Text', 'ihosting' ),
						'subtitle' => esc_html__( 'The text display on the bottom of footer', 'ihosting' ),
						'default'  => wp_kses( __( 'Need help? Call our award-winning support team 24/7 at 1 234-567-890.', 'ihosting' ), array( 'a' => array( 'href' => array() ) ) ),
						'required' => array( 'opt_enable_footer_bottom', '=', '1' ),
					),
					array(
						'id'                => 'opt_show_footer_bottom_bg',
						'type'              => 'background',
						'title'             => esc_html__( 'Footer Bottom Background', 'ihosting' ),
						'subtitle'          => esc_html__( 'Background at the bottom of footer', 'ihosting' ),
						'background-clip'   => false,
						'background-origin' => false,
						'background-size'   => false,
						'output'            => array( 'footer .footer-bottom' ),
						'required'          => array( 'opt_enable_footer_bottom', '=', '1' ),
					)
				),
			);


			/*--Blog--*/
			$this->sections[] = array(
				'title'  => esc_html__( 'Blog Settings', 'ihosting' ),
				'desc'   => esc_html__( 'Blog Settings', 'ihosting' ),
				'icon'   => 'el-icon-th-list',
				'fields' => array(
					array(
						'id'       => 'opt_blog_sidebar_pos',
						'type'     => 'image_select',
						'compiler' => true,
						'title'    => esc_html__( 'Sidebar Position', 'ihosting' ),
						'subtitle' => esc_html__( 'Select sidebar position.', 'ihosting' ),
						'desc'     => esc_html__( 'Select sidebar on left or right', 'ihosting' ),
						'options'  => array(
							'left'      => array( 'alt' => 'Left Sidebar', 'img' => get_template_directory_uri() . '/assets/images/2cl.png' ),
							'right'     => array( 'alt' => 'Right Sidebar', 'img' => get_template_directory_uri() . '/assets/images/2cr.png' ),
							'fullwidth' => array( 'alt' => 'Full Width', 'img' => get_template_directory_uri() . '/assets/images/1column.png' ),
						),
						'default'  => 'right',
					),
					array(
						'id'      => 'opt_blog_layout_style',
						'type'    => 'select',
						'multi'   => false,
						'title'   => esc_html__( 'Blog Layout Style', 'ihosting' ),
						'options' => array(
							'default'  => esc_html__( 'Default', 'ihosting' ),
							'standard' => esc_html__( 'List', 'ihosting' ),
							'grid'     => esc_html__( 'Grid', 'ihosting' ),
							'masonry'  => esc_html__( 'Masonry', 'ihosting' ),
						),
						'default' => 'default',
					),
					array( // Don't remove me
					       'id'       => 'opt_blog_masonry_loadmore_number',
					       'type'     => 'text',
					       'title'    => esc_html__( 'Number of posts per load', 'ihosting' ),
					       'desc'     => esc_html__( 'Number of posts will load when click on load more button', 'ihosting' ),
					       'default'  => 6,
					       'validate' => 'numeric',
					       'required' => array( 'opt_blog_layout_style', '=', 'masonry' ),
					),
					array( // Don't remove me
					       'id'       => 'opt_blog_masonry_loadmore_text',
					       'type'     => 'text',
					       'title'    => esc_html__( 'Load more text', 'ihosting' ),
					       'desc'     => esc_html__( 'Load more button text', 'ihosting' ),
					       'default'  => esc_html__( 'Load more', 'ihosting' ),
					       'validate' => 'no_html',
					       'required' => array( 'opt_blog_layout_style', '=', 'masonry' ),
					),
					array( // Don't remove me
					       'id'       => 'opt_blog_masonry_nomore_text',
					       'type'     => 'text',
					       'title'    => esc_html__( 'No more post text', 'ihosting' ),
					       'desc'     => esc_html__( 'Text show when no more post to load', 'ihosting' ),
					       'default'  => esc_html__( 'No more post', 'ihosting' ),
					       'validate' => 'no_html',
					       'required' => array( 'opt_blog_layout_style', '=', 'masonry' ),
					),
					array(
						'id'       => 'opt_blog_continue_reading',
						'type'     => 'text',
						'title'    => esc_html__( 'Continue reading', 'ihosting' ),
						'subtitle' => esc_html__( 'Continue reading text', 'ihosting' ),
						'default'  => esc_html__( 'Read more', 'ihosting' ),
					),
					array(
						'id'       => 'opt_blog_loop_content_type',
						'type'     => 'switch',
						'title'    => esc_html__( 'Bog loop content', 'ihosting' ),
						'subtitle' => esc_html__( 'Show the blog content or the excerpt on loop', 'ihosting' ),
						'default'  => '1',
						'on'       => esc_html__( 'The content', 'ihosting' ),
						'off'      => esc_html__( 'The excerpt', 'ihosting' ),
						'required' => array( 'opt_blog_layout_style', '=', array( 'default' ) ),
						'desc'     => esc_html__( 'This option only work with default blog layout style', 'ihosting' ),
					),
					array(
						'id'       => 'opt_excerpt_max_char_length',
						'type'     => 'text',
						'title'    => esc_html__( 'The excerpt max chars length', 'ihosting' ),
						'default'  => 180,
						'validate' => 'numeric',
						'required' => array( 'opt_blog_loop_content_type', '!=', '1' ),
						'desc'     => esc_html__( 'The excerpt max chars length for default blog layout style', 'ihosting' ),
					),
					array(
						'id'       => 'opt_excerpt_max_char_length_standard', // For blog standard style
						'type'     => 'text',
						'title'    => esc_html__( 'The Excerpt Max Chars Length For Standard', 'ihosting' ),
						'default'  => 180,
						'validate' => 'numeric',
						'required' => array( 'opt_blog_layout_style', '=', 'standard' ),
						'desc'     => esc_html__( 'The excerpt max chars length for standard blog layout style', 'ihosting' ),
					),
					array(
						'id'       => 'opt_excerpt_max_char_length_masonry', // For blog standard style
						'type'     => 'text',
						'title'    => esc_html__( 'The Excerpt Max Chars Length For Masonry', 'ihosting' ),
						'default'  => 180,
						'validate' => 'numeric',
						'required' => array( 'opt_blog_layout_style', '=', 'masonry' ),
						'desc'     => esc_html__( 'The excerpt max chars length for masonry blog layout style', 'ihosting' ),
					),
					array(
						'id'       => 'opt_blog_standard_show_place_hold_img', // For blog standard in excerpt mode only
						'type'     => 'switch',
						'title'    => esc_html__( 'Show Placehold Image', 'ihosting' ),
						'desc'     => esc_html__( 'Show placehold image if blog post standard has no feature image', 'ihosting' ),
						'default'  => '1',
						'on'       => esc_html__( 'Show', 'ihosting' ),
						'off'      => esc_html__( 'Don\'t show', 'ihosting' ),
						'required' => array(
							array( 'opt_blog_layout_style', '=', 'standard' ),
						),
					),
					array(
						'id'       => 'opt_blog_grid_show_place_hold_img', // For blog grid only
						'type'     => 'switch',
						'title'    => esc_html__( 'Show Placehold Image', 'ihosting' ),
						'desc'     => esc_html__( 'Show placehold image if blog post grid has no feature image', 'ihosting' ),
						'default'  => '0',
						'on'       => esc_html__( 'Show', 'ihosting' ),
						'off'      => esc_html__( 'Don\'t show', 'ihosting' ),
						'required' => array(
							array( 'opt_blog_layout_style', '=', 'grid' ),
						),
					),
					array(
						'id'       => 'opt_blog_masonry_show_place_hold_img', // For blog masonry only
						'type'     => 'switch',
						'title'    => esc_html__( 'Show Placehold Image', 'ihosting' ),
						'desc'     => esc_html__( 'Show placehold image if blog post masonry has no feature image', 'ihosting' ),
						'default'  => '0',
						'on'       => esc_html__( 'Show', 'ihosting' ),
						'off'      => esc_html__( 'Don\'t show', 'ihosting' ),
						'required' => array(
							array( 'opt_blog_layout_style', '=', 'masonry' ),
						),
					),
					array(
						'id'       => 'opt_blog_grid_show_post_excerpt', // For blog grid only
						'type'     => 'switch',
						'title'    => esc_html__( 'Show Post Excerpt', 'ihosting' ),
						'default'  => '0',
						'on'       => esc_html__( 'Show', 'ihosting' ),
						'off'      => esc_html__( 'Don\'t show', 'ihosting' ),
						'required' => array(
							array( 'opt_blog_layout_style', '=', 'grid' ),
						),
					),
					array(
						'id'       => 'opt_blog_show_readmore',
						'type'     => 'switch',
						'title'    => esc_html__( 'Show read more', 'ihosting' ),
						'desc'     => esc_html__( 'Show read more button on blog archive', 'ihosting' ),
						'default'  => '0',
						'on'       => esc_html__( 'Show', 'ihosting' ),
						'off'      => esc_html__( 'Don\'t show', 'ihosting' ),
						'required' => array( 'opt_blog_loop_content_type', '!=', 1 ),
					),
					array(
						'id'       => 'opt_blog_metas',
						'type'     => 'select',
						'multi'    => true,
						'title'    => esc_html__( 'Blog Loop Metas', 'ihosting' ),
						'options'  => array(
							'author'   => esc_html__( 'Author', 'ihosting' ),
							'date'     => esc_html__( 'Date time', 'ihosting' ),
							'category' => esc_html__( 'Category', 'ihosting' ),
							'comment'  => esc_html__( 'Comment', 'ihosting' ),
							'tags'     => esc_html__( 'Tags', 'ihosting' ),
						),
						'sortable' => true,
						'default'  => array( 'author', 'date', 'category', 'comment', 'tags' ),
						//'required'      => array( 'opt_blog_layout_style', '=', 'standard' ),
					),
					array(
						'id'       => 'opt_blog_single_post_bio',
						'type'     => 'switch',
						'title'    => esc_html__( 'Enable Author Bio On The Single Post', 'ihosting' ),
						'subtitle' => esc_html__( 'Enable author bio on/off', 'ihosting' ),
						'default'  => '1',
						'on'       => 'Enabled',
						'off'      => 'Disabled',
					),
					array(
						'id'      => 'opt_enable_single_post_sharing',
						'type'    => 'switch',
						'title'   => esc_html__( 'Enable single post share links', 'ihosting' ),
						'default' => '1',
						'on'      => 'Enabled',
						'off'     => 'Disabled',
					),
					array(
						'id'       => 'opt_single_share_socials',
						'type'     => 'select',
						'multi'    => true,
						'title'    => esc_html__( 'Choose socials to share single post', 'ihosting' ),
						'options'  => array(
							'facebook'  => 'Facebook',
							'gplus'     => 'Google Plus',
							'twitter'   => 'Twitter',
							'pinterest' => 'Pinterest',
							'linkedin'  => 'Linkedin',
						),
						'sortable' => true,
						'default'  => array( 'facebook', 'gplus', 'twitter', 'pinterest', 'linkedin' ),
						'required' => array( 'opt_enable_share_post', '=', '1' ),
					),
				),
			);

			/**
			 * Check if WooCommerce is active
			 **/
			if ( class_exists( 'WooCommerce' ) ) {

				/*-- Woocommerce Setting--*/
				$this->sections[] = array(
					'title'  => esc_html__( 'WooCommerce', 'ihosting' ),
					'desc'   => esc_html__( 'WooCommerce Settings', 'ihosting' ),
					'icon'   => 'el-icon-shopping-cart',
					'fields' => array(
						array(
							'id'       => 'woo_shop_sidebar_pos',
							'type'     => 'image_select',
							'compiler' => true,
							'title'    => esc_html__( 'Sidebar Position', 'ihosting' ),
							'subtitle' => esc_html__( 'Select sidebar position on shop, product archive page.', 'ihosting' ),
							'options'  => array(
								'left'      => array( 'alt' => '1 Column Left', 'img' => get_template_directory_uri() . '/assets/images/2cl.png' ),
								'right'     => array( 'alt' => '2 Column Right', 'img' => get_template_directory_uri() . '/assets/images/2cr.png' ),
								'fullwidth' => array( 'alt' => 'Full Width', 'img' => get_template_directory_uri() . '/assets/images/1column.png' ),
							),
							'default'  => 'left',
						),
						array(
							'id'       => 'woo_shop_default_layout',
							'type'     => 'image_select',
							'compiler' => true,
							'title'    => esc_html__( 'Shop Default Layout', 'ihosting' ),
							'subtitle' => esc_html__( 'Select default layout for shop, product category archive.', 'ihosting' ),
							'options'  => array(
								'grid' => array( 'alt' => 'Layout Grid', 'img' => get_template_directory_uri() . '/assets/images/grid.png' ),
								'list' => array( 'alt' => 'Layout List', 'img' => get_template_directory_uri() . '/assets/images/list.png' ),
							),
							'default'  => 'grid',
						),
						array(
							'id'       => 'woo_products_per_row',
							'type'     => 'image_select',
							'compiler' => true,
							'title'    => esc_html__( 'Products Columns', 'ihosting' ),
							'subtitle' => esc_html__( 'Set number columns on the shop/products archive page.', 'ihosting' ),
							'desc'     => esc_html__( 'Only on large screen and for grid style', 'ihosting' ),
							'options'  => array(
								'2' => array( 'alt' => '2 Column ', 'img' => get_template_directory_uri() . '/assets/images/2columns.png' ),
								'3' => array( 'alt' => '3 Column ', 'img' => get_template_directory_uri() . '/assets/images/3columns.png' ),
								'4' => array( 'alt' => '4 Column ', 'img' => get_template_directory_uri() . '/assets/images/4columns.png' ),
							),
							'default'  => '3',
							//'required' => array( 'woo_shop_default_layout', '=', 'grid' ),
						),
						array(
							'id'      => 'woo_show_star_rating_on_product_loop',
							'type'    => 'switch',
							'title'   => esc_html__( 'Show Star Rating On Product Loop', 'ihosting' ),
							'default' => '0',
							'on'      => esc_html__( 'Show', 'ihosting' ),
							'off'     => esc_html__( 'Don\'t show', 'ihosting' ),
						),
						array(
							'id'       => 'woo_single_product_sidebar_pos',
							'type'     => 'image_select',
							'title'    => esc_html__( 'Single Product Sidebar Position', 'ihosting' ),
							'subtitle' => esc_html__( 'Select sidebar position on single product page.', 'ihosting' ),
							'options'  => array(
								'left'      => array( 'alt' => '1 Column Left', 'img' => get_template_directory_uri() . '/assets/images/2cl.png' ),
								'right'     => array( 'alt' => '2 Column Right', 'img' => get_template_directory_uri() . '/assets/images/2cr.png' ),
								'fullwidth' => array( 'alt' => 'Full Width', 'img' => get_template_directory_uri() . '/assets/images/1column.png' ),
							),
							'default'  => 'left',
						),
						array(
							'id'      => 'woo_single_product_zoom_images_on_hover', // not done
							'type'    => 'switch',
							'title'   => esc_html__( 'Single Product Zoom Images', 'ihosting' ),
							'default' => '1',
							'on'      => esc_html__( 'On', 'ihosting' ),
							'off'     => esc_html__( 'Off', 'ihosting' ),
							'desc'    => wp_kses( __( 'Turn single product zoom image when hover on or off', 'ihosting' ), array( 'strong' => array(), 'b' => array(), 'a' => array( 'href' ) ) ),
						),
						array(
							'id'       => 'woo_single_product_tabs_layout',
							'type'     => 'button_set',
							'title'    => esc_html__( 'Product Tabs Layout', 'ihosting' ),
							'subtitle' => esc_html__( 'Select product tabs layout on the single product page', 'ihosting' ),
							'options'  => array(
								'horizontal' => esc_html__( 'Horizontal', 'ihosting' ),
								'vertical'   => esc_html__( 'Vertical', 'ihosting' ),
							),
							'default'  => 'vertical',
							'multi'    => false,
						),
						array(
							'id'      => 'woo_single_product_enable_cats_tab',
							'type'    => 'switch',
							'title'   => esc_html__( 'Product Categories Tab', 'ihosting' ),
							'default' => '1',
							'on'      => esc_html__( 'On', 'ihosting' ),
							'off'     => esc_html__( 'Off', 'ihosting' ),
							'desc'    => wp_kses( __( 'Turn single product categories on or off', 'ihosting' ), array( 'strong' => array(), 'b' => array(), 'a' => array( 'href' ) ) ),
						),
						array(
							'id'      => 'woo_single_product_enable_tags_tab',
							'type'    => 'switch',
							'title'   => esc_html__( 'Product Tags Tab', 'ihosting' ),
							'default' => '1',
							'on'      => esc_html__( 'On', 'ihosting' ),
							'off'     => esc_html__( 'Off', 'ihosting' ),
							'desc'    => wp_kses( __( 'Turn single product tags on or off', 'ihosting' ), array( 'strong' => array(), 'b' => array(), 'a' => array( 'href' ) ) ),
						),
						array(
							'id'      => 'opt_enable_share_product', // not done
							'type'    => 'switch',
							'title'   => esc_html__( 'Enable single product share links', 'ihosting' ),
							'default' => '1',
							'on'      => esc_html__( 'Enable', 'ihosting' ),
							'off'     => esc_html__( 'Disabled', 'ihosting' ),
						),
						array(
							'id'       => 'opt_single_product_socials_share', // not done
							'type'     => 'select',
							'multi'    => true,
							'title'    => esc_html__( 'Share product on', 'ihosting' ),
							'subtitle' => esc_html__( 'Display sharing buttons on the single product pages', 'ihosting' ),
							'options'  => array(
								'facebook'  => 'Facebook',
								'gplus'     => 'Google Plus',
								'twitter'   => 'Twitter',
								'pinterest' => 'Pinterest',
								'linkedin'  => 'Linkedin',
							),
							'default'  => array( 'facebook', 'gplus', 'twitter', 'pinterest', 'linkedin' ),
							'required' => array( 'opt_enable_share_product', '=', '1' ),
						),
					),
				);
			}

			/*-- Contact Setting--*/
			$this->sections[] = array(
				'title'  => esc_html__( 'Newsletter Settings', 'ihosting' ),
				'desc'   => esc_html__( 'Newsletter infomation settings', 'ihosting' ),
				'icon'   => 'el-icon-envelope',
				'fields' => array(
					array(
						'id'      => 'opt_mailchimp_api_key',
						'type'    => 'text',
						'title'   => esc_html__( 'Mailchimp API Key', 'ihosting' ),
						'default' => '',
						'desc'    => sprintf( wp_kses( __( '<a href="%s" target="__blank">Click here to get your Mailchimp API key</a>', 'ihosting' ), array( 'a' => array( 'href' => array() ) ) ), 'https://admin.mailchimp.com/account/api' ),
					),
					array(
						'id'      => 'opt_mailchimp_list_id',
						'type'    => 'text',
						'title'   => esc_html__( 'Mailchimp List ID', 'ihosting' ),
						'default' => '',
						'desc'    => sprintf( wp_kses( __( '<a href="%s" target="__blank">How to find Mailchimp list ID</a>', 'ihosting' ), array( 'a' => array( 'href' => array() ) ) ), 'http://kb.mailchimp.com/lists/managing-subscribers/find-your-list-id' ),
					),
					array(
						'id'      => 'opt_subscribe_form_title',
						'type'    => 'text',
						'title'   => esc_html__( 'Subscribe Form Title', 'ihosting' ),
						'default' => esc_html__( 'Subscribe our newsletter', 'ihosting' ),
					),
					array(
						'id'      => 'opt_subscribe_form_input_placeholder',
						'type'    => 'text',
						'title'   => esc_html__( 'Email Input Placeholder', 'ihosting' ),
						'default' => esc_html__( 'Your email address...', 'ihosting' ),
					),
					array(
						'id'      => 'opt_subscribe_form_submit_text',
						'type'    => 'text',
						'title'   => esc_html__( 'Submit Text', 'ihosting' ),
						'default' => esc_html__( 'Submit', 'ihosting' ),
					),
					array(
						'id'      => 'opt_subscribe_success_message',
						'type'    => 'text',
						'title'   => esc_html__( 'Success Message', 'ihosting' ),
						'default' => esc_html__( 'Your email added...', 'ihosting' ),
					),
				),
			);

			/*--Social Settings--*/
			$this->sections[] = array(
				'title'  => esc_html__( 'Social Settings', 'ihosting' ),
				'icon'   => 'el-icon-credit-card',
				'fields' => array(
					array(
						'id'       => 'opt_twitter_link',
						'type'     => 'text',
						'title'    => esc_html__( 'Twitter', 'ihosting' ),
						'default'  => 'https://twitter.com',
						'validate' => 'url',
					),
					array(
						'id'       => 'opt_fb_link',
						'type'     => 'text',
						'title'    => esc_html__( 'Facebook', 'ihosting' ),
						'default'  => 'https://facebook.com',
						'validate' => 'url',
					),
					array(
						'id'       => 'opt_google_plus_link',
						'type'     => 'text',
						'title'    => esc_html__( 'Google Plus', 'ihosting' ),
						'default'  => '',
						'validate' => 'url',
					),
					array(
						'id'       => 'opt_dribbble_link',
						'type'     => 'text',
						'title'    => esc_html__( 'Dribbble', 'ihosting' ),
						'default'  => '',
						'validate' => 'url',
					),
					array(
						'id'       => 'opt_behance_link',
						'type'     => 'text',
						'title'    => esc_html__( 'Behance', 'ihosting' ),
						'default'  => '',
						'validate' => 'url',
					),
					array(
						'id'       => 'opt_tumblr_link',
						'type'     => 'text',
						'title'    => esc_html__( 'Tumblr', 'ihosting' ),
						'default'  => '',
						'validate' => 'url',
					),
					array(
						'id'       => 'opt_instagram_link',
						'type'     => 'text',
						'title'    => esc_html__( 'Instagram', 'ihosting' ),
						'default'  => '',
						'validate' => 'url',
					),
					array(
						'id'       => 'opt_pinterest_link',
						'type'     => 'text',
						'title'    => esc_html__( 'Pinterest', 'ihosting' ),
						'default'  => '',
						'validate' => 'url',
					),
					array(
						'id'       => 'opt_youtube_link',
						'type'     => 'text',
						'title'    => esc_html__( 'Youtube', 'ihosting' ),
						'default'  => '',
						'validate' => 'url',
					),
					array(
						'id'       => 'opt_vimeo_link',
						'type'     => 'text',
						'title'    => esc_html__( 'Vimeo', 'ihosting' ),
						'default'  => '',
						'validate' => 'url',
					),
					array(
						'id'       => 'opt_linkedin_link',
						'type'     => 'text',
						'title'    => esc_html__( 'Linkedin', 'ihosting' ),
						'default'  => '',
						'validate' => 'url',
					),
					array(
						'id'       => 'opt_rss_link',
						'type'     => 'text',
						'title'    => esc_html__( 'RSS', 'ihosting' ),
						'default'  => '',
						'validate' => 'url',
					),
				),
			);

			/*-- Coming Soon Setting--*/
			$this->sections[] = array(
				'title'  => esc_html__( 'Coming Soon Settings', 'ihosting' ),
				'icon'   => 'el-icon-time',
				'fields' => array(
					array(
						'id'       => 'opt_enable_coming_soon_mode',
						'type'     => 'switch',
						'title'    => esc_html__( 'Coming soon mode', 'ihosting' ),
						'subtitle' => esc_html__( 'Turn coming soon mode on/off', 'ihosting' ),
						'desc'     => esc_html__( 'If turn on, every one need login to view site', 'ihosting' ),
						'default'  => 0,
						'on'       => esc_html__( 'On', 'ihosting' ),
						'off'      => esc_html__( 'Off', 'ihosting' ),
					),
					array(
						'id'       => 'opt_coming_soon_site_title',
						'type'     => 'text',
						'title'    => esc_html__( 'Coming Soon Site Title', 'ihosting' ),
						'default'  => esc_html__( 'We are coming soon', 'ihosting' ),
						'validate' => 'no_html',
					),
					array(
						'id'       => 'opt_coming_soon_img',
						'type'     => 'media',
						'url'      => true,
						'title'    => esc_html__( 'Coming Soon Image', 'ihosting' ),
						'compiler' => 'true',
						//'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
						'desc'     => esc_html__( 'Upload image for coming soon page', 'ihosting' ),
						'default'  => array( 'url' => get_template_directory_uri() . '/assets/images/logo_dark.png' ),
						'required' => array( 'opt_enable_coming_soon_mode', '=', 1 ),
					),
					array(
						'id'       => 'opt_coming_soon_text',
						'type'     => 'editor',
						'title'    => esc_html__( 'Coming soon text', 'ihosting' ),
						'default'  => wp_kses( __( 'Our site is currently undergoing scheduled maintenance<br>For any assistance in the meantime, drop us a line <a href="mailto:help@ihostingstore.com">help@ihostingstore.com</a>', 'ihosting' ), array( 'br', 'a' => array( 'href' => array() ), 'b' ) ),
						'required' => array( 'opt_enable_coming_soon_mode', '=', 1 ),
					),
					array(
						'id'       => 'opt_coming_soon_date',
						'type'     => 'date',
						'title'    => esc_html__( 'Coming soon date', 'ihosting' ),
						'required' => array( 'opt_enable_coming_soon_mode', '=', 1 ),
					),
					array(
						'id'       => 'opt_enable_coming_soon_newsletter',
						'type'     => 'switch',
						'title'    => esc_html__( 'Coming soon news letter', 'ihosting' ),
						'desc'     => esc_html__( 'If turn on, news latter form will show on coming soon page', 'ihosting' ),
						'default'  => 1,
						'on'       => esc_html__( 'On', 'ihosting' ),
						'off'      => esc_html__( 'Off', 'ihosting' ),
						'required' => array( 'opt_enable_coming_soon_mode', '=', 1 ),
					),
					array(
						'id'       => 'opt_disable_coming_soon_when_date_small',
						'type'     => 'switch',
						'title'    => esc_html__( 'Coming soon when count down date expired', 'ihosting' ),
						'default'  => 1,
						'on'       => esc_html__( 'Disable coming soon', 'ihosting' ),
						'off'      => esc_html__( 'Don\'t disable coming soon', 'ihosting' ),
						'required' => array( 'opt_enable_coming_soon_mode', '=', 1 ),
					),
				),
			);

			/*-- 404 Setting--*/
			$this->sections[] = array(
				'title'  => esc_html__( '404 Settings', 'ihosting' ),
				'desc'   => esc_html__( 'Setting for 404 error page', 'ihosting' ),
				'icon'   => 'el-icon-bell',
				'fields' => array(
					array(
						'id'       => 'opt_404_img',
						'type'     => 'media',
						'url'      => true,
						'title'    => esc_html__( '404 Image', 'ihosting' ),
						'compiler' => 'true',
						//'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
						'desc'     => esc_html__( 'Upload 404 image', 'ihosting' ),
						'default'  => array( 'url' => get_template_directory_uri() . '/assets/images/page404.png' ),
					),
					array(
						'id'      => 'opt_404_header_title',
						'type'    => 'text',
						'title'   => esc_html__( '404 Header Title', 'ihosting' ),
						'default' => esc_html__( '404', 'ihosting' ),
					),
					array(
						'id'      => 'opt_404_subtitle',
						'type'    => 'text',
						'title'   => esc_html__( '404 Sub Title', 'ihosting' ),
						'default' => esc_html__( 'Oops! That page can\'t be found.', 'ihosting' ),
					),
					array(
						'id'      => 'opt_404_text',
						'type'    => 'text',
						'title'   => esc_html__( 'Text', 'ihosting' ),
						'default' => esc_html__( 'It looks like nothing was found at this location. Maybe try a search?', 'ihosting' ),
					),
					array(
						'id'      => 'opt_enable_search_form_on_404',
						'type'    => 'switch',
						'title'   => esc_html__( 'Enable Search Form', 'ihosting' ),
						'default' => 1,
						'on'      => esc_html__( 'Enable', 'ihosting' ),
						'off'     => esc_html__( 'Disable', 'ihosting' ),
					),
				),
			);


			/*--  Google map API key --*/
			$this->sections[] = array(
				'title'  => esc_html__( 'Google Map', 'ihosting' ),
				'icon'   => 'el-globe',
				'fields' => array(
					array(
						'id'    => 'opt_gmap_api_key',
						'type'  => 'text',
						'title' => esc_html__( 'Google Map API Key', 'ihosting' ),
						'desc'  => wp_kses( sprintf( __( 'Enter your Google Map API key. <a href="%s" target="_blank">How to get?</a>', 'ihosting' ), 'https://developers.google.com/maps/documentation/javascript/get-api-key' ), array( 'a' => array( 'href' => array(), 'target' => array() ) ) ),
					),
				)
			);
		}

		public function setHelpTabs() {

			// Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
			$this->args['help_tabs'][] = array(
				'id'      => 'redux-opts-1',
				'title'   => esc_html__( 'Theme Information 1', 'ihosting' ),
				'content' => wp_kses( __( '<p>This is the tab content, HTML is allowed.</p>', 'ihosting' ), array( 'p' ) ),
			);

			$this->args['help_tabs'][] = array(
				'id'      => 'redux-opts-2',
				'title'   => esc_html__( 'Theme Information 2', 'ihosting' ),
				'content' => wp_kses( __( '<p>This is the tab content, HTML is allowed.</p>', 'ihosting' ), array( 'p' ) ),
			);

			// Set the help sidebar
			$this->args['help_sidebar'] = wp_kses( __( '<p>This is the tab content, HTML is allowed.</p>', 'ihosting' ), array( 'p' ) );
		}

		/**
		 *
		 * All the possible arguments for Redux.
		 * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
		 * */
		public function setArguments() {

			$theme = wp_get_theme(); // For use with some settings. Not necessary.

			$this->args = array(
				// TYPICAL -> Change these values as you need/desire
				'opt_name'           => 'ihosting', // This is where your data is stored in the database and also becomes your global variable name.
				'display_name'       => '<span class="ts-theme-name">' . sanitize_text_field( $theme->get( 'Name' ) ) . '</span>', // Name that appears at the top of your panel
				'display_version'    => $theme->get( 'Version' ), // Version that appears at the top of your panel
				'menu_type'          => 'submenu', //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
				'allow_sub_menu'     => false, // Show the sections below the admin menu item or not
				'menu_title'         => esc_html__( 'iHosting Options', 'ihosting' ),
				'page_title'         => esc_html__( 'iHosting Options', 'ihosting' ),
				// You will need to generate a Google API key to use this feature.
				// Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
				'google_api_key'     => '', // Must be defined to add google fonts to the typography module
				//'async_typography'    => true, // Use a asynchronous font on the front end or font string
				//'admin_bar'           => false, // Show the panel pages on the admin bar
				'global_variable'    => 'ihosting', // Set a different name for your global variable other than the opt_name
				'dev_mode'           => false, // Show the time the page took to load, etc
				'customizer'         => true, // Enable basic customizer support
				// OPTIONAL -> Give you extra features
				'page_priority'      => null, // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
				'page_parent'        => 'themes.php', // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
				'page_permissions'   => 'manage_options', // Permissions needed to access the options panel.
				'menu_icon'          => '', // Specify a custom URL to an icon
				'last_tab'           => '', // Force your panel to always open to a specific tab (by id)
				'page_icon'          => 'icon-themes', // Icon displayed in the admin panel next to your menu_title
				'page_slug'          => 'ihosting_options', // Page slug used to denote the panel
				'save_defaults'      => true, // On load save the defaults to DB before user clicks save or not
				'default_show'       => false, // If true, shows the default value next to each field that is not the default value.
				'default_mark'       => '', // What to print by the field's title if the value shown is default. Suggested: *
				// CAREFUL -> These options are for advanced use only
				'transient_time'     => 60 * MINUTE_IN_SECONDS,
				'output'             => true, // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
				'output_tag'         => true, // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
				//'domain'              => 'redux-framework', // Translation domain key. Don't change this unless you want to retranslate all of Redux.
				'footer_credit'      => esc_html__( 'Kute Themes WordPress Team', 'ihosting' ), // Disable the footer credit of Redux. Please leave if you can help it.
				// FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
				'database'           => '', // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
				'show_import_export' => true, // REMOVE
				'system_info'        => false, // REMOVE
				'help_tabs'          => array(),
				'help_sidebar'       => '', // esc_html__( '', $this->args['domain'] );
				'hints'              => array(
					'icon'          => 'icon-question-sign',
					'icon_position' => 'right',
					'icon_color'    => 'lightgray',
					'icon_size'     => 'normal',

					'tip_style'    => array(
						'color'   => 'light',
						'shadow'  => true,
						'rounded' => false,
						'style'   => '',
					),
					'tip_position' => array(
						'my' => 'top left',
						'at' => 'bottom right',
					),
					'tip_effect'   => array(
						'show' => array(
							'effect'   => 'slide',
							'duration' => '500',
							'event'    => 'mouseover',
						),
						'hide' => array(
							'effect'   => 'slide',
							'duration' => '500',
							'event'    => 'click mouseleave',
						),
					),
				),
			);

			$this->args['share_icons'][] = array(
				'url'   => 'https://www.facebook.com/thuydungcafe',
				'title' => 'Like us on Facebook',
				'icon'  => 'el-icon-facebook',
			);
			$this->args['share_icons'][] = array(
				'url'   => 'http://twitter.com/',
				'title' => 'Follow us on Twitter',
				'icon'  => 'el-icon-twitter',
			);

			// Panel Intro text -> before the form
			if ( !isset( $this->args['global_variable'] ) || $this->args['global_variable'] !== false ) {
				if ( !empty( $this->args['global_variable'] ) ) {
					$v = $this->args['global_variable'];
				}
				else {
					$v = str_replace( "-", "_", $this->args['opt_name'] );
				}

			}
			else {

			}

		}

	}

	new TheOne_Redux_Framework_config();
}


/**
 *
 * Custom function for the callback referenced above
 */
if ( !function_exists( 'redux_my_custom_field' ) ):

	function redux_my_custom_field( $field, $value ) {
		print_r( $field );
		print_r( $value );
	}

endif;

/**
 *
 * Custom function for the callback validation referenced above
 * */
if ( !function_exists( 'redux_validate_callback_function' ) ):

	function redux_validate_callback_function( $field, $value, $existing_value ) {
		$error = false;
		$value = 'just testing';

		$return['value'] = $value;
		if ( $error == true ) {
			$return['error'] = $field;
		}

		return $return;
	}


endif;