<div class="panel">
	<header>
		<h3><?php _e( 'Subscription Product Details', 'orbis' ); ?></h3>
	</header>

	<div class="content">
		<dl>
			<dt><?php _e( 'Price', 'orbis' ); ?></dt>
			<dd>
				<?php 
				
				$price = get_post_meta( get_the_ID(), '_orbis_subscription_product_price', true );
				
				if ( empty( $price ) ) {
					echo '&mdash;';
				} else {
					echo orbis_price( $price );
				}

				?>
			</dd>

			<dt><?php _e( 'Cost Price', 'orbis' ); ?></dt>
			<dd>
				<?php 
				
				$price = get_post_meta( get_the_ID(), '_orbis_subscription_product_cost_price', true );
				
				if ( empty( $price ) ) {
					echo '&mdash;';
				} else {
					echo orbis_price( $price );
				}

				?>
			</dd>

			<dt><?php _e( 'Auto Renew', 'orbis' ); ?></dt>
			<dd>
				<?php 

				$auto_renew = get_post_meta( get_the_ID(), '_orbis_subscription_product_auto_renew', true );

				echo $auto_renew ? __( 'Yes', 'orbis' ) : __( 'No', 'orbis' );

				?>
			</dd>
		</dl>
	</div>
</div>