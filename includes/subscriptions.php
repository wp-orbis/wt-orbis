<?php

function orbis_subscription_product_render_details() {
	if ( is_singular( 'orbis_subs_product' ) ) {
		global $orbis_subscriptions_plugin;

		get_template_part( 'templates/subscription_product_details' );
	}
}

add_action( 'orbis_before_side_content', 'orbis_subscription_product_render_details' );
