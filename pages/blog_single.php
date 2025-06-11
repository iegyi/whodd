<?php $this->theme->view('includes/header'); ?>
<?php $this->load->view('core/header_ad_spot'); ?>

	<div class="mainPadding result-content">
		<div class="row">
			<div class="col-12">
				<div class="result-content-inner">
					<div class="result-main-title enlarge clearfix">
						<h1 class="left-title-area plus mb-0 enlarge">
						<?php echo($post['title']); ?>
							<div class="date-sec"><?php echo lang('blog_published'); ?>: <a><?php echo(format_date($post['date_published'])); ?></a></div>
						</h1>
					</div>
					<div class="extension-area">
						<div class="domainDnsSection">
							<div class="blog-single-image"><img src="<?php echo base_url("/uploads/default/blog/".$post['post_image']); ?>" alt="<?php echo($post['post_image']); ?>" class="img-responsivee rounded mx-auto d-block"></div>
							<div class="homeFaqsRow">
								<p><?php echo($post['body']); ?></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

<?php $this->theme->view('includes/footer'); ?>