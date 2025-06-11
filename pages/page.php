<?php $this->theme->view('includes/header'); ?>

<?php $this->load->view('core/header_ad_spot'); ?>

<div class="mainPadding homepageFaqsAreaMain">
    <div class="homepageFaqsArea">
        <h1 class="faq-main-title"><?php echo $page['title'] ?></h1>
        <div class="homeFaqsRow">
            <?php echo $page['body']; ?>
        </div>
    </div>
</div>

<?php $this->theme->view('includes/footer'); ?>