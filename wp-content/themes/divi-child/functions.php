<?php
/* Enqueue Script and Style */
function dt_enqueue_styles()
{
    $parenthandle = 'divi-style';
    $theme = wp_get_theme();

    wp_enqueue_style(
        $parenthandle,
        get_template_directory_uri() . '/style.css',
        array(),
        $theme->parent()->get('Version')
    );
    wp_enqueue_style(
        'child-style',
        get_stylesheet_uri(),
        array($parenthandle),
        $theme->get('Version')
    );

    wp_enqueue_script('div-child-script', get_stylesheet_directory_uri() . '/js/custom-script.js', array('jquery'), $theme->get('Version'), true);
    wp_enqueue_script('div-child-equalheight', get_stylesheet_directory_uri() . '/js/equalheight.js', array('jquery'), $theme->get('Version'), true);
    wp_localize_script('divi-child-script', 'ajax_object', array(
        'ajaxurl' => admin_url('admin-ajax.php')
    ));
}
add_action('wp_enqueue_scripts', 'dt_enqueue_styles');

function custom_divi_viewport()
{
    remove_action('wp_head', 'et_add_viewport_meta');
    echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">' . "\n";
}
add_action('wp_head', 'custom_divi_viewport', 1);

/* Custom Banner Breadcrumb */
function cvbm_banner_breadcrumb_shortcode()
{
    // Home URL
    $home_url = home_url('/');
    $home_title = 'Home';

    // Current page title
    $current_title = single_post_title('', false);

    // If it's blog home
    if (is_home() || is_front_page()) {
        $current_title = 'Home';
    }

    ob_start();
?>
    <nav class="cvbm-breadcrumb">
        <a href="<?php echo esc_url($home_url); ?>" class="breadcrumb-home">
            <?php echo esc_html($home_title); ?>
        </a>
        <span class="breadcrumb-separator">|</span>
        <span class="breadcrumb-current">
            <?php echo esc_html($current_title); ?>
        </span>
    </nav>
<?php
    return ob_get_clean();
}
add_shortcode('cvbm_breadcrumb', 'cvbm_banner_breadcrumb_shortcode');


function add_svg_to_upload_mimes( $existing_mimes ) {
    $existing_mimes['svg'] = 'image/svg+xml';
    return $existing_mimes;
}
add_filter( 'upload_mimes', 'add_svg_to_upload_mimes' );

// ============================================
// Constant Contact + CF7 Integration
// Fully Automatic Token Refresh — No Manual Work
// ============================================

define( 'CTCT_CLIENT_ID',     '753d64ce-b116-44f3-ae6d-fc75ffde4582' );
define( 'CTCT_CLIENT_SECRET', '2zTqRy_3SJ8mmCI1h2ySYA' );
define( 'CTCT_LIST_ID',       'c9907370-f542-11e2-8eef-d4ae528e486a' );
define( 'CTCT_BUYER_CF_ID',   '3043a37a-3e10-11f1-a3c1-02420a320002' );

// Store initial tokens if not already stored
if ( ! get_option( 'ctct_access_token' ) ) {
    update_option( 'ctct_access_token', 'eyJraWQiOiJNTm1PZWFlWV8yNjc1cFBhNzFBQnVGRThBd2JfY2hTY0JTNXpKYXFaNGpFIiwiYWxnIjoiUlMyNTYifQ.eyJ2ZXIiOjEsImp0aSI6IkFULjJ1b0s3anNMR1A4M0liVUpZS2llZy1fd2lHbGt5eGpnYlAyakNFR2RWOGMub2FyMmE5ZTJwaEc1NEd2MlQwaDciLCJpc3MiOiJodHRwczovL2lkZW50aXR5LmNvbnN0YW50Y29udGFjdC5jb20vb2F1dGgyL2F1czFsbTNyeTltRjd4MkphMGg4IiwiYXVkIjoiaHR0cHM6Ly9hcGkuY2MuZW1haWwvdjMiLCJpYXQiOjE3NzY4NDE2NzQsImV4cCI6MTc3NjkyODA3NCwiY2lkIjoiNzUzZDY0Y2UtYjExNi00NGYzLWFlNmQtZmM3NWZmZGU0NTgyIiwidWlkIjoiMDB1MjZudTR2YmI2eTVmMXUwaDgiLCJzY3AiOlsib2ZmbGluZV9hY2Nlc3MiLCJjb250YWN0X2RhdGEiXSwiYXV0aF90aW1lIjoxNzc2ODM2NTYwLCJzdWIiOiJhbmtpdEB3YXBwbmV0LmNvbSIsInBsYXRmb3JtX3VzZXJfaWQiOiJlY2EzOWZiYy1jNWMyLTQwMDctYmEzNy0yOTkwYzg2MzZlZGEifQ.bQ7TVdXForOYtXGSMGchgD399xYOlfbByJXX8DsTOt2hlmEB1zCNVoaDFX1QkHzDngspj6lneVmfUS2lOx2ZSVIHnNAIVcnZdtN3mBmrYgV92SvqnEqK2ZGjSv2lsJ9bZkmqm5Lz03IjW7DTsr_jUEN9uj13_PcaEU3HJ1tVPzoXFgZw3XlZZkLySKNNAoemscwVZBmW-QpRPWup5ilfCdRFVW7wapzI20DGjDkc6hIufSKDOgvf0qWo50hwnjC8DNqgQqHDaihHpLvMaZENvK4TrIEaanL5j2P_2DnTW_DghmbQ_CdfVro-bM-HuLDQ15sldRXLUu5FF2dNRCguQg' );
}
if ( ! get_option( 'ctct_refresh_token' ) ) {
    update_option( 'ctct_refresh_token', 'n-1dMx8Dgk8b0QHiqRm2c4vFYeNFXNVu8E8M2_G6ncA' );
}

