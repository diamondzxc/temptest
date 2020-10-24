<?php
namespace PrimeSlider\Modules\General\Skins;

use Elementor\Skin_Base as Elementor_Skin_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Skin_Slide extends Elementor_Skin_Base {

	public function get_id() {
		return 'slide';
	}

	public function get_title() {
		return esc_html__( 'Slide', 'bdthemes-prime-slider' );
	}

    public function render_navigation_arrows() {
        $settings = $this->parent->get_settings_for_display();

        ?>

            <?php if ($settings['show_navigation_arrows']) : ?>

                <div class="bdt-navigation-arrows bdt-position-center-right">
                    <a class="bdt-prime-slider-previous" href="#" bdt-slidenav-previous bdt-slideshow-item="previous"></a>
    
                    <a class="bdt-prime-slider-next" href="#" bdt-slidenav-next bdt-slideshow-item="next"></a>
                </div>


            <?php endif; ?>

        <?php
    }

    public function render_header($skin_name = 'slide') {
		$settings = $this->parent->get_settings_for_display();

		$this->parent->header_sticky_render();

		$this->parent->add_render_attribute('header', 'class', 'bdt-prime-header-skin-' . $skin_name);
		$this->parent->add_render_attribute('slider', 'class', 'bdt-prime-slider-skin-' . $skin_name);

		$ratio = ($settings['slider_size_ratio']['width'] && $settings['slider_size_ratio']['height']) ? $settings['slider_size_ratio']['width'] . ":" . $settings['slider_size_ratio']['height'] : '16:9';

		$this->parent->add_render_attribute(
			[
				'slideshow' => [
					'bdt-slideshow' => [
						wp_json_encode([
							"animation"         => 'fade',
							"ratio"             => $ratio,
							"min-height"        => ($settings["slider_min_height"]["size"]) ? $settings["slider_min_height"]["size"] : 380,
							"autoplay"          => ($settings["autoplay"]) ? true : false,
							"autoplay-interval" => $settings["autoplay_interval"],
                            "pause-on-hover"    => ("yes" === $settings["pause_on_hover"]) ? true : false,
                            "velocity"          => ($settings["velocity"]["size"]) ? $settings["velocity"]["size"] : 1,
							"finite"            => ($settings["finite"]) ? false : true,
						])
					]
				]
			]
		);

		?>
			<div class="bdt-prime-slider">
				<div class="bdt-header-wrapper bdt-position-top">
					<header <?php echo $this->parent->get_render_attribute_string('header'); ?>>
						<div class="bdt-prime-slider-container">
							<div class="bdt-header-inner bdt-flex bdt-flex-middle" bdt-grid>
								<div class="bdt-width-auto">
									<div class="bdt-prime-slider-logo bdt-flex bdt-flex-middle">

										<?php $this->parent->render_logo(); ?>

									</div>
								</div>
								<div class="bdt-width-expand">

									<?php $this->parent->render_menu($skin_name, 'bdt-width-expand'); ?>

								</div>
							</div>
						</div>
					</header>
				</div>

				<div <?php echo $this->parent->get_render_attribute_string('slider'); ?>>

				<div class="bdt-position-relative bdt-visible-toggle" <?php echo $this->parent->get_render_attribute_string('slideshow'); ?>>

					<ul class="bdt-slideshow-items">
		<?php
	}

    public function render_navigation_dots() {
        $settings = $this->parent->get_settings_for_display();

        ?>
            <?php if ($settings['show_navigation_dots']) : ?>

                <ul class="bdt-dotnav bdt-dotnav-vertical bdt-margin-bottom-100 bdt-margin-left-100 bdt-position-bottom-left bdt-text-center">

                    <?php $slide_index = 1; foreach ( $settings['slides'] as $slide ) : ?>
                    <li bdt-slideshow-item="<?php echo ($slide_index - 1); ?>" data-label="<?php echo str_pad( $slide_index, 2, '0', STR_PAD_LEFT); ?>" ><a href="#"></a></li>
                    <?php $slide_index++;  endforeach; ?>
                    
                </ul>

            <?php endif; ?>

        <?php
    }

    public function render_footer() {
        ?>
                
            </ul>
                
                <?php $this->render_navigation_arrows(); ?>
                <?php $this->render_navigation_dots(); ?>

            </div>
        </div>
        <?php $this->parent->render_offcanvas(); ?>
        <?php
    }

    public function rendar_item_content($slide_content) {
        $settings = $this->parent->get_settings_for_display();

        $this->parent->add_render_attribute(
			[
				'title-link' => [
					'class' => [
						'bdt-slider-title-link',
					],
					'href'   => $slide_content['title_link']['url'] ? esc_url($slide_content['title_link']['url']) : 'javascript:void(0);',
					'target' => $slide_content['title_link']['is_external'] ? '_blank' : '_self'
				]
			], '', '', true
		);

        ?>

        <div class="bdt-ps-content-wrapper bdt-position-z-index bdt-position-large">
            
            <div class="bdt-slide-shape" bdt-slideshow-parallax="Y: -100,0,100; opacity: 1,1,0"></div>
            <div class="bdt-prime-slider-wrapper">
                <div class="bdt-prime-slider-content">
                    <div class="bdt-prime-slider-desc">

                        <?php if ($slide_content['title'] && ( 'yes' == $settings['show_title'] )) : ?>
                            <div class="bdt-main-title"  bdt-slideshow-parallax="x: 300,0,-100; opacity: 1,1,0">
                                <<?php echo esc_html($settings['title_html_tag']); ?> class="bdt-title-tag">
                                    <?php if ( '' !== $slide_content['title_link']['url'] ) : ?>
                                        <a <?php echo $this->parent->get_render_attribute_string( 'title-link' ); ?>>
                                    <?php endif; ?>
                                        <?php echo wp_kses_post($slide_content['title']); ?>
                                    <?php if ( '' !== $slide_content['title_link']['url'] ) : ?>
                                        </a>
                                    <?php endif; ?>
                                </<?php echo esc_html($settings['title_html_tag']); ?>>
                            </div>
                        <?php endif; ?>

                        <?php if ($slide_content['sub_title'] && ( 'yes' == $settings['show_sub_title'] )) : ?>
                            <div class="bdt-sub-title">
                                <h4 bdt-slideshow-parallax="x: 500,0,-100; opacity: 1,1,0">
                                <?php echo wp_kses_post($slide_content['sub_title']); ?>
                                </h4>
                            </div>
                        <?php endif; ?>
                        
                    </div>
                </div>
            </div>

        </div>

        <div class="bdt-slide-featured bdt-flex">
            
            <?php if ($slide_content['excerpt'] && ( 'yes' == $settings['show_excerpt'] )) : ?>
                <div class="bdt-slider-excerpt" bdt-slideshow-parallax="y: 100,0,-50; opacity: 1,1,0">
                    
                    <?php echo wp_kses_post($slide_content['excerpt']); ?>

                </div>
            <?php endif; ?>
            
            <div class="bdt-prime-slider-arrow-button" bdt-slideshow-parallax="x: 100,0,-50; opacity: 1,1,0">
               <?php $this->parent->render_button($slide_content); ?>
            </div>

        </div>

        <?php
    }

    public function render_slides_loop() {
        $settings = $this->parent->get_settings_for_display();

        $kenburns_reverse = $settings['kenburns_reverse'] ? ' bdt-animation-reverse' : '';

        foreach ( $settings['slides'] as $slide ) : ?>
                    
            <li class="bdt-slideshow-item bdt-flex bdt-flex-middle bdt-flex-center elementor-repeater-item-<?php echo esc_attr($slide['_id']); ?>">
                <?php if( 'yes' == $settings['kenburns_animation'] ) : ?>
                    <div class="bdt-position-cover bdt-animation-kenburns<?php echo esc_attr( $kenburns_reverse ); ?> bdt-transform-origin-center-left">
                <?php endif; ?>

                    <?php if (( $slide['background'] == 'image' ) && $slide['image']) : ?>
                        <?php $this->parent->rendar_item_image($slide, $slide['title']); ?>
                    <?php elseif (( $slide['background'] == 'video' ) && $slide['video_link']) : ?>
                        <?php $this->parent->rendar_item_video($slide); ?>
                    <?php elseif (( $slide['background'] == 'youtube' ) && $slide['youtube_link']) : ?>
                        <?php $this->parent->rendar_item_youtube($slide); ?>
                    <?php endif; ?>

                <?php if( 'yes' == $settings['kenburns_animation'] ) : ?>
                    </div>
                <?php endif; ?>

                <?php if( 'none' !== $settings['overlay'] ) :
                    $blend_type = ( 'blend' == $settings['overlay']) ? ' bdt-blend-'.$settings['blend_type'] : ''; ?>
                    <div class="bdt-overlay-default bdt-position-cover<?php echo esc_attr($blend_type); ?>"></div>
                <?php endif; ?>

                <?php 
                    
                    $this->rendar_item_content( $slide );
                    
                ?>
            </li>

        <?php endforeach;
    }


	public function render() {
        $this->render_header();

        $this->render_slides_loop();

        $this->render_footer();

	}
}