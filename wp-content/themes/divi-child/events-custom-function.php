<?php
/**
 * Paste this into your theme's custom-function.php
 * (No ACF field registration here — that's handled by the imported
 * "Concert / Event Details" field group, so it now shows up under
 * Custom Fields > Field Groups in wp-admin.)
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Swiper + GSAP assets.
 * These load sitewide by default (simplest for a Divi Code module,
 * since Divi stores module content in meta, not post_content, so
 * WordPress's has_shortcode() scan can't reliably detect it).
 * If you only want it on specific pages, wrap this in a conditional
 * like is_page( 123 ).
 */
add_action( 'wp_enqueue_scripts', 'wpdivi5_enqueue_carousel_assets' );
function wpdivi5_enqueue_carousel_assets() {

    wp_enqueue_style(
        'swiper-css',
        'https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css',
        array(),
        '8.0'
    );

    wp_enqueue_script(
        'swiper-js',
        'https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js',
        array(),
        '8.0',
        true
    );

    wp_enqueue_script(
        'gsap-js',
        'https://cdn.jsdelivr.net/npm/gsap@3/dist/gsap.min.js',
        array(),
        '3.0',
        true
    );
}

/**
 * [concert_archive] shortcode
 * Loops over "event" posts and pulls values from the ACF fields:
 * event_status, event_image, artist_name, event_year, event_country, tour_name
 */
add_shortcode( 'concert_archive', 'wpdivi5_concert_archive_shortcode' );
function wpdivi5_concert_archive_shortcode( $atts ) {

    $atts = shortcode_atts( array(
        'posts_per_page' => -1,
        'order'          => 'DESC',
    ), $atts, 'concert_archive' );

    $query = new WP_Query( array(
        'post_type'      => 'event',
        'posts_per_page' => intval( $atts['posts_per_page'] ),
        'orderby'        => 'meta_value_num',
        'meta_key'       => 'event_year',
        'order'          => sanitize_text_field( $atts['order'] ),
        'post_status'    => 'publish',
    ) );

    ob_start();

    if ( $query->have_posts() ) : ?>

        <section class="concert-archive">
            <div class="archive-heading">
                <h2>
                    LEGENDARY NIGHTS.<br>
                    UNFORGETTABLE MEMORIES.
                </h2>
                <p>
                    From Sydney to Singapore, Mumbai to Auckland,
                    relive iconic Bollywood concerts that have thrilled
                    hundreds of thousands of fans across six countries.
                </p>
                <div class="gold-line"></div>
            </div>

            <div class="swiper concertSwiper">
                <div class="swiper-wrapper">
                    <?php while ( $query->have_posts() ) : $query->the_post();

                        $status  = get_field( 'event_status' );
                        $status  = $status ? $status : 'PAST EVENT';
                        $image   = get_field( 'event_image' );
                        $image   = $image ? $image : 'https://picsum.photos/500/700';
                        $artist  = get_field( 'artist_name' );
                        $year    = get_field( 'event_year' );
                        $country = get_field( 'event_country' );
                        $tour    = get_field( 'tour_name' );
                        ?>
                        <div class="swiper-slide">
                            <div class="concert-card">
                                <img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $artist ); ?>">
                                <div class="overlay">
                                    <span><?php echo esc_html( $status ); ?></span>
                                    <h3><?php echo esc_html( $artist ); ?></h3>
                                    <h4><?php echo esc_html( trim( $year . ' • ' . $country, ' •' ) ); ?></h4>
                                    <p><?php echo esc_html( $tour ); ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>
            </div>

            <div class="drag-text">
                Drag to spin the archive • Hover a concert to bring it forward
            </div>
        </section>

        <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof Swiper === 'undefined') return;

            new Swiper(".concertSwiper", {
                slidesPerView: "auto",
                centeredSlides: true,
                spaceBetween: 0,
                grabCursor: true,
                loop: true,
                speed: 5000,
                mousewheel: true,
                autoplay: {
                    delay: 0,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true,
                },
            });

            if (typeof gsap === 'undefined') return;

            document.querySelectorAll('.concert-card').forEach(function (card) {
                card.addEventListener('mouseenter', function () {
                    gsap.to(card, { scale: 1.15, duration: .35, rotation: 0, ease: "power2.out" });
                });
                card.addEventListener('mouseleave', function () {
                    gsap.to(card, { scale: 1, rotation: Math.random() * 6 - 3, duration: .35 });
                });
            });
        });
        </script>

    <?php else : ?>

        <p>No events found. Add some Event posts and fill in the Concert / Event Details fields.</p>

    <?php endif;

    return ob_get_clean();
}
