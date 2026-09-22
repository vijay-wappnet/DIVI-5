<?php
/**
 * Append this to your existing custom-function.php
 * (below the concert_archive code you already added).
 *
 * Requires the imported ACF field group "Home Page - Hero Slider"
 * (repeater field: hero_slides) which only appears on your
 * Static Front Page (Settings > Reading).
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * [hero_slider] shortcode — place this on your Home page
 * (e.g. inside the Divi Code module currently holding the hardcoded markup).
 */
add_shortcode( 'hero_slider', 'wpdivi5_hero_slider_shortcode' );
function wpdivi5_hero_slider_shortcode() {

    // hero_slides repeater lives on the front page — get_field() with
    // no ID defaults to the currently queried post, so this works as
    // long as the shortcode sits on that same page.
    $slides = get_field( 'hero_slides' );

    if ( empty( $slides ) || ! is_array( $slides ) ) {
        return '<p>No hero slides found. Add slides under the "Home Page - Hero Slider" field group on this page.</p>';
    }

    ob_start();
    ?>
    <div class="hero-slider swiper">
        <div class="swiper-wrapper">

            <?php foreach ( $slides as $slide ) :
                $subtitle   = $slide['subtitle'];
                $heading    = $slide['heading'];
                $description = $slide['description'];
                $image      = $slide['slide_image'] ? $slide['slide_image'] : '';
                $btn1_text  = $slide['button1_text'];
                $btn1_link  = $slide['button1_link'] ? $slide['button1_link'] : '#';
                $btn2_text  = $slide['button2_text'];
                $btn2_link  = $slide['button2_link'] ? $slide['button2_link'] : '#';
                ?>
                <div class="swiper-slide">
                    <div class="slide-bg" style="background-image:url('<?php echo esc_url( $image ); ?>');"></div>
                    <div class="slide-overlay"></div>

                    <div class="slide-content">
                        <?php if ( $subtitle ) : ?>
                            <span class="subtitle"><?php echo esc_html( $subtitle ); ?></span>
                        <?php endif; ?>

                        <?php if ( $heading ) : ?>
                            <h1><?php echo esc_html( $heading ); ?></h1>
                        <?php endif; ?>

                        <?php if ( $description ) : ?>
                            <p><?php echo esc_html( $description ); ?></p>
                        <?php endif; ?>

                        <?php if ( $btn1_text || $btn2_text ) : ?>
                            <div class="slider-buttons">
                                <?php if ( $btn1_text ) : ?>
                                    <a href="<?php echo esc_url( $btn1_link ); ?>" class="btn btn-primary"><?php echo esc_html( $btn1_text ); ?></a>
                                <?php endif; ?>
                                <?php if ( $btn2_text ) : ?>
                                    <a href="<?php echo esc_url( $btn2_link ); ?>" class="btn btn-secondary"><?php echo esc_html( $btn2_text ); ?></a>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>

        <div class="swiper-pagination"></div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        if (typeof Swiper === 'undefined') return;

        new Swiper(".hero-slider", {
            effect: "fade",
            speed: 1200,
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            fadeEffect: {
                crossFade: true,
            },
        });
    });
    </script>
    <?php

    return ob_get_clean();
}
