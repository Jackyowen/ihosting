<?php
/**
 * Template part for displaying Hero Section.
 *
 * @package iHosting
 */

$header_settings = ihosting_get_header_settings();

$hero_content_class = 'padding-0 col-xs-12';
$hero_adv_class = 'padding-0 col-xs-12';

if ( $header_settings['header_show_header_vertical_menu'] ) {
	$hero_content_class .= ' col-md-12';
	if ( $header_settings['hero_enable_adv_imgs'] ) {
		$hero_content_class .= ' col-lg-7';
		$hero_adv_class .= ' col-md-12 col-lg-2 col-md-offset-0 col-lg-offset-0';
		$hero_content_class .= ' col-md-offset-0 col-lg-offset-3';
	}
	else {
		$hero_content_class .= ' col-lg-9 col-lg-offset-3';
	}
}
else {
	if ( $header_settings['hero_enable_adv_imgs'] ) {
		$hero_content_class .= ' col-md-12 col-lg-10';
		$hero_adv_class .= ' col-sm-12 col-md-12 col-lg-2 col-sm-offset-0 col-md-offset-0 col-lg-offset-0';
	}
}

$hero_style = '';
if ( $header_settings['header_layout'] == 'style_2' ) {
	$hero_style = 'background-color: #fff';
}

?>

<?php if ( !empty( $header_settings['woo_shop_top_bg'] ) ) { ?>
	<div class="shop-top-bg products-archive-bg"
	     style="height: <?php echo intval( $header_settings['woo_top_bg_height'] ) . 'px'; ?>;">

	</div>
<?php } ?>

<?php if ( $header_settings['hero_section_type'] != 'disable' ) { ?>

	<div class="hero-section" style="<?php echo esc_attr( $hero_style ); ?>">
		<div class="container">
			<div class="row margin-0 bg-white">
				<div class="<?php echo esc_attr( $hero_content_class ); ?>">
					<?php if ( $header_settings['hero_section_type'] == 'rev_slider' && class_exists( 'RevSliderOutput' ) ) { ?>
						<div class="slider-rev-wrap">
							<?php RevSliderOutput::putSlider( $header_settings['hero_slider'] ); ?>
						</div>
					<?php } ?>
					<?php if ( $header_settings['hero_section_type'] == 'bg_image' ) { ?>
						<div class="hero-bg-img"
						     style="background: url(<?php echo esc_url( $header_settings['hero_bg_img_url'] ); ?>) <?php echo esc_attr( $header_settings['hero_bg_img_repeat'] ); ?>; background-size: cover; min-height: <?php echo esc_attr( $header_settings['hero_min_height'] ); ?>px;"></div>
					<?php } ?>
				</div>
				<?php if ( $header_settings['hero_enable_adv_imgs'] ) { ?>
					<div class="<?php echo esc_attr( $hero_adv_class ); ?>">
						<?php if ( trim( $header_settings['hero_adv_img_1_url'] ) != '' ) { ?>
							<div class="hero-adv-wrap hero-adv1-wrap"
							     style="height: <?php echo esc_attr( $header_settings['hero_min_height'] / 2 ); ?>px;">
								<a href="<?php echo esc_url( $header_settings['hero_adv_1_link'] ); ?>"
								   target="<?php echo esc_attr( $header_settings['hero_adv_1_link_target'] ); ?>"
								   class="lk-adv-banner-bg lk-adv-banner-bg-1 hover-effect-crossing"
								   style="background: url(<?php echo esc_url( $header_settings['hero_adv_img_1_url'] ); ?>) no-repeat; background-size: cover;">
								</a>
								<?php if ( trim( $header_settings['hero_adv_1_title'] ) != '' || trim( $header_settings['hero_adv_1_subtitle'] ) != '' ) { ?>
									<div class="adv-content">
										<?php if ( trim( $header_settings['hero_adv_1_subtitle'] ) != '' ) { ?>
											<span class="adv-sub-title">
												<?php echo sanitize_text_field( $header_settings['hero_adv_1_subtitle'] ); ?>
											</span>
										<?php } ?>
										<?php if ( trim( $header_settings['hero_adv_1_title'] ) != '' ) { ?>
											<h5 class="adv-title"><?php echo sanitize_text_field( $header_settings['hero_adv_1_title'] ); ?></h5>
										<?php } ?>
									</div>
								<?php } ?>
							</div>
						<?php } ?>
						<?php if ( trim( $header_settings['hero_adv_img_2_url'] ) != '' ) { ?>
							<div class="hero-adv-wrap hero-adv2-wrap"
							     style="height: <?php echo esc_attr( $header_settings['hero_min_height'] / 2 ); ?>px;">
								<a href="<?php echo esc_url( $header_settings['hero_adv_2_link'] ); ?>"
								   target="<?php echo esc_attr( $header_settings['hero_adv_2_link_target'] ); ?>"
								   class="lk-adv-banner-bg lk-adv-banner-bg-2 hover-effect-crossing"
								   style="background: url(<?php echo esc_url( $header_settings['hero_adv_img_2_url'] ); ?>) no-repeat; background-size: cover;">
								</a>
								<?php if ( trim( $header_settings['hero_adv_2_title'] ) != '' || trim( $header_settings['hero_adv_2_subtitle'] ) != '' ) { ?>
									<div class="adv-content">
										<?php if ( trim( $header_settings['hero_adv_2_subtitle'] ) != '' ) { ?>
											<span class="adv-sub-title">
												<?php echo sanitize_text_field( $header_settings['hero_adv_2_subtitle'] ); ?>
											</span>
										<?php } ?>
										<?php if ( trim( $header_settings['hero_adv_2_title'] ) != '' ) { ?>
											<h5 class="adv-title"><?php echo sanitize_text_field( $header_settings['hero_adv_2_title'] ); ?></h5>
										<?php } ?>
									</div>
								<?php } ?>
							</div>
						<?php } ?>
					</div>
				<?php } ?>
			</div>
		</div>
	</div><!-- ./hero-section -->

<?php } ?>