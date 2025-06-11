<?php $this->theme->view('includes/header'); ?>

<?php $this->load->view('core/header_ad_spot'); ?>

<div class="mainPadding homepageFaqsAreaMain pt-0">
    <div class="homepageFaqsArea">
        <div class="text-center">
            <img src="<?php echo $this->theme->url('assets/images/four-o-four-image.png') ?>" class="img-responsivee" alt="<?php echo lang('error_alt_notfound'); ?>">
        </div>
        <div class="d-flex justify-content-center pt-4">
            <a class="btn contactButton mb-3" href="<?php echo base_url() ?>"><div class="blockGrad"></div><span><?php echo lang('error_home'); ?></span></a>
        </div>
    </div>
</div>

<?php $this->theme->view('includes/footer'); ?>