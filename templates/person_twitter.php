<?php if ( get_option( 'orbis_twitter_widget_id' ) && get_post_meta( $post->ID, '_orbis_person_twitter', true ) ) : ?>

	<?php

	$twitter_widget_id = get_option( 'orbis_twitter_widget_id' );
	$twitter_username  = get_post_meta( $post->ID, '_orbis_person_twitter', true );
	$twitter_url       = sprintf( 'https://twitter.com/%s', $twitter_username );
	$twitter_text      = sprintf( __( 'Tweets from @%s', 'orbis' ), $twitter_username );

	?>

	<div class="panel">
		<header>
			<h3>
				<?php

				printf( __( '%1$s on Twitter', 'orbis' ),
					get_the_title()
				);

				?>
			</h3>
		</header>

		<div class="content">
			<p class="alt">
				<a class="twitter-timeline" href="<?php echo esc_attr( $twitter_url ); ?>" data-widget-id="<?php echo esc_attr( $twitter_widget_id ); ?>" data-screen-name="<?php echo esc_attr( $twitter_username ); ?>" height="300"><?php echo esc_html( $twitter_text ); ?></a>
				<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
			</p>
		</div>
	</div>

<?php endif; ?>
