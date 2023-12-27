<?php
/**
 * Footer Template
 */

// Footer
$display_footer 								= get_theme_mod( 'display_footer' , true );
$display_footer_separator						= get_theme_mod( 'display_footer_separator' , '' );
$display_footer_block_colophon_admin			= get_theme_mod( 'display_footer_block_colophon_admin' , '' );
$display_footer_block_colophon_copyright		= get_theme_mod( 'display_footer_block_colophon_copyright' , true );
$display_footer_block_colophon_terms_of_use		= get_theme_mod( 'display_footer_block_colophon_terms_of_use' , true );
$display_footer_block_colophon_credits			= get_theme_mod( 'display_footer_block_colophon_credits' , true );
$colophon										= __( 'Colophon', 'minisite-lite' );
$display_footer_block_colophon_copyright		= get_theme_mod( 'display_footer_block_colophon_copyright' , true );
$copyright_year									= __( 'Copyright &copy; ', 'minisite-lite' );
$display_footer_block_colophon_copyright_owner	= get_theme_mod( 'display_footer_block_colophon_copyright_owner' , true );
$display_footer_block_colophon_copyright_link	= get_theme_mod( 'display_footer_block_colophon_copyright_link' , true );
$footer_block_colophon_copyright_link			= get_theme_mod( 'footer_block_colophon_copyright_link', esc_url( home_url( '/' ) ) );
$footer_block_colophon_copyright_owner			= get_theme_mod( 'footer_block_colophon_copyright_owner', get_bloginfo( 'name', 'display' ) );
$all_rights_reserved							= __( 'All rights reserved.', 'minisite-lite' );
$footer_block_colophon_admin_link				= get_theme_mod( 'footer_block_colophon_admin_link', esc_url( home_url( '/wp-admin' ) ) );
$admin											= __( 'Admin', 'minisite-lite' );
$terms_of_use									= __( 'Terms of Use', 'minisite-lite' );
$close											= __( 'Close', 'minisite-lite' );
$footer_block_colophon_terms_of_use				= wpautop( get_theme_mod( 'footer_block_colophon_terms_of_use', '' ) );
$display_footer_block_colophon_privacy_policy	= get_theme_mod( 'display_footer_block_colophon_privacy_policy' , true );
$privacy_policy									= __( 'Privacy Policy', 'minisite-lite' );
$footer_block_colophon_privacy_policy			= wpautop( get_theme_mod( 'footer_block_colophon_privacy_policy', '' ) );
$credits										= __( 'Credits', 'minisite-lite' );
$footer_block_colophon_credits					= wpautop( get_theme_mod( 'footer_block_colophon_credits', sprintf( __( '<h3>Technical</h3><ul><li>Proudly powered by %1$s.</li><li>%2$s WordPress theme by %3$s, based on %4$s starter theme for WordPress.</li><li>Built with %5$s front-end framework.</li></ul><br><h3>Typography</h3><ul><li>%6$s by %7$s</li></ul><br><h3>Icons</h3><ul><li>%8$s</li><ul>', 'minisite-lite' ), '<a href="https://wordpress.org/" target="_blank">WordPress</a>', '<a href="http://www.getminisites.com/" target="_blank">Minisite</a>', '<a href="https://www.troytempleman.com/" target="_blank">Troy Templeman</a>', '<a href="https://underscores.me/" target="_blank">Underscores</a>', '<a href="https://getbootstrap.com/" target="_blank">Bootstrap</a>', '<a href="https://github.com/chrismsimpson/Metropolis/" target="_blank">Metropolis</a>', '<a href="https://github.com/chrismsimpson/" target="_blank">Chris Simpson</a>', '<a href="https://fontawesome.com/" target="_blank">Font Awesome</a>' ) ) );
?>
</div>
	<?php if ( $display_footer ) : ?>
		<?php if ( class_exists( 'Footer_Section' ) ) : ?>
			<?php Footer_Section::footer_section(); ?>
		<?php else: ?>
			<footer id="footer" class="site-footer wrapper" role="contentinfo">
				<div class="container">
					<?php if ( is_active_sidebar( 'footer' ) ) : ?>	
						<div class="footer-widgets row">		
							<?php dynamic_sidebar( 'footer' ); ?>
						</div>
					<?php endif; ?>
					<?php if ( $display_footer_separator ) : ?>
						<hr class="footer-separator">
					<?php endif; ?>
					<?php if ( $display_footer_block_colophon_copyright || $display_footer_block_colophon_terms_of_use || $display_footer_block_colophon_credits ) : ?>
						<div class="footer-footer row">
							<div class="footer-block-colophon footer-block col-md">
								<h3 class="footer-block-colophon-title screen-reader-text">
									<?php echo $colophon ?>
								</h3>
								<ul class="footer-block-colophon-text list-unstyled">
									<?php if ( $display_footer_block_colophon_copyright ) : ?>
										<li class="footer-block-colophon-copyright">
											<?php echo $copyright_year . date( 'Y' ) ?><?php if ( $display_footer_block_colophon_copyright_owner ) : ?><?php echo ' ' ?><?php if ( $display_footer_block_colophon_copyright_link ) : ?><a class="footer-block-colophon-copyright-link" href="<?php echo $footer_block_colophon_copyright_link ?>"><?php endif; ?><?php echo $footer_block_colophon_copyright_owner ?><?php if ( $display_footer_block_colophon_copyright_link ) : ?></a><?php endif; ?><?php endif; ?><?php echo '. ' . $all_rights_reserved ?>
										</li>
									<?php endif; ?>	
									<?php if ( $display_footer_block_colophon_admin ) : ?>
										<li class="footer-block-colophon-admin list-inline-item">
											<a class="footer-block-colophon-admin-link" href="<?php echo $footer_block_colophon_admin_link ?>"><?php echo $admin ?></a>
										</li>
									<?php endif; ?>	
									<?php if ( $display_footer_block_colophon_terms_of_use ) : ?>
										<li class="footer-block-colophon-terms-of-use list-inline-item">
											<a href="#" data-toggle="modal" data-target="#terms-of-use"><?php echo $terms_of_use ?></a>
											<div class="modal fade" id="terms-of-use" tabindex="-1" role="dialog" aria-labelledby="terms-of-use-label" aria-hidden="true">
												<div class="modal-dialog modal-lg" role="document">
											    	<div class="modal-content">
											      		<div class="modal-header">
															<h2 class="modal-title" id="terms-of-use-label"><?php echo $terms_of_use ?></h2>
												        	<button type="button" class="close" data-dismiss="modal" aria-label="<?php echo $close ?>">
												          		<span aria-hidden="true">&times;</span>
												        	</button>
											      		</div>
											      		<div class="modal-body">
											        		<?php echo $footer_block_colophon_terms_of_use	 ?>
											      		</div>
											      		<div class="modal-footer">
															<a href="#" class="btn btn-primary" data-dismiss="modal" role="button"><?php echo $close ?></a>
											      		</div>
											    	</div>
												</div>
											</div>
										</li>
									<?php endif; ?>
									<?php if ( $display_footer_block_colophon_privacy_policy ) : ?>
										<li class="footer-block-colophon-privacy-policy list-inline-item">
											<a href="#" data-toggle="modal" data-target="#privacy-policy"><?php echo $privacy_policy ?></a>
											<div class="modal fade" id="privacy-policy" tabindex="-1" role="dialog" aria-labelledby="privacy-policy-label" aria-hidden="true">
												<div class="modal-dialog modal-lg" role="document">
											    	<div class="modal-content">
											      		<div class="modal-header">
															<h2 class="modal-title" id="privacy-policy-label"><?php echo $privacy_policy ?></h2>
												        	<button type="button" class="close" data-dismiss="modal" aria-label="<?php echo $close ?>">
												          		<span aria-hidden="true">&times;</span>
												        	</button>
											      		</div>
											      		<div class="modal-body">
											        		<?php echo $footer_block_colophon_privacy_policy ?>
											      		</div>
											      		<div class="modal-footer">
															<a href="#" class="btn btn-primary" data-dismiss="modal" role="button"><?php echo $close ?></a>
											      		</div>
											    	</div>
												</div>
											</div>
										</li>
									<?php endif; ?>
									<?php if ( $display_footer_block_colophon_credits ) : ?>
										<li class="footer-block-colophon-credits list-inline-item">
											<a href="#" data-toggle="modal" data-target="#credits"><?php echo $credits ?></a>
											<div class="modal fade" id="credits" tabindex="-1" role="dialog" aria-labelledby="credits-label" aria-hidden="true">
												<div class="modal-dialog" role="document">
											    	<div class="modal-content">
											      		<div class="modal-header">
															<h2 class="modal-title" id="credits-label"><?php echo $credits ?></h2>
												        	<button type="button" class="close" data-dismiss="modal" aria-label="<?php echo $close ?>">
												          		<span aria-hidden="true">&times;</span>
												        	</button>
											      		</div>
											      		<div class="modal-body">
											        		<?php echo $footer_block_colophon_credits ?>
											      		</div>
											      		<div class="modal-footer">
															<a href="#" class="btn btn-primary" data-dismiss="modal" role="button"><?php echo $close ?></a>
											      		</div>
											    	</div>
												</div>
											</div>
										</li>
									<?php endif; ?>
								</ul>
							</div>
						</div>
					<?php endif; ?>
				</div>
			</footer>
		<?php endif; ?>
	<?php endif; ?>
</div>
<?php wp_footer(); ?>
</body>
</html>