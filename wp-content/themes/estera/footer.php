<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Estera
 */

/**
 * Footer
 *
 * @hooked estera_back_to_top
 */

do_action( 'estera_footer' );

?>

	<footer id="colophon" class="site-footer">
		<div class="site-info">

		<?php if( get_theme_mod( 'footer_text_block')) : ?> 
		<?php echo esc_html(get_theme_mod( 'footer_text_block')); ?>
		
		<?php else :
			esc_html_e('Designed by', 'estera'); ?>
			<a href="<?php echo esc_url( __('https://nasiothemes.com/', 'estera' ) ); ?>" class="imprint">
				<?php esc_html_e ( 'Nasio Themes', 'estera' ); ?>
        	</a>
			<span class="sep"> || </span>
				<?php
				/* translators: %s: CMS name, i.e. WordPress. */
				esc_html_e('Powered by', 'estera'); ?>
				<a href="<?php echo esc_url( __('https://wordpress.com/', 'estera' ) ); ?>" class="imprint">
					<?php esc_html_e ( 'WordPress', 'estera' ); ?>
				</a>
		<?php endif ?>
		<?php 
		$isDarkMode = get_theme_mod('enable_dark_mode', 1);
		if ($isDarkMode) : ?>
		<button class="wpnm-button">
			<div class="wpnm-button-inner-left"></div>
			<div class="wpnm-button-inner"></div>
		</button>
		<?php endif; ?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>