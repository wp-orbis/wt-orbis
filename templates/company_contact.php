<?php

global $post;

$kvk_number = get_post_meta( $post->ID, '_orbis_company_kvk_number', true );
$email      = get_post_meta( $post->ID, '_orbis_company_email', true );
$website    = get_post_meta( $post->ID, '_orbis_company_website', true );

$address    = get_post_meta( $post->ID, '_orbis_company_address', true );
$postcode   = get_post_meta( $post->ID, '_orbis_company_postcode', true );
$city       = get_post_meta( $post->ID, '_orbis_company_city', true );
$country    = get_post_meta( $post->ID, '_orbis_company_country', true );

$ebilling   = get_post_meta( $post->ID, '_orbis_company_ebilling', true );

?>
<div class="panel">
	<header>
		<h3><?php _e( 'Contact Details', 'orbis' ); ?></h3>
	</header>

	<div class="content">
		<dl>
			<?php if ( ! empty( $address ) || ! empty( $postcode ) || ! empty( $country ) ) : ?>

				<dt><?php _e( 'Address', 'orbis' ); ?></dt>
				<dd>
					<?php echo $address; ?><br />
					<?php echo $postcode, ' ', $city; ?><br />
					<?php echo $country; ?>
				</dd>
			
			<?php endif; ?>

			<?php if ( ! empty( $website ) ) : ?>

				<dt><?php _e( 'Website', 'orbis' ); ?></dt>
				<dd>
					<a href="<?php echo esc_attr( $website ); ?>" target="_blank"><?php echo $website; ?></a>
				</dd>

			<?php endif; ?>

			<?php if ( ! empty( $email ) ) : ?>
	
				<dt><?php _e( 'E-Mail', 'orbis' ); ?></dt>
				<dd>
					<a href="mailto:<?php echo esc_attr( $email ); ?>" target="_blank"><?php echo $email; ?></a>
				</dd>

			<?php endif; ?>

			<?php if ( function_exists( 'orbis_finance_bootstrap' ) ) : ?>

				<dt><?php _e( 'Electronic billing', 'orbis' ); ?></dt>
				<dd><?php echo $ebilling ? __( 'Yes', 'orbis' ) :  __( 'No', 'orbis' ); ?></dd>
			
			<?php endif; ?>

			<?php if ( ! empty( $kvk_number ) ) : ?>
	
				<dt><?php _e( 'KvK Number', 'orbis' ); ?></dt>
				<dd>
					<?php echo $kvk_number; ?>
					
					<?php 
					
					$url_open_kvk = sprintf( 'http://openkvk.nl/%s', $kvk_number );
					$url_kvk      = add_query_arg( 'q', $kvk_number, 'http://zoeken.kvk.nl/search.ashx' );
					
					?>
					<small>
						<a class="label label-info" href="<?php echo esc_attr( $url_open_kvk ); ?>" target="_blank">openkvk.nl</a>
						<a class="label label-info" href="<?php echo esc_attr( $url_kvk ); ?>" target="_blank">kvk.nl</a>
					</small>
				</dd>

			<?php endif; ?>
		</dl>
	</div>
</div>