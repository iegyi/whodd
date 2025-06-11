<?php
$this->theme->view('includes/header');
$this->theme->view('components/tools'); 
?>
<section x-data="window.bitflan.components.whois_component()" x-init="init('<?php echo isset($domain) ? $domain : '' ?>', <?php echo alpinify($js_errors) ?>, `<?php echo isset($data) && $data['type'] == 'error' ? $data['message'] : ''; ?>`)" @keyup.enter="submit()">
    <div class="searchSection mainPadding">
        <div class="searchInput">
            <input x-model="domain" type="text" placeholder="<?php echo lang('enter_domain_name') ?>" x-bind:class="error && 'border border-danger'" class="inputFiled form-control">
            <div x-show="domain.length" x-on:click="domain = ''" x-cloak class="searchCross">
                <svg xmlns="http://www.w3.org/2000/svg" width="30.047" height="30.047" viewBox="0 0 30.047 30.047"><path d="M19.349,8.726H12.9a.379.379,0,0,1-.379-.379V1.9a1.9,1.9,0,0,0-3.794,0v6.45a.379.379,0,0,1-.379.379H1.9a1.9,1.9,0,0,0,0,3.794h6.45a.379.379,0,0,1,.379.379v6.45a1.9,1.9,0,0,0,3.794,0V12.9a.379.379,0,0,1,.379-.379h6.45a1.9,1.9,0,0,0,0-3.794Zm0,0" transform="translate(15.023) rotate(45)" fill="#b8b8b8"/></svg></div>
        </div>
        <button x-on:click="submit()" class="btn searchButton" type="submit" value="submit">
            <div class="blockGrad"></div>
            <span x-show="!sending"><?php echo lang('get_whois') ?></span>
            <span x-cloak x-show="sending"><img src="<?php echo $this->theme->url('assets/images/search_loader.svg') ?>" alt="<?php echo lang('whois_search_loader') ?>" title="<?php echo lang('whois_search_loader') ?>"/></span>
        </button>
    </div>

    <?php if(isset($data) && $this->options->get('whois-tld-related') && isset($data['suggestions']) && count($data['suggestions'])) { $exp = explode('.', $domain); $domain_keyword = $exp[0]; ?>
        <div class="domain-options mainPadding">
            <div class="domain-options-inner-main">
                <ul class="domain-options-inner clearfix" id="teleporter">
                <?php foreach($data['suggestions'] as $suggestion) { if($suggestion['tld'] != '.' . $exp[1]) { ?>
                    <li>
                        <a target="_blank" x-data="{ status: 'blank' }" :href="status == 'available' && <?php echo($this->options->get('enable-buy-button') ? "1" : "0"); ?> ? `<?php echo base_url('register/' . $domain_keyword .$suggestion['tld']) ?>` : `<?php echo base_url('whois/' . $domain_keyword .$suggestion['tld']) ?>`">
                            <div style="cursor: pointer;" x-init="get_bool('<?php echo $domain_keyword . $suggestion['tld'] ?>', (status_ajax) => status = status_ajax)" class="domain-ckbx" :class="{ 'bg-success text-white': status == 'available', 'bg-danger text-white': status == 'unavailable' }">
                                <strong>
                                    <template x-if="status == 'blank'">
                                        <svg class="mr-1" xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12">
                                            <path id="Path_3877" data-name="Path 3877" d="M6,2a4,4,0,1,0,4,4A4,4,0,0,0,6,2M6,0A6,6,0,1,1,0,6,6,6,0,0,1,6,0Z" fill="#b9b9b9"/>
                                        </svg>
                                    </template>

                                    <template x-if="status == 'available'">
                                        <svg class="mr-1" xmlns="http://www.w3.org/2000/svg" width="13" height="9.752" viewBox="0 0 13 9.752">
                                            <path id="Path_3874" data-name="Path 3874" d="M14.39,18.136l-3.251-3.25L9.514,16.511l4.876,4.876,8.124-8.126-1.623-1.626Z" transform="translate(-9.514 -11.635)" fill="#fff"/>
                                        </svg>
                                    </template>

                                    <template x-if="status == 'unavailable'">
                                        <svg class="mr-1" xmlns="http://www.w3.org/2000/svg" width="10.608" height="11.021" viewBox="0 0 10.608 11.021">
                                            <path id="Path_3875" data-name="Path 3875" d="M0,0H2V13H0Z" transform="translate(0 1.828) rotate(-45)" fill="#fff"/>
                                            <path id="Path_3876" data-name="Path 3876" d="M0,0H2V13H0Z" transform="translate(1.415 10.607) rotate(-135)" fill="#fff"/>
                                        </svg>
                                    </template>
                                    <?php echo $domain_keyword . $suggestion['tld'] ?>
                                </strong>
                            </div>
                        </a>
                    </li>
                <?php } } ?>
                </ul>
            </div>
        </div>
    <?php } ?>

    <div x-cloak x-show="error_message.length" class="mt-3 mainPadding" x-transition >
        <div class="alert alert-danger" x-text="error_message"></div>
    </div>

    <?php $this->load->view('core/header_ad_spot'); ?>

    <?php if(isset($data) && $data['type'] == 'success') { ?>
        <div class="scrollIntoView"></div>
        <div class="mainPadding result-content">
            <div class="row">
                <div class="col-lg-<?php echo($this->options->get('recent-status') ? '8' : '12'); ?>">
                    <div class="result-content-inner">
                        <div class="result-main-title clearfix">
                            <div class="left-title-area plus d-flex justify-content-between">
                                <span><?php echo lang('whois_info') ?></span>
                                <span>
                                    <img src="https://www.google.com/s2/favicons?sz=32&domain_url=<?php echo $domain; ?>" />
                                </span>
                            </div>
                        </div>
                        <div class="extension-area">
                            <div class="domainDnsSection">
                                <div class="whoisText"><?php echo $data['message'] ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            if($this->options->get('recent-status')) { ?>
                <div class="col-lg-4">
                    <div class="result-content-inner">
                        <div class="result-main-title clearfix">
                            <div class="left-title-area plus"><span class="recent-search-icon"><svg xmlns="http://www.w3.org/2000/svg" width="22.119" height="22.119" viewBox="0 0 22.119 22.119"><g id="clock-outline-badged" transform="translate(-1.881 -1)"><path id="Path_2213" data-name="Path 2213" d="M18.256,10.418a.668.668,0,1,0-1.336,0v5.824l3.94,2.671A.668.668,0,1,0,21.6,17.8L18.262,15.54Z" transform="translate(-4.995 -2.906)" fill="#231f20"/><path id="Path_2214" data-name="Path 2214" d="M22.744,9.218a4.969,4.969,0,0,1-1.276.387,9.383,9.383,0,1,1-5.744-5.744,4.969,4.969,0,0,1,.387-1.276,10.726,10.726,0,1,0,6.632,6.632Z" transform="translate(0 -0.331)" fill="#231f20"/><path id="Path_2215" data-name="Path 2215" d="M14.168,6.38a7.72,7.72,0,0,0-1.516,15.287l.18-1.049A6.679,6.679,0,1,1,17.768,8.531a4.975,4.975,0,0,1-.521-1.489A7.647,7.647,0,0,0,14.168,6.38Z" transform="translate(-1.522 -1.787)" fill="#231f20"/><path id="Path_2216" data-name="Path 2216" d="M31.679,4.339A3.339,3.339,0,1,1,28.339,1,3.339,3.339,0,0,1,31.679,4.339Z" transform="translate(-7.679)" fill="#231f20"/></g></svg></span><?php echo lang('recent_searches') ?></div>
                        </div>
                        <div class="extension-area">
                            <div class="domainDnsSection">
                                <div class="recent-sidebar-searches">
                                    <?php foreach($recent as $search) { ?>
                                        <a href="<?php echo ($this->options->get('enable-whois-button') ? base_url('whois/' . $search['domain']) : ""); ?>" onclick="<?php echo (!$this->options->get('enable-whois-button') ? "return false" : ""); ?>" target="<?php echo ($this->options->get('enable-whois-button') ? "_blank" : ""); ?>">
                                            <img class="mr-2" width="22" height="22" src="https://www.google.com/s2/favicons?sz=32&domain_url=<?php echo $search['domain'] ?>" alt="">
                                            <?php echo $search['domain'] ?>
                                        </a>
                                    <?php } ?>
                                </div>
                                <a href="<?php echo base_url('whois/recent') ?>" class="btn recent-search-btn"><div class="blockGrad"></div><span><?php echo lang('view_more') ?></span></a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            </div>
        </div>
    <?php } ?>

    <?php if(isset($data) && $data['type'] == 'available') { ?>
        <div class="mainPadding resultAvailorNotMain">
            <div class="resultAvailorNot availabel">
                <div class="leftSec">
                    <h2><?php echo lang('prompt_available') ?></h2>
                    <h3>
                        <span><?php echo $domain ?></span>
                        <span class="buy-price<?php echo(!$this->options->get('tld-price-status') ? " d-none" : ""); ?>">/ <?php echo $data['price'] ?></span>
                        <a href="<?php echo $data['link'] ?>" class="buy-now main-buy-now<?php echo(!$this->options->get('enable-buy-button') ? " d-none" : ""); ?>"><span><?php echo lang('buy_button') ?></span></a>
                    </h3>
                </div>
                <div class="availMan"></div>
            </div>
        </div>
    <?php } ?>
<section>

<?php
$this->theme->view('components/whois_features');
$this->load->view('core/middle_ad_spot');
$this->theme->view('components/whois_faq');
$this->theme->view('includes/footer');