<?php $tweets = $connection->get( 'https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=' . $screen_name . '&count=' . $number );

if ( $tweets ) : ?>

	<ul class="post-list">
		<?php foreach ( $tweets as $tweet ) : ?>

			<li>
				<?php echo $tweet->text; ?>
			</li>

		<?php endforeach; ?>
	</ul>

<?php endif; ?>