			<footer id="footer">
				<?php

				printf( __( '&copy; %1$s %2$s. WordPress theme by <a href="%3$s">Pronamic</a>, based on <a href="%4$s">Bootstrap</a>.', 'orbis' ),
					date( 'Y' ),
					get_bloginfo( 'site-title' ),
					'http://pronamic.nl/',
					'http://twitter.github.com/bootstrap/'
				);

				?>
			</footer>
		</div>

		<?php wp_footer(); ?>
	</body>
</html>