<?php
/**
 * Plugin Name: WebEng Projects
 * Description: Custom post type and taxonomy for student projects.
 * Version: 1.0.0
 * License: GPL-2.0-or-later
 */
defined('ABSPATH') || exit;

function webeng_register_projects(): void {
    register_post_type('project', [
        'labels' => ['name' => 'Projects', 'singular_name' => 'Project'],
        'public' => true, 'has_archive' => true, 'show_in_rest' => true,
        'menu_icon' => 'dashicons-portfolio',
        'supports' => ['title', 'editor', 'thumbnail', 'excerpt'],
        'rewrite' => ['slug' => 'projects'],
    ]);
    register_taxonomy('skill', 'project', ['label' => 'Skills', 'hierarchical' => false, 'show_in_rest' => true]);
}
add_action('init', 'webeng_register_projects');
register_activation_hook(__FILE__, function (): void { webeng_register_projects(); flush_rewrite_rules(); });
add_shortcode('project_count', fn(): string => esc_html((string) wp_count_posts('project')->publish));
