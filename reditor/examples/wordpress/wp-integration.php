<?php
/**
 * Plugin Name: REditor WP REST Adapter
 * Description: Custom REST endpoints and post meta saving for REditor integration in WordPress.
 */

add_action('rest_api_init', function () {
    register_rest_route('reditor/v1', '/save-post', [
        'methods' => 'POST',
        'callback' => 'reditor_save_post_callback',
        'permission_callback' => function () {
            return current_user_can('edit_posts');
        }
    ]);
});

function reditor_save_post_callback(WP_REST_Request $request) {
    $params = $request->get_json_params();
    
    $post_id = wp_update_post([
        'ID'           => intval($params['post_id'] ?? 0),
        'post_title'   => sanitize_text_field($params['post_title']),
        'post_content' => wp_kses_post($params['post_content']),
        'post_status'  => sanitize_text_field($params['post_status'] ?? 'publish'),
    ], true);

    if (is_wp_error($post_id)) {
        return new WP_Error('save_failed', $post_id->get_error_message(), ['status' => 400]);
    }

    if (!empty($params['blocks_json'])) {
        update_post_meta($post_id, '_reditor_blocks_json', wp_unslash($params['blocks_json']));
    }

    return rest_ensure_response([
        'success' => true,
        'post_id' => $post_id
    ]);
}