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
			<dt><?php _e( 'Address', 'orbis' ); ?></dt>
			<dd>
				<?php echo $address; ?><br />
				<?php echo $postcode, ' ', $city; ?><br />
				<?php echo $country; ?>
			</dd>

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

			<dt><?php _e( 'Electronic billing', 'orbis' ); ?></dt>
			<dd><?php echo $ebilling ? __( 'Yes', 'orbis' ) :  __( 'No', 'orbis' ); ?></dd>

			<dt><?php _e( 'KvK Number', 'orbis' ); ?></dt>
			<dd><?php echo $kvk_number; ?></dd>
		</dl>
	</div>
</div>