<?php

$this->theme->view('includes/header');

$this->theme->view('components/tools');

$this->load->view('core/header_ad_spot');

?>

<div class="mainPadding result-content">

    <div class="result-content-inner">
        <div class="result-main-title clearfix">
            <div class="left-title-area plus"><span class="recent-search-icon"><svg xmlns="http://www.w3.org/2000/svg" width="22.119" height="22.119" viewBox="0 0 22.119 22.119"><g id="clock-outline-badged" transform="translate(-1.881 -1)"><path id="Path_2213" data-name="Path 2213" d="M18.256,10.418a.668.668,0,1,0-1.336,0v5.824l3.94,2.671A.668.668,0,1,0,21.6,17.8L18.262,15.54Z" transform="translate(-4.995 -2.906)" fill="#231f20"/><path id="Path_2214" data-name="Path 2214" d="M22.744,9.218a4.969,4.969,0,0,1-1.276.387,9.383,9.383,0,1,1-5.744-5.744,4.969,4.969,0,0,1,.387-1.276,10.726,10.726,0,1,0,6.632,6.632Z" transform="translate(0 -0.331)" fill="#231f20"/><path id="Path_2215" data-name="Path 2215" d="M14.168,6.38a7.72,7.72,0,0,0-1.516,15.287l.18-1.049A6.679,6.679,0,1,1,17.768,8.531a4.975,4.975,0,0,1-.521-1.489A7.647,7.647,0,0,0,14.168,6.38Z" transform="translate(-1.522 -1.787)" fill="#231f20"/><path id="Path_2216" data-name="Path 2216" d="M31.679,4.339A3.339,3.339,0,1,1,28.339,1,3.339,3.339,0,0,1,31.679,4.339Z" transform="translate(-7.679)" fill="#231f20"/></g></svg></span><?php echo lang('recent_searches') ?></div>
        </div>
        
        <?php if(count($data['recent'])) { ?>
            <div class="domainDnsSection">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="extension-area">
                            <ul class="tlds_result">
                                <?php for($i = 0; $i < count($data['recent']); $i++) { if($i % 2 == 0) { $search = $data['recent'][$i]; ?>
                                    <li>
                                        <a target="_blank" href="<?php echo base_url('whois/' . $search['domain']) ?>" class="right-by-wo-btn red-by-btn<?php echo(!$this->options->get('enable-whois-button') ? " d-none" : ""); ?>" target="_blank"><span><?php echo lang('whois_button') ?></span></a>
                                        <div id="keyword_com" class="left-extension wd-icon"><div class="icon"><img src="https://www.google.com/s2/favicons?sz=32&domain_url=<?php echo $search['domain'] ?>" alt="<?php echo $search['domain'] ?>"></div><?php echo $search['domain'] ?></div>
                                        <div class="clearfix"></div>
                                    </li>
                                <?php } } ?>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="extension-area">
                            <ul class="tlds_result">
                                <?php for($i = 0; $i < count($data['recent']); $i++) { if($i % 2 == 1) { $search = $data['recent'][$i]; ?>
                                    <li>
                                        <a target="_blank" href="<?php echo base_url('whois/' . $search['domain']) ?>" class="right-by-wo-btn red-by-btn<?php echo(!$this->options->get('enable-whois-button') ? " d-none" : ""); ?>" target="_blank"><span><?php echo lang('whois_button') ?></span></a>
                                        <div id="keyword_com" class="left-extension wd-icon"><div class="icon"><img src="https://www.google.com/s2/favicons?sz=32&domain_url=<?php echo $search['domain'] ?>" alt="<?php echo $search['domain'] ?>"></div><?php echo $search['domain'] ?></div>
                                        <div class="clearfix"></div>
                                    </li>
                                <?php } } ?>
                            </ul>
                        </div>
                    </div>
                </div>

                <?php $base = base_url('whois/recent?page='); ?>

                <?php if($data['pages'] > 1) { ?>
                    <ul class="whoispageination">
                        <li>
                            <?php if($page > 1) { ?>
                                <li><a href="<?php echo $base . ($page - 1) ?>">&laquo;</a></li>
                            <?php } else { ?>
                                <li><a class="disabled" href="<?php echo $base . ($page - 1) ?>">&laquo;</a></li>
                            <?php } ?>
                        </li>

                        <?php if($page > 2) { ?>
                            <li><a href="<?php echo $base . '1' ?>">1</a></li>
                            <li><a href="#" class="disabled">...</a></li>
                        <?php } ?>

                        <?php if($page > 1) { ?>
                            <li><a href="<?php echo $base . ($page - 1) ?>"><?php echo $page - 1 ?></a></li>
                        <?php } ?>
                            <li><a href="<?php echo $base . $page ?>" class="active"><?php echo $page ?></a></li>
                        <?php if($page < $data['pages']) { ?>
                            <li><a href="<?php echo $base . ($page + 1) ?>"><?php echo $page + 1 ?></a></li>
                        <?php } ?>

                        <?php if(!($page + 1 >= $data['pages'])) { ?>
                            <li><a href="#" class="disabled">...</a></li>
                            <li><a href="<?php echo $base . $data['pages'] ?>"><?php echo $data['pages'] ?></a></li>
                        <?php } ?>

                        <li>
                            <?php if($page < $data['pages']) { ?>
                                <li><a href="<?php echo $base . ($page + 1) ?>">&raquo;</a></li>
                            <?php } else { ?>
                                <li><a class="disabled" href="#">&raquo;</a></li>
                            <?php } ?>
                        </li>
                    </ul>
                <?php } ?>
            </div>
        <?php } else { ?>
            <div class="domainDnsSection">
                <p class="text-dark"><?php echo lang('no_searches'); ?></p>
            </div>
        <?php } ?>
    </div>
</div>

<?php 

$this->theme->view('components/recent_features');
$this->load->view('core/middle_ad_spot');
$this->theme->view('components/recent_faq');
$this->theme->view('includes/footer');