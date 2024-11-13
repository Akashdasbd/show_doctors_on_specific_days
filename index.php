function show_doctors_on_specific_days() {
    $current_day = strtolower(date('l'));

    $args = array(
        'post_type'      => 'doctors',
        'posts_per_page' => -1,
    );

    $doctors = get_posts($args);
    $output = '';

    if (!empty($doctors)) {
        $output .= '<div class="doctors-list">';

        foreach ($doctors as $doctor) {
            $practice_days = get_post_meta($doctor->ID, 'practice_days', true);

            if (is_array($practice_days) && isset($practice_days[$current_day]) && $practice_days[$current_day] === 'true') {
                $name = get_the_title($doctor->ID);
                $img_url = get_the_post_thumbnail_url($doctor->ID, 'full');
                $specialities = get_post_meta($doctor->ID, 'specialities', true);
				$educational_details = get_post_meta($doctor->ID, 'educational_details', true);
				$experiences_doctor_about = get_post_meta($doctor->ID, 'doctor_about', true);
                $doctor_link = get_permalink($doctor->ID);

                $output .= '<div class="doctor-item">';
                $output .= '<a href="' . esc_url($doctor_link) . '">';
                if ($img_url) {
                    $output .= '<img src="' . esc_url($img_url) . '" alt="' . esc_attr($name) . '">';
                } else {
                    $output .= '<p>No image available</p>';
                }
                $output .= '<h2>' . esc_html($name) . '</h2>';
                $output .= '</a>';
                if (!empty($specialities)) {
                    $output .= '<p class="specialities"> ' . esc_html($specialities) . '</p>';
                }
				if(!empty($experiences_doctor_about)){
					$output.= '<p class="exper_doctor">'. esc_html($experiences_doctor_about) .'</p>';
				}
				 if (!empty($educational_details)) {
                    $output .= '<p class="educ_details"> ' . esc_html($educational_details) . '</p>';
                }
				
                $output .= '</div>';
            }
        }

        $output .= '</div>';
    } else {
        $output .= '<p>No doctors available today.</p>';
    }

    return $output;
}
add_shortcode('show_doctors_today', 'show_doctors_on_specific_days');
