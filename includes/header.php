<!DOCTYPE html>
<html>
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no" />
	<title><?php echo isset($title) ? $title : $this->options->get('website-title') ?></title>
	<?php if(isset($description)) { ?>
<meta name="description" content="<?php echo $description ?>">
	<meta property="og:description" content="<?php echo $description ?>">
	<?php } if(isset($keywords)) { ?>
	<meta name="keywords" content="<?php echo $keywords ?>">
	<?php } ?>
	<meta name="author" content="<?php echo(lang('website_author_name')); ?>">
	<meta name="publisher" content="<?php echo(lang('website_author_name')); ?>">
<link rel="icon" href="<?php echo base_url( $this->options->get('favicon') ) ?>" />
	<link rel="stylesheet" href="<?php echo $this->theme->url('assets/css/bootstrap.min.css'); ?>">
	<link rel="stylesheet" href="<?php echo $this->theme->url('assets/css/all.min.css'); ?>">
	<link rel="stylesheet" href="<?php echo $this->theme->url('assets/css/style.css'); ?>">
	<link rel="stylesheet" href="<?php echo $this->theme->url('assets/css/additional.css'); ?>">
	<link rel="canonical" href="<?php echo($canonical); ?>" />
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i" rel="stylesheet">
	<?php if(isset($resolver)) { ?>
	<script>
		window.resolver = {
			url: '<?php echo($resolver['api_url']); ?>',
			mode: '<?php echo($resolver['mode']); ?>',
			param: '<?php echo($resolver['param']); ?>',
		};
	</script> 
	<?php }
		$this->load->view('core/header_content');
	?>
	</head>
