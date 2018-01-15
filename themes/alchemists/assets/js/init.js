/**
	* @package Alchemists HTML
	*
	* Template Scripts
	* Created by Dan Fisher
*/

;(function($){
	"use strict";

	$(window).on('load', function() {
		$('#js-preloader').delay(0).fadeOut();
		$('#js-preloader-overlay').delay(200).fadeOut('slow');
	});

	$.fn.exists = function () {
		return this.length > 0;
	};

	/* ----------------------------------------------------------- */
	/*  Predefined Variables
	/* ----------------------------------------------------------- */
	var $color_primary = '#ffdc11',
			$main_nav     = $('.main-nav'),
			$circular_bar = $('.circular__bar'),
			$mp_single    = $('.mp_single-img'),
			$mp_gallery   = $('.mp_gallery'),
			$mp_iframe    = $('.mp_iframe'),
			$post_fitRows = $('.post-grid--fitRows'),
			$post_masonry = $('.post-grid--masonry'),
			$post_masonry_filter = $('.post-grid--masonry-filter'),
			$team_album   = $('.album'),
			$slick_awards = $('.awards--slider'),
			$slick_player_info = $('.player-info'),
			$slick_product = $('.product__slider'),
			$slick_product_soccer = $('.product__slider-soccer'),
			$slick_team_roster_case = $('.team-roster--case-slider'),
			$slick_hero_slider_football = $('.posts--slider-top-news'),
			$slick_slider_var_width = $('.posts--slider-var-width'),
			$chart_points_history_football = $('#points-history-football'),
			$content_filter = $('.content-filter'),
			$marquee = $('.marquee');

	if ( $('body').hasClass('template-soccer') ) {
		var $template_var = 'template-soccer';
	} else if ( $('body').hasClass('template-football') ) {
		var $template_var = 'template-football';
	} else {
		var $template_var = 'template-basketball';
	}

	if ( $template_var === 'template-soccer' ) {
		$color_primary = '#1892ed';
	} else if ( $template_var === 'template-football' ) {
		$color_primary = '#f92552';
	}

	var Core = {

		initialize: function() {

			this.SvgPolyfill();

			this.headerNav();

			this.circularBar();

			this.MagnificPopup();

			this.isotope();

			this.SlickCarousel();

			this.ContentFilter();

			this.ChartJs();

			this.miscScripts();

		},

		SvgPolyfill: function() {
			svg4everybody();
		},

		headerNav: function() {

			if ( $main_nav.exists() ) {

				var $top_nav     = $('.nav-account'),
						$top_nav_li  = $('.nav-account > li'),
						$social      = $('.social-links--main-nav'),
						$info_nav_li = $('.info-block--header > li'),
						$wrapper     = $('.site-wrapper'),
						$nav_list    = $('.main-nav__list'),
						$nav_list_li = $('.main-nav__list > li'),
						$toggle_btn  = $('#header-mobile__toggle'),
						$pushy_btn   = $('.pushy-panel__toggle');

				// Clone Search Form
				var $header_search_form = $('.header-search-form').clone();
				$('#header-mobile').append($header_search_form);

				// Clone Shopping Cart to Mobile Menu
				var $shop_cart = $('.info-block__item--shopping-cart > .info-block__link-wrapper').clone();
				$shop_cart.appendTo($nav_list).wrap('<li class="main-nav__item--shopping-cart"></li>');

				// Add arrow and class if Top Bar menu ite has submenu
				$top_nav_li.has('.main-nav__sub-0').addClass('has-children');
				$top_nav_li.has('.main-nav__sub-0').prepend('<span class="main-nav__toggle"></span>');

				// Clone Top Bar menu to Main Menu
				if ( $top_nav.exists() ) {
					var children = $top_nav.children().clone();
					$nav_list.append(children);
				}

				// Clone Header Logo to Mobile Menu
				var $logo_mobile = $('.header-mobile__logo').clone();
				$nav_list.prepend($logo_mobile);
				$logo_mobile.prepend('<span class="main-nav__back"></span>');

				// Clone Header Info to Mobile Menu
				var header_info1 = $('.info-block__item--contact-primary').clone();
				var header_info2 = $('.info-block__item--contact-secondary').clone();
				$nav_list.append(header_info1).append(header_info2);

				// Clone Social Links to Main Menu
				if ( $social.exists() ) {
					var social_li = $social.children().clone();
					var social_li_new = social_li.contents().unwrap();
					social_li_new.appendTo($nav_list).wrapAll('<li class="main-nav__item--social-links"></li>');
				}

				// Add arrow and class if Info Header Nav has submenu
				$info_nav_li.has('ul').addClass('has-children');

				// Mobile Menu Toggle
				$toggle_btn.on('click', function(){
					$wrapper.toggleClass('site-wrapper--has-overlay');
				});

				$('.site-overlay, .main-nav__back').on('click', function(){
					$wrapper.toggleClass('site-wrapper--has-overlay');
				});

				// Pushy Panel Toggle
				$pushy_btn.on('click', function(e){
					e.preventDefault();
					$wrapper.toggleClass('site-wrapper--has-overlay-pushy');
				});

				$('.site-overlay, .pushy-panel__back-btn').on('click', function(e){
					e.preventDefault();
					$wrapper.removeClass('site-wrapper--has-overlay-pushy site-wrapper--has-overlay');
				});

				// Add toggle button and class if menu has submenu
				$nav_list_li.has('.main-nav__sub-0').prepend('<span class="main-nav__toggle"></span>');
				$nav_list_li.has('.main-nav__megamenu').prepend('<span class="main-nav__toggle"></span>');

				$('.main-nav__toggle').on('click', function(){
					$(this).toggleClass('main-nav__toggle--rotate')
					.parent().siblings().children().removeClass('main-nav__toggle--rotate');

					$(".main-nav__sub-0, .main-nav__megamenu").not($(this).siblings('.main-nav__sub-0, .main-nav__megamenu')).slideUp('normal');
					$(this).siblings('.main-nav__sub-0').slideToggle('normal');
					$(this).siblings('.main-nav__megamenu').slideToggle('normal');
				});

				// Add toggle button and class if submenu has sub-submenu
				$('.main-nav__list > li > ul > li').has('.main-nav__sub-1').prepend('<span class="main-nav__toggle-2"></span>');
				$('.main-nav__list > li > ul > li > ul > li').has('.main-nav__sub-2').prepend('<span class="main-nav__toggle-2"></span>');

				$('.main-nav__toggle-2').on('click', function(){
					$(this).toggleClass('main-nav__toggle--rotate');
					$(this).siblings('.main-nav__sub-1').slideToggle('normal');
					$(this).siblings('.main-nav__sub-2').slideToggle('normal');
				});

				// Mobile Search
				$('#header-mobile__search-icon').on('click', function(){
					$(this).toggleClass('header-mobile__search-icon--close');
					$('.header-mobile').toggleClass('header-mobile--expanded');
				});
			}
		},

		circularBar: function() {

			var $track_color = '#ecf0f6';

			if ( $template_var === 'template-football' ) {
				$track_color = '#4e4d73';
			}

			if ( $circular_bar.exists() ) {
				$circular_bar.easyPieChart({
					barColor: $color_primary,
					trackColor: $track_color,
					lineCap: 'square',
					lineWidth: 8,
					size: 90,
					scaleLength: 0
				});
			}

		},

		MagnificPopup: function(){

			if ($mp_single.exists() ) {
				// Single Image
				$('.mp_single-img').magnificPopup({
					type:'image',
					removalDelay: 300,

					gallery:{
						enabled:false
					},
					mainClass: 'mfp-fade',
					autoFocusLast: false,

				});
			}

			if ($mp_gallery.exists() ) {
				// Multiple Images (gallery)
				$('.mp_gallery').magnificPopup({
					type:'image',
					removalDelay: 300,

					gallery:{
						enabled:true
					},
					mainClass: 'mfp-fade',
					autoFocusLast: false,

				});
			}

			if ($mp_iframe.exists() ) {
				// Iframe (video, maps)
				$('.mp_iframe').magnificPopup({
					type:'iframe',
					removalDelay: 300,
					mainClass: 'mfp-fade',
					autoFocusLast: false,

					patterns: {
						youtube: {
							index: 'youtube.com/', // String that detects type of video (in this case YouTube). Simply via url.indexOf(index).

							id: 'v=', // String that splits URL in a two parts, second part should be %id%
							// Or null - full URL will be returned
							// Or a function that should return %id%, for example:
							// id: function(url) { return 'parsed id'; }

							src: '//www.youtube.com/embed/%id%?autoplay=1' // URL that will be set as a source for iframe.
						},
						vimeo: {
							index: 'vimeo.com/',
							id: '/',
							src: '//player.vimeo.com/video/%id%?autoplay=1'
						},
						gmaps: {
							index: '//maps.google.',
							src: '%id%&output=embed'
						}
					},

					srcAction: 'iframe_src', // Templating object key. First part defines CSS selector, second attribute. "iframe_src" means: find "iframe" and set attribute "src".

				});
			}
		},


		isotope: function() {

			if ( $post_fitRows.exists() ) {
				var $grid = $post_fitRows.imagesLoaded( function() {
					// init Isotope after all images have loaded
					$grid.isotope({
						itemSelector: '.post-grid__item',
						layoutMode: 'fitRows',
						masonry: {
							columnWidth: '.post-grid__item'
						}
					});
				});
			}

			if ( $post_masonry.exists() ) {
				var $masonry = $post_masonry.imagesLoaded( function() {
					// init Isotope after all images have loaded
					$masonry.isotope({
						itemSelector: '.post-grid__item',
						layoutMode: 'masonry',
						percentPosition: true,
						masonry: {
							columnWidth: '.post-grid__item'
						}
					});
				});
			}

			if ( $team_album.exists() ) {
				var $masonry_album = $team_album.imagesLoaded( function() {
					// init Isotope after all images have loaded
					$masonry_album.isotope({
						itemSelector: '.album__item',
						layoutMode: 'masonry',
						percentPosition: true,
						masonry: {
							columnWidth: '.album__item'
						}
					});
				});
			}


			if ( $post_masonry_filter.exists() ) {
				var $masonry_grid = $post_masonry_filter.imagesLoaded( function() {

					var $filter = $('.js-category-filter');

					// init Isotope after all images have loaded
					$masonry_grid.isotope({
						filter      : '*',
						itemSelector: '.post-grid__item',
						layoutMode: 'masonry',
						masonry: {
							columnWidth: '.post-grid__item'
						}
					});

					// filter items on button click
					$filter.on( 'click', 'button', function() {
						var filterValue = $(this).attr('data-filter');
						$filter.find('button').removeClass('category-filter__link--active');
						$(this).addClass('category-filter__link--active');
						$masonry_grid.isotope({
							filter: filterValue
						});
					});
				});
			}

		},


		SlickCarousel: function() {

			// Awards Carousel
			if ( $slick_awards.exists() ) {

				if ( $template_var === 'template-football' ) {

					// Filter by Categories
					var filtered = false;

					$('.awards-filter .awards-filter__link').on('click', function(e){
						var category = $(this).data('category');
						$slick_awards.slick('slickUnfilter');
						$slick_awards.slick('slickFilter', '.' + category);
						$('.awards-filter .awards-filter__link--active').removeClass('awards-filter__link--active');
						$(this).addClass('awards-filter__link--active');
						e.preventDefault();
					});

					// Reset Filter (Show All posts)
					$('.awards-filter .awards-filter__link--reset').on('click', function(e){
						$slick_awards.slick('slickUnfilter');
						$('.awards-filter .awards-filter__link').removeClass('awards-filter__link--active');
						$(this).addClass('awards-filter__link--active');
						filtered = false;
						e.preventDefault();
					});


					// Awards Slider
					$slick_awards.slick({
						slidesToShow: 1,
						arrows: false,
						dots: true,
						vertical: true,
						verticalSwiping: true,
					});


				} else {

					$slick_awards.slick({
						slidesToShow: 1,
						arrows: true,
						dots: true,
						responsive: [
							{
								breakpoint: 768,
								settings: {
									arrows: false
								}
							}
						]
					});
				}

			}


			// Player Info
			if ( $slick_player_info.exists() ) {

				$(window).on('load', function() {
					$slick_player_info.slick({
						slidesToShow: 3,
						arrows: false,
						dots: false,
						infinite: false,
						variableWidth: true,
						responsive: [
							{
								breakpoint: 992,
								settings: {
									slidesToShow: 1,
									dots: true,
									variableWidth: false
								}
							}
						]
					});
				});
			}


			// Products Slider
			if ( $slick_product.exists() ) {

				$slick_product.slick({
					slidesToShow: 1,
					arrows: false,
					dots: true,
				});
			}


			// Products Slider - Thumbs
			if ( $slick_product_soccer.exists() ) {

				$slick_product_soccer.slick({
					slidesToShow: 1,
					slidesToScroll: 1,
					arrows: false,
					asNavFor: '.product__slider-thumbs'
				});
				$('.product__slider-thumbs').slick({
					slidesToShow: 3,
					slidesToScroll: 1,
					asNavFor: $slick_product_soccer,
					focusOnSelect: true,
					vertical: true,
				});
			}


			// Team Roster - Case Slider
			if ( $slick_team_roster_case.exists() ) {

				$slick_team_roster_case.slick({
					slidesToShow: 3,
					autoplay: true,
					autoplaySpeed: 3000,
					arrows: true,
					dots: false,
					responsive: [
						{
							breakpoint: 768,
							settings: {
								arrows: false,
								slidesToShow: 2
							}
						},
						{
							breakpoint: 480,
							settings: {
								arrows: false,
								slidesToShow: 1
							}
						}
					]
				});
			}


			// Hero Slider - Football
			if ( $slick_hero_slider_football.exists() ) {

				$slick_hero_slider_football.slick({
					slidesToShow: 1,
					slidesToScroll: 1,
					arrows: false,
					fade: true,
					dots: true,
					autoplay: true,
					autoplaySpeed: 8000,
					adaptiveHeight: true,
				});
			}


			// Featured News Slider - variable width
			if ( $slick_slider_var_width.exists() ) {

				$slick_slider_var_width.slick({
					slidesToShow: 1,
					slidesToScroll: 1,
					autoplay: false,
					autoplaySpeed: 5000,
					adaptiveHeight: true,
					responsive: [
						{
							breakpoint: 768,
							settings: {
								arrows: false
							}
						}
					]
				});
			}

		},


		ContentFilter: function() {

			if ( $content_filter.exists() ) {
				$('.content-filter__toggle').on('click', function(e){
					e.preventDefault();
					$(this).toggleClass('content-filter__toggle--active');
					$('.content-filter__list').toggleClass('content-filter__list--expanded');
				});
			}

		},


		ChartJs: function() {

			if ( $chart_points_history_football.exists() ) {
				var data = {
					type: 'line',
					data: {
						labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
						datasets: [{
							label: '2016',
							fill: false,
							lineTension: 0,
							borderWidth: 4,
							backgroundColor: "#3ffeca",
							borderColor: "#3ffeca",
							borderCapStyle: 'butt',
							borderDashOffset: 0.0,
							borderJoinStyle: 'bevel',
							pointRadius: 5,
							pointBorderWidth: 5,
							pointBackgroundColor: "#fff",
							pointHoverRadius: 5,
							pointHoverBackgroundColor: "#fff",
							pointHoverBorderColor: "#3ffeca",
							pointHoverBorderWidth: 5,
							pointHitRadius: 10,
							data: [115, 145, 110, 125, 165, 140, 145, 110, 145, 125, 135, 190],
							spanGaps: false,
						}, {
							label: '2015',
							fill: false,
							lineTension: 0,
							borderWidth: 4,
							backgroundColor: "#9e69ee",
							borderColor: "#9e69ee",
							borderCapStyle: 'butt',
							borderDashOffset: 0.0,
							borderJoinStyle: 'bevel',
							pointRadius: 5,
							pointBorderWidth: 5,
							pointBackgroundColor: "#fff",
							pointHoverRadius: 5,
							pointHoverBackgroundColor: "#fff",
							pointHoverBorderColor: "#9e69ee",
							pointHoverBorderWidth: 5,
							pointHitRadius: 10,
							data: [95, 65, 130, 75, 113, 85, 102, 85, 103, 58, 48, 138],
							spanGaps: false,
						}]
					},
					options: {
						legend: {
							display: false,
							labels: {
								boxWidth: 8,
								fontSize: 9,
								fontColor: '#31404b',
								fontFamily: 'Montserrat, sans-serif',
								padding: 20,
							}
						},
						tooltips: {
							backgroundColor: "rgba(50,49,80,0.8)",
							titleFontSize: 0,
							titleSpacing: 0,
							titleMarginBottom: 0,
							bodyFontFamily: 'Montserrat, sans-serif',
							bodyFontSize: 9,
							bodySpacing: 0,
							cornerRadius: 2,
							xPadding: 10,
							displayColors: false,
						},
						scales: {
							xAxes: [{
								gridLines: {
									color: "#3c3b5b",
								},
								ticks: {
									fontColor: '#9e9caa',
									fontFamily: 'Montserrat, sans-serif',
									fontSize: 10,
								},
							}],
							yAxes: [{
								gridLines: {
									color: "#3c3b5b",
								},
								ticks: {
									beginAtZero: true,
									fontColor: '#9e9caa',
									fontFamily: 'Montserrat, sans-serif',
									fontSize: 10,
									padding: 20
								}
							}]
						}
					},
				};

				var ctx = $chart_points_history_football;
				var gamesHistory = new Chart(ctx, data);

				document.getElementById('gamesPoinstsLegendFootball').innerHTML = gamesHistory.generateLegend();
			}

		},


		miscScripts: function() {
			// Tooltips
			$('[data-toggle="tooltip"]').tooltip();

			[].slice.call( document.querySelectorAll( 'select.cs-select' ) ).forEach( function(el) {
				new SelectFx(el);
			} );

			// Duotone Images
			if ( $template_var == 'template-football' ) {
				if ( $(".duotone-img").exists() ) {
					$(".duotone-img").duotone();
				}
			}

			// Marquee
			if ( $marquee.exists() ) {
				$marquee.marquee({
					allowCss3Support: true
				});
			}

			// Switch Toggle
			$('.widget-game-result .switch-toggle').on('change', function(){

				var text_expand = $('.switch__label-txt').data('text-expand');
				var text_shrink = $('.switch__label-txt').data('text-shrink');

				$('.widget-game-result__extra-stats').toggleClass('active');
				$(this).prev('.switch__label-txt').text(function(i, text){
					return text === text_shrink ? text_expand : text_shrink;
				});
			});

			// Add theme class to select element for Categories and Archives widgets
			$('.widget_categories .postform, .widget_archive select[name="archive-dropdown"]').addClass('form-control');

			// Highlight the last name on Single Player page
			if ($(".player-info__name > span").length > 0) {
				$(".player-info__name").find("span").addClass('player-info__last-name');
			} else {
				$(".player-info__name").html(function () {
					var text = $(this).text().trim().split(" ");
					var last = text.pop();
					return text.join(" ") + (text.length > 0 ? " <span class='player-info__last-name'>" + last + "</span>" : last);
				});
			}

			// Highlight the last name on Single Player page
			$('.team-roster__member-name').each(function(){
				if ($(this).find("span").length > 0) {
					$(this).find("span").addClass('team-roster__member-last-name');
				} else {
					$(this).html(function () {
						var text = $(this).text().trim().split(" ");
						var last = text.pop();
						return text.join(" ") + (text.length > 0 ? " <span class='team-roster__member-last-name'>" + last + "</span>" : last);
					});
				}
			});

			// Highlight the last name for Featured Player Widget
			$(".widget-player__name").each(function () {
				if ($(this).find("span").length > 0) {
					$(this).find("span").addClass("widget-player__last-name");
				} else {
					$(this).html(function () {
						var text = $(this).text().trim().split(" ");
						var last = text.pop();
						return text.join(" ") + (text.length > 0 ? " <span class='widget-player__last-name'>" + last + "</span>" : last);
					});
				}
			});

			// Highlight the last name on Roster Carousel
			$('.team-roster__player-name').each(function () {
				if ($(this).find("span").length > 0) {
					$(this).find("span").addClass('team-roster__player-last-name');
				} else {
					$(this).html(function () {
						var text = $(this).text().trim().split(" ");
						var last = text.pop();
						return text.join(" ") + (text.length > 0 ? " <span class='team-roster__player-last-name'>" + last + "</span>" : last);
					});
				}
			});

			// Highlight the last name of Staff member
			$('.alc-staff__header-name').each(function () {
				if ($(this).find("span").length > 0) {
					$(this).find("span").addClass('alc-staff__header-last-name');
				} else {
					$(this).html(function () {
						var text = $(this).text().trim().split(" ");
						var last = text.pop();
						return text.join(" ") + (text.length > 0 ? " <span class='alc-staff__header-last-name'>" + last + "</span>" : last);
					});
				}
			});


			// Disable scroll on Google Map (Sportspress)
			$('.sp-template-event-venue').click(function(){
				$(this).find('iframe').addClass('clicked')
			}).mouseleave(function(){
				$(this).find('iframe').removeClass('clicked')
			});

			$('[data-toggle="tooltip"]').on('click', function () {
				$(this).blur();
			})

		},

	};

	$(document).on('ready', function() {
		Core.initialize();
	});

})(jQuery);
