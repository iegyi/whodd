		<?php $this->load->view('core/footer_ad_spot'); ?>
		
		<footer>
			<div class="footer-inner">
				<div class="mainPadding">
					<div class="navigationSection">
						<div class="row">
							<div class="col-lg-8">
								<div class="row">
									<div class="col-lg-4">
										<h5 class="footer-nav-title"><?php echo lang('tools_heading') ?></h5>
										<ul>
											<?php if($this->options->get('search-status')) { ?>
												<li><a href="<?php echo base_url() ?>" title="<?php echo $this->options->get('seo-search-title') ?>"><?php echo $this->options->get('seo-search-title') ?></a></li>
											<?php } ?>

											<?php if($this->options->get('generator-status')) { ?>
												<li><a href="<?php echo base_url('domain-generator') ?>" title="<?php echo $this->options->get('seo-generator-title') ?>"><?php echo $this->options->get('seo-generator-title') ?></a></li>
											<?php } ?>

											<?php if($this->options->get('whois-status')) { ?>
												<li><a href="<?php echo base_url('whois') ?>" title="<?php echo $this->options->get('seo-whois-title') ?>"><?php echo $this->options->get('seo-whois-title') ?></a></li>
											<?php } ?>
											
											<?php if($this->options->get('ip-status')) { ?>
												<li><a href="<?php echo base_url('ip-lookup') ?>" title="<?php echo $this->options->get('seo-ip-title') ?>"><?php echo $this->options->get('seo-ip-title') ?></a></li>
											<?php } ?>
											
											<?php if($this->options->get('location-status')) { ?>
												<li><a href="<?php echo base_url('location') ?>" title="<?php echo $this->options->get('seo-location-title') ?>"><?php echo $this->options->get('seo-location-title') ?></a></li>
											<?php } ?>

											<?php if($this->options->get('dns-status')) { ?>
												<li><a href="<?php echo base_url('dns-lookup') ?>" title="<?php echo $this->options->get('seo-dns-title') ?>"><?php echo $this->options->get('seo-dns-title') ?></a></li>
											<?php } ?>

											<?php if($this->options->get('blocklist-status')) { ?>
												<li><a href="<?php echo base_url('blocklist-lookup') ?>" title="<?php echo $this->options->get('seo-blocklist-title') ?>"><?php echo $this->options->get('seo-blocklist-title') ?></a></li>
											<?php } ?>

											<?php if($this->options->get('open-ports-status')) { ?>
												<li><a href="<?php echo base_url('open-ports-lookup') ?>" title="<?php echo $this->options->get('seo-open-ports-title') ?>"><?php echo $this->options->get('seo-open-ports-title') ?></a></li>
											<?php } ?>
										</ul>
									</div>
									<div class="col-lg-4">
										<h5 class="footer-nav-title"><?php echo lang('pages_heading') ?></h5>
										<ul>
											<li><a href="<?php echo base_url() ?>" title="<?php echo lang('home_page_name') ?>"><?php echo lang('home_page_name') ?></a></li>
											<?php
												if(count($pages)) {
													foreach($pages as $page) { if($page['status'] && in_array($page['placement'], [ 'both', 'footer' ])) { ?>
														<li><a href="<?php echo base_url('page/' . $page['permalink']) ?>" title="<?php echo $page['title'] ?>"><?php echo $page['title'] ?></a></li>
													<?php } }
												}
											?>

											
											<?php 
											$blog_status = $this->options->get('blog-page-status');
											if($this->options->get('blog-status') && $blog_status && ($blog_status == 'footer' || $blog_status == 'both')) { ?>
												<li><a href="<?php echo base_url('blog'); ?>" title="<?php echo lang('blog_page_name') ?>"><?php echo lang('blog_page_name') ?></a></li>
											<?php } ?>
											
											<?php
											$page_status = $this->options->get('recent-page-status');
											if( $this->options->get('whois-status') && $this->options->get('recent-status') && $page_status && ($page_status == 'footer' || $page_status == 'both') ) { ?>
												<li><a href="<?php echo base_url('whois/recent') ?>" title="<?php echo lang('recent_page_name') ?>"><?php echo lang('recent_page_name') ?></a></li>
											<?php } ?>

											<?php if( $this->options->get('contact-page-status') ) { ?>
												<li><a href="<?php echo base_url('contact') ?>" title="<?php echo lang('contact_page_name') ?>"><?php echo lang('contact_page_name') ?></a></li>
											<?php } ?>
										</ul>
									</div>

									<?php if(count($this->options->get('hf-links'))) {
										ob_start();
										foreach($this->options->get('hf-links') as $page) { if(in_array($page['placement'], [ 'both', 'footer' ])) { ?>
											<li><a <?php echo_if('target="_blank"', $page['new-tab']) ?> href="<?php echo $page['href'] ?>" title="<?php echo $page['title'] ?>"><?php echo $page['title'] ?></a></li>
										<?php } }

										$text = ob_get_clean();

										if($text) { ?>
											<div class="col-lg-4">
												<h5 class="footer-nav-title"><?php echo lang('links_heading') ?></h5>
												<ul>
													<?php echo $text ?>
												</ul>
											</div>
										<?php } } ?>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="footerLogo"><a href="<?php echo base_url() ?>" title="<?php echo isset($title) ? $title : $this->options->get('website-title') ?>"><img class="img-responsivee" src="<?php echo base_url( $this->options->get('logo') ) ?>" alt="<?php echo isset($title) ? $title : $this->options->get('website-title') ?>" title="<?php echo isset($title) ? $title : $this->options->get('website-title') ?>"></a></div>
								<div class="footerCopyright">
                                    <?php echo $this->options->get('footer-attribution') ?>
                                </div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</footer>
		
	</div>
	<script src="<?php echo $this->theme->url('assets/js/vjax.min.js'); ?>"></script>
	<script src="<?php echo $this->theme->url('assets/js/alpine.min.js'); ?>" defer></script>
    <?php $this->load->view('core/footer_content'); ?>
	<div id="cb-cookie-banner" class="alert alert-dark text-center mb-0" role="alert">
	🍪 This website uses cookies to ensure you get the best experience on our website.
	<a href="https://www.kaspersky.com/resource-center/definitions/cookies" target="blank" title="Learn more about cookies">Learn more</a>
	<button type="button" class="btn btn-primary btn-sm ms-3" onclick="window.cb_hideCookieBanner()">Okay</button>
	</div>
	<script src="<?php echo $this->theme->url("assets/js/cookie.js"); ?>"></script>
</body>
</html>