<body class="<?php echo(get_mode() == 'dark' && $this->options->get('color-mode-status') ? 'theme-dark' : ''); ?>">
	<div class="mainSection">
		<header class="mainPadding">
				<nav x-data="{ showMenu: false }" class="p-0 navbar navbar-expand-lg navbar-dark">
					<a class="navbar-brand" href="<?php echo base_url(); ?>" title="<?php echo isset($title) ? $title : $this->options->get('website-title') ?>"><img src="<?php echo base_url( $this->options->get('logo') ) ?>" class="img-responsivee" alt="<?php echo isset($title) ? $title : $this->options->get('website-title') ?>" title="<?php echo isset($title) ? $title : $this->options->get('website-title') ?>"></a>
					
					<button x-on:click="showMenu = !showMenu" class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>
					<div class="collapse navbar-collapse navbarMob" x-bind:class="{ 'show': showMenu }" id="navbarNav">
						<ul class="navbar-nav headerNavigation">
							<li class="nav-item">
								<a class="nav-link" href="<?php echo base_url() ?>" title="<?php echo lang('home_page_name') ?>"><?php echo lang('home_page_name') ?></a>
							</li>

							<?php
								if(count($pages)) {
									foreach($pages as $page) { if($page['status'] && in_array($page['placement'], [ 'both', 'header' ])) { ?>
										<li class="nav-item">
											<a class="nav-link" href="<?php echo base_url('page/' . $page['permalink']) ?>" title="<?php echo $page['title'] ?>"><?php echo $page['title'] ?>
										</li>
									<?php } }
								}
							?>

							<?php if(count($this->options->get('hf-links'))) { ?>
								<?php
									foreach($this->options->get('hf-links') as $page) { if(in_array($page['placement'], [ 'both', 'header' ])) { ?>
										<li class="nav-item">
											<a class="nav-link" <?php echo_if('target="_blank"', $page['new-tab']) ?> href="<?php echo $page['href'] ?>" title="<?php echo $page['title'] ?>"><?php echo $page['title'] ?></a>
										</li>
									<?php } }
								?>
							<?php } ?>

							<?php 
							$blog_status = $this->options->get('blog-page-status');
							if($this->options->get('blog-status') && $blog_status && ($blog_status == 'header' || $blog_status == 'both')) { ?>
								<li class="nav-item">
									<a class="nav-link" href="<?php echo base_url('blog'); ?>" title="<?php echo lang('blog_page_name') ?>"><?php echo lang('blog_page_name') ?></a>
								</li>
							<?php } ?>

							<?php
							$page_status = $this->options->get('recent-page-status');
							if( $this->options->get('recent-status') && $this->options->get('whois-status') && $page_status && ($page_status == 'header' || $page_status == 'both')) { ?>
								<li class="nav-item">
									<a class="nav-link" href="<?php echo base_url('whois/recent') ?>" title="<?php echo lang('recent_page_name') ?>"><?php echo lang('recent_page_name') ?></a>
								</li>
							<?php } ?>

							<?php if( $this->options->get('contact-page-status') ) { ?>
								<li class="nav-item">
									<a class="nav-link" href="<?php echo base_url('contact') ?>" title="<?php echo lang('contact_page_name') ?>"><?php echo lang('contact_page_name') ?></a>
								</li>
							<?php } ?>

							<?php if($this->CurrencyModel->api && $this->options->get('enable-currency-selection')) { ?>
								<li class="nav-item">
									<select @change="let req = new vjaxClass(); req.get( { url: window.bitflan_baseUrl + 'currency', data: { symbol: $el.value }, onResponse: function(data) { if(data.text == 'error') { alert('There was an error setting your currency.'); } } } );" x-data id="currency" name="currency" class="form-control header-select">
										<?php
											$data = $this->CurrencyModel->get();
											$selected = $this->CurrencyModel->currency;
											foreach ($data as $symbol => $meta) { if($meta['enabled'] || $meta['default']) { ?>
												<option <?php if($symbol == $selected) { echo 'selected'; } ?> value="<?php echo $symbol ?>"><?php echo $symbol ?></option>
											<?php } }
										?>
									</select>
								</li>
							<?php } ?>
						</ul>
					</div>
					<?php if($this->options->get('color-mode-status')) { ?>
					<label class="mb-0 ml-lg-3">
						<input id="toggle_mode" @change="window.location.replace('<?php echo(base_url("set-mode?redirect_url=" . urlencode(get_current_page_url()))); ?>')" class='toggle-checkbox' type='checkbox'<?php echo(get_mode() == 'dark' ? ' checked' : ''); ?>></input>
						<div class='toggle-slot'>
							<div class='sun-icon-wrapper'>
								<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path fill-rule="evenodd" clip-rule="evenodd" d="M10.8333 0.833333C10.8333 0.373096 10.4602 0 10 0C9.53976 0 9.16667 0.373096 9.16667 0.833333V2.5C9.16667 2.96024 9.53976 3.33333 10 3.33333C10.4602 3.33333 10.8333 2.96024 10.8333 2.5V0.833333ZM4.10592 2.92741C3.78048 2.60197 3.25285 2.60197 2.92741 2.92741C2.60197 3.25285 2.60197 3.78048 2.92741 4.10592L4.11074 5.28926C4.43618 5.61469 4.96382 5.61469 5.28926 5.28926C5.61469 4.96382 5.61469 4.43618 5.28926 4.11074L4.10592 2.92741ZM17.0726 4.10592C17.398 3.78048 17.398 3.25285 17.0726 2.92741C16.7472 2.60197 16.2195 2.60197 15.8941 2.92741L14.7107 4.11074C14.3853 4.43618 14.3853 4.96382 14.7107 5.28926C15.0362 5.61469 15.5638 5.61469 15.8893 5.28926L17.0726 4.10592ZM0.833333 9.16667C0.373096 9.16667 0 9.53976 0 10C0 10.4602 0.373096 10.8333 0.833333 10.8333H2.5C2.96024 10.8333 3.33333 10.4602 3.33333 10C3.33333 9.53976 2.96024 9.16667 2.5 9.16667H0.833333ZM17.5 9.16667C17.0398 9.16667 16.6667 9.53976 16.6667 10C16.6667 10.4602 17.0398 10.8333 17.5 10.8333H19.1667C19.6269 10.8333 20 10.4602 20 10C20 9.53976 19.6269 9.16667 19.1667 9.16667H17.5ZM5.28926 15.8893C5.61469 15.5638 5.61469 15.0362 5.28926 14.7107C4.96382 14.3853 4.43618 14.3853 4.11074 14.7107L2.92741 15.8941C2.60197 16.2195 2.60197 16.7472 2.92741 17.0726C3.25285 17.398 3.78048 17.398 4.10592 17.0726L5.28926 15.8893ZM15.8893 14.7107C15.5638 14.3853 15.0362 14.3853 14.7107 14.7107C14.3853 15.0362 14.3853 15.5638 14.7107 15.8893L15.8941 17.0726C16.2195 17.398 16.7472 17.398 17.0726 17.0726C17.398 16.7472 17.398 16.2195 17.0726 15.8941L15.8893 14.7107ZM10.8333 17.5C10.8333 17.0398 10.4602 16.6667 10 16.6667C9.53976 16.6667 9.16667 17.0398 9.16667 17.5V19.1667C9.16667 19.6269 9.53976 20 10 20C10.4602 20 10.8333 19.6269 10.8333 19.1667V17.5ZM6.66667 10C6.66667 8.15905 8.15905 6.66667 10 6.66667C11.8409 6.66667 13.3333 8.15905 13.3333 10C13.3333 11.8409 11.8409 13.3333 10 13.3333C8.15905 13.3333 6.66667 11.8409 6.66667 10ZM10 5C7.23858 5 5 7.23858 5 10C5 12.7614 7.23858 15 10 15C12.7614 15 15 12.7614 15 10C15 7.23858 12.7614 5 10 5Z" fill="#FDB23E"></path>
									</svg>
							</div>
							<div class='toggle-button'></div>
							<div class='moon-icon-wrapper'>
								<svg width="18" height="18" fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 19">
									<path fill-rule="evenodd" clip-rule="evenodd" d="M9.05597 0.459013C9.23048 0.768648 9.20682 1.15191 8.99555 1.43773C8.22528 2.47981 7.85463 3.76374 7.95099 5.05601C8.04736 6.34827 8.60435 7.56303 9.52066 8.47934C10.437 9.39565 11.6517 9.95264 12.944 10.049C14.2363 10.1454 15.5202 9.77472 16.5623 9.00445C16.8481 8.79318 17.2314 8.76952 17.541 8.94403C17.8506 9.11853 18.0289 9.45864 17.9962 9.81256C17.8386 11.518 17.1985 13.1433 16.1509 14.4983C15.1033 15.8533 13.6914 16.8818 12.0806 17.4637C10.4697 18.0456 8.72645 18.1566 7.05478 17.7839C5.38311 17.4111 3.85216 16.57 2.64108 15.3589C1.43 14.1478 0.588879 12.6169 0.216135 10.9452C-0.156608 9.27355 -0.0455555 7.53029 0.536299 5.91943C1.11815 4.30857 2.14674 2.89673 3.50171 1.84912C4.85668 0.801503 6.48198 0.161447 8.18744 0.00384108C8.54136 -0.0288652 8.88147 0.149378 9.05597 0.459013ZM6.56291 2.19937C5.86172 2.45307 5.2006 2.81521 4.60481 3.27585C3.52084 4.11394 2.69796 5.24341 2.23248 6.5321C1.767 7.82079 1.67816 9.2154 1.97635 10.5527C2.27455 11.8901 2.94744 13.1148 3.91631 14.0837C4.88517 15.0526 6.10993 15.7255 7.44727 16.0236C8.7846 16.3218 10.1792 16.233 11.4679 15.7675C12.7566 15.302 13.8861 14.4792 14.7241 13.3952C15.1848 12.7994 15.5469 12.1383 15.8006 11.4371C14.851 11.7807 13.8324 11.9237 12.8099 11.8475C11.0869 11.719 9.46718 10.9763 8.24543 9.75457C7.02369 8.53282 6.28104 6.91315 6.15255 5.19012C6.07629 4.1676 6.21934 3.14899 6.56291 2.19937Z" fill="#ffffff"></path>
									</svg>
							</div>
						</div>
					</label>
					<?php } ?>
				</nav>
		</header>