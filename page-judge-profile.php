<?php
/**
 * Template Name: Judge Profile
 */

get_header();

// Get the user ID from URL
$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;

// If no user ID provided, check if we can get it from username in URL
if ($user_id == 0 && isset($_GET['username'])) {
    $username = sanitize_user($_GET['username']);
    $user = get_user_by('login', $username);
    if (!$user) {
        $user = get_user_by('slug', $username);
    }
    if ($user) {
        $user_id = $user->ID;
    }
}

// Verify this is actually a judge
$is_judge = false;
if ($user_id > 0 && function_exists('pmpro_getMembershipLevelForUser')) {
    $user_level = pmpro_getMembershipLevelForUser($user_id);
    $is_judge = !empty($user_level) && $user_level->id == 3; // Assuming 3 is the judge level
}

if ($user_id > 0 && $is_judge) {
    // Display judge-specific profile
    echo '<div class="user-profile">';
    echo do_shortcode('[pmpro_member_profile user_id="' . $user_id . '" elements="display_name;Email Address,user_email;School,school;Year Graduated,year_graduated;Availability,availability;Phone,phone;Contact Method,preferred_contact_method;Preferred Events,preferred_events_to_judge;"]');
    echo '</div>';
    
    // Add any judge-specific content or layout here
} else {
    // Not a judge or no user ID provided
    echo '<p>Judge profile not found.</p>';
}

get_footer();