// ============================================
// Auto Token Refresh Function
// ============================================

function ctct_refresh_access_token() {
    $refresh_token = get_option( 'ctct_refresh_token' );
    if ( ! $refresh_token ) {
        error_log( 'CTCT: No refresh token found in DB.' );
        return false;
    }

    $response = wp_remote_post(
        'https://authz.constantcontact.com/oauth2/default/v1/token',
        [
            'method'  => 'POST',
            'headers' => [
                'Authorization' => 'Basic ' . base64_encode( CTCT_CLIENT_ID . ':' . CTCT_CLIENT_SECRET ),
                'Content-Type'  => 'application/x-www-form-urlencoded',
            ],
            'body'    => 'grant_type=refresh_token&refresh_token=' . urlencode( $refresh_token ),
            'timeout' => 15,
        ]
    );

    if ( is_wp_error( $response ) ) {
        error_log( 'CTCT Refresh Error: ' . $response->get_error_message() );
        return false;
    }

    $body = json_decode( wp_remote_retrieve_body( $response ), true );

    if ( ! empty( $body['access_token'] ) ) {
        update_option( 'ctct_access_token',  $body['access_token'] );
        update_option( 'ctct_refresh_token', $body['refresh_token'] );
        update_option( 'ctct_token_updated', current_time( 'timestamp' ) );
        error_log( 'CTCT: Token auto-refreshed successfully at ' . current_time( 'mysql' ) );
        return true;
    }

    error_log( 'CTCT: Token refresh failed - ' . wp_remote_retrieve_body( $response ) );
    return false;
}

// ============================================
// Schedule Cron Every 20 Hours (before 24hr expiry)
// ============================================

add_action( 'ctct_auto_refresh_hook', 'ctct_refresh_access_token' );

if ( ! wp_next_scheduled( 'ctct_auto_refresh_hook' ) ) {
    wp_schedule_event( time(), 'ctct_every_20_hours', 'ctct_auto_refresh_hook' );
}

// Register custom 20-hour interval
add_filter( 'cron_schedules', function( $schedules ) {
    $schedules['ctct_every_20_hours'] = [
        'interval' => 20 * HOUR_IN_SECONDS,
        'display'  => 'Every 20 Hours',
    ];
    return $schedules;
});

// ============================================
// CF7 Form Submission Handler
// ============================================

add_action( 'wpcf7_mail_sent', 'ctct_cf7_sync_contact' );

function ctct_cf7_sync_contact( $contact_form ) {

    $submission = WPCF7_Submission::get_instance();
    if ( ! $submission ) return;

    $data = $submission->get_posted_data();

    $first_name = sanitize_text_field( $data['first-name'] ?? '' );
    $email      = sanitize_email( $data['your-email'] ?? '' );
    $buyer_type = sanitize_text_field( $data['select-1'] ?? '' );

    if ( empty( $email ) ) return;

    $buyer_choice_map = [
        'New Buyer'          => 23189,
        'Returning Customer' => 6423,
    ];
    $choice_id = $buyer_choice_map[ $buyer_type ] ?? null;

    $body = [
        'email_address'    => [
            'address'            => $email,
            'permission_to_send' => 'implicit',
        ],
        'first_name'       => $first_name,
        'list_memberships' => [ CTCT_LIST_ID ],
        'create_source'    => 'Contact',
    ];

    if ( $choice_id ) {
        $body['custom_fields'] = [
            [
                'custom_field_id' => CTCT_BUYER_CF_ID,
                'value'           => (string) $choice_id,
            ]
        ];
    }

    // Get current token from DB
    $access_token = get_option( 'ctct_access_token' );

    $response = wp_remote_post(
        'https://api.cc.email/v3/contacts',
        [
            'method'  => 'POST',
            'headers' => [
                'Authorization' => 'Bearer ' . $access_token,
                'Content-Type'  => 'application/json',
                'Accept'        => 'application/json',
            ],
            'body'    => wp_json_encode( $body ),
            'timeout' => 15,
        ]
    );

    if ( is_wp_error( $response ) ) {
        error_log( 'CTCT WP Error: ' . $response->get_error_message() );
        return;
    }

    $code     = wp_remote_retrieve_response_code( $response );
    $res_body = wp_remote_retrieve_body( $response );

    // If token expired, refresh it and retry once
    if ( $code === 401 ) {
        error_log( 'CTCT: Token expired during submission, refreshing...' );
        $refreshed = ctct_refresh_access_token();

        if ( $refreshed ) {
            $access_token = get_option( 'ctct_access_token' );
            $response = wp_remote_post(
                'https://api.cc.email/v3/contacts',
                [
                    'method'  => 'POST',
                    'headers' => [
                        'Authorization' => 'Bearer ' . $access_token,
                        'Content-Type'  => 'application/json',
                        'Accept'        => 'application/json',
                    ],
                    'body'    => wp_json_encode( $body ),
                    'timeout' => 15,
                ]
            );
            $code     = wp_remote_retrieve_response_code( $response );
            $res_body = wp_remote_retrieve_body( $response );
        }
    }

    if ( $code >= 400 ) {
        error_log( 'CTCT API Error ' . $code . ': ' . $res_body );
    } else {
        error_log( 'CTCT Success: Contact added - ' . $email );
    }
}

?>