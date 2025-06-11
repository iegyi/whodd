<?php $this->theme->view('includes/header'); ?>
<?php $this->load->view('core/header_ad_spot'); ?>

<div class="mainPadding blogColumn-section">
	<h1 class="blog-title"><?php echo($title); ?></h1>
	<div class="row">
		<?php
		if(count($posts)) {
			foreach($posts as $post) { ?>
				<div class="col-lg-4 col-md-6">
					<div class="blogColumnsMain">
						<a href="<?php echo base_url("/blog/post/".$post->permalink); ?>"><div class="homepageColumnsImage" style="background-image: url(<?php echo base_url("/uploads/default/blog/".$post->post_image); ?>);"></div></a>
						<h2><a href="<?php echo base_url("/blog/post/".$post->permalink); ?>"><?php echo($post->title); ?></a></h2>
						<div class="date-sec"><?php echo lang('blog_published'); ?>: <a href="<?php echo base_url("/blog/post/".$post->permalink); ?>"><?php echo(format_date($post->date_published)); ?></a></div>
						<p><?php echo($post->post_description); ?></p>
					</div>
				</div>
		<?php }
		} else { ?>
				<div class="col-12">
					<div class="result-content-inner">
						<div class="extension-area">
							<div class="domainDnsSection">
								<div class="homeFaqsRow text-center pt-5 pb-5 mt-5 mb-5">
									<h4><?php echo lang('blog_no_posts'); ?></h4>
								</div>
							</div>
						</div>
					</div>
				</div>
		<?php } ?>
	</div>
	<div class="d-flex align-items-center justify-content-center">
		<p><?php echo $links; ?></p>
	</div>
</div>

<?php $this->theme->view('includes/footer'); ?>