/**
*
* Plugin Name: Focus by Phpbits
* Plugin URI: https://phpbits.net/plugin/focus/
*
*/

// Utility
if ( typeof Object.create !== 'function' ) {
	Object.create = function( obj ) {
		function F() {};
		F.prototype = obj;
		return new F();
	};
}

(function( $, window, document, undefined ) {

	var constructFocus = {
		init: function( i, opts, elem) {
			var self 	= this;

			self.elem 	= elem;
			self.$elem 	= $( elem );

			self.opts 	= $.extend( {}, $.fn.focuswp.opts, opts );

			//override opts from slide data
			if( self.$elem .attr( 'data-autoplay' ) == 'true' ){
				self.opts.auto  = true;
			}

			if( self.$elem .attr( 'data-pager' ) == 'true' ){
				self.opts.pager  = true;
			}

			// self.opts.pager  = true;

			self.opts.speed 	= self.$elem .attr( 'data-speed' );
			self.opts.timeout 	= self.$elem .attr( 'data-timeout' );


			//declare helpers
			self.rotate 	= '';
			self.SlidesID 	= self.opts.namespace + i;
			self.index 		= 0;
			self.slide 		= self.$elem.children();
			self.length 	= self.slide.size();
	        self.transTime 	= parseFloat( self.opts.speed );
	        self.waitTime 	= parseFloat( self.opts.timeout );
	        self.maxw 		= parseFloat( self.opts.maxwidth );

	        // define classes
	        self.nav 		= self.opts.namespace + '_nav ' + self.SlidesID + '_nav',
	        self.active 	= self.opts.namespace + '_here',
	        self.elVisible 	= self.SlidesID + '_on',
	        self.prefix 	= self.SlidesID + '_s',

	        //navigation container
	        self.navEl 		= $('<div class="'+ self.opts.namespace +'_tabs '+ self.SlidesID +'_tabs"></div>');
	        self.pager 		= $('<ul class="'+ self.opts.namespace +'_pager '+ self.SlidesID +'_pager"></ul>');

	        //state
	        self.visible 	= { 'float': 'left', 'position': 'relative', 'opacity': 1, 'z-index': 2 };
        	self.hidden 	= { 'float': 'none', 'position': 'absolute', 'opacity': 0, 'z-index': 1 };

        	$.when( self.display( i ) ).done( function(){
				//loaded
				self.opts.loaded();
			} );
        	self.buildClick();
        	self.doResize();
        	self.touchFn();
		},
		display: function( idx ){
			var self = this;

			//add container class
			self.$elem.addClass( self.opts.namespace + ' ' + self.SlidesID );

			//add max width if defined
			if( typeof self.opts.maxwidth != 'undefined' && self.opts.maxwidth ){
				self.$elem.css({ 'max-width' : self.opts.maxwidth });
			}

			//add slide ID's
			self.slide.each( function(i){
				this.id = self.prefix + i;
			} );

			//show only first slide
			self.slide.hide().css( self.hidden )
			.eq(0).addClass( self.elVisible ).css( self.visible ).show();

			//now add transition if supported
			if( self.supportsTransitions() ){
				self.slide.show()
		          .css({
		            // -ms prefix isn't needed as IE10 uses prefix free version
		            '-webkit-transition': 'opacity ' + self.transTime + 'ms ease-in-out',
		            '-moz-transition'	: 'opacity ' + self.transTime + 'ms ease-in-out',
		            '-o-transition'		: 'opacity ' + self.transTime + 'ms ease-in-out',
		            'transition'		: 'opacity ' + self.transTime + 'ms ease-in-out'
		          });
			}

			// Only run if there's more than one slide
      		if ( self.slide.size() > 1 ) {
      			// Make sure the timeout is at least 100ms longer than the fade
		        if ( self.waitTime < self.transTime + 100 ) {
		        	return;
		        }

				// Pager
		        if ( self.opts.pager && !self.opts.manualControls) {
		          var tabMarkup = [];
		          self.slide.each(function (i) {
		            var n = i + 1;
		            tabMarkup +=
		              "<li>" +
		              "<a href='#' class='" + self.prefix + n + "'></a>" +
		              "</li>";
		          });
		          self.pager.append(tabMarkup);

		          // Inject pager
		          if ( self.opts.navContainer ) {
		            $( self.opts.navContainer ).append( self.pager );
		          } else {
		            self.$elem.after( self.pager );
		          }
		        }

		        // Navigation
        		if ( self.opts.nav ) {
        			var navMarkup =
		            '<a href="#" class="'+ self.nav +' fcsprev">'+ self.opts.prevText +'</a>'+
		            '<a href="#" class="'+ self.nav +' fcsnext">'+ self.opts.nextText +'</a>';

		            self.navEl.append( navMarkup );
		            self.$elem.after( self.navEl );

		            var $trigger = $( '.' + self.SlidesID + '_nav'),
            		$prev = $trigger.filter( '.fcsprev' );

            		// Click event handler
					$trigger.bind( 'click', function (e) {
						e.preventDefault();

						var $VisibleEl = $( '.' + self.elVisible );

						// Prevent clicking if currently animated
			            if ( $VisibleEl.queue('fx').length ) {
			            	return;
			            }

			            // Determine where to slide
			            var idx = self.slide.index( self.elVisible ),
			              prevIdx = self.index == 0 ? self.length - 1 : self.index - 1,
			              nextIdx = self.index + 1 < self.length ? self.index + 1 : 0;

			            // Go to slide
						self.slideTo( $(this)[0] === $prev[0] ? prevIdx : nextIdx );

						if ( self.opts.pager || self.opts.manualControls) {
			              self.selectTab( $(this)[0] === $prev[0] ? prevIdx : nextIdx );
			            }

						if ( !self.opts.pauseControls) {
			              self.restartCycle();
			            }

						e.stopPropagation();
					});
        		}
      		}else{
      			//hide navigation button if only one slide
      			if( self.opts.prevBtn ){
      				self.$elem.find( self.opts.prevBtn ).css({ 'visibility' : 'hidden' });
      			}
      			if( self.opts.nextBtn ){
      				self.$elem.find( self.opts.nextBtn ).css({ 'visibility' : 'hidden' });
      			}
      		}

      		//autoplay
      		self.startCycle();

			//pager
			self.pagerClick();

      		//width fallback
      		self.buildWidth();

			//fix navigation for smaller width
			self.fixNav();
		},
		slideTo: function( idx ){
			var self = this;
			self.opts.before( idx );
			// If CSS3 transitions are supported
			if( self.supportsTransitions() ){
				self.slide
	              .removeClass( self.elVisible )
	              .css( self.hidden )
	              .eq(idx)
	              .addClass( self.elVisible )
	              .css( self.visible );
	            self.index = idx;
	            setTimeout(function () {
	              self.opts.after( idx );
	            }, self.transTime);
			}
		},
		selectTab: function( idx ){
			var self = this;
			self.pager.find('a').closest('li').removeClass( self.active ).eq(idx).addClass( self.active );
		},
		pagerClick: function(){
			var self = this;
			var tab  = self.pager.find('a');

			// Pager click event handler
	        if ( self.opts.pager || self.opts.manualControls ) {
	          tab.bind( 'click', function (e) {
	            e.preventDefault();

	            if ( !self.opts.pauseControls ) {
	              self.restartCycle();
	            }

	            // Get index of clicked tab
	            var idx = tab.index(this);

	            // Break if element is already active or currently animated
	            if ( self.index === idx || $( '.' + self.elVisible ).queue('fx').length ) {
	              return;
	            }

	            // Remove active state from old tab and set new one
	            self.selectTab(idx);

	            // Do the animation
	            self.slideTo(idx);

				clearInterval( self.rotate );
	          })
	            .eq(0)
	            .closest("li")
	            .addClass( self.active );

	          // Pause when hovering pager
	          if ( self.opts.pauseControls ) {
	            self.pager.find('li').hover(function () {
	              clearInterval( self.rotate );
	            }, function () {
	            //   self.restartCycle();
	            });
	          }
	        }
		},
		startCycle: function(){
			var self = this;
			if( self.opts.auto ){
				self.rotate = setInterval(function () {

	              // Clear the event queue
	              self.slide.stop(true, true);

	              var idx = self.index + 1 < self.length ? self.index + 1 : 0;

	              // Remove active state and set new if pager is set
	              if ( self.opts.pager || self.opts.manualControls ) {
	                self.selectTab(idx);
	              }

	              self.slideTo(idx);
			  }, self.waitTime );
		  	}
			if( self.opts.pause && typeof self.rotate != 'undefined' ){
      			self.$elem.on( 'hover', function(){
      				clearInterval( self.rotate );
      			});
      		}
	  	},
		restartCycle: function(){
			var self = this;
			if ( self.opts.auto ) {
	            // Stop
	            clearInterval( self.rotate );
	            // Restart
	            self.startCycle();
	          }
		},
		buildClick: function(){
			var self = this;
			if( self.opts.prevBtn ){
				self.$elem.find( self.opts.prevBtn ).on('click', function(e){
					self.navEl.find('.fcsprev').click();
					e.preventDefault();
					e.stopImmediatePropagation();
					return false;
				});
			}
			if( self.opts.nextBtn ){
				self.$elem.find( self.opts.nextBtn ).on('click', function(e){
					self.navEl.find('.fcsnext').click();
					e.preventDefault();
					e.stopImmediatePropagation();
					return false;
				});
			}
		},
		supportsTransitions: function(){
			var docBody = document.body || document.documentElement;
			var styles 	= docBody.style;
			var prop 	= 'transition';
			if ( typeof styles[prop] === 'string' ) {
				return true;
			}
			// Tests for vendor specific prop
			vendor = ["Moz", "Webkit", "Khtml", "O", "ms"];
			prop = prop.charAt(0).toUpperCase() + prop.substr(1);
			var i;
			for (i = 0; i < vendor.length; i++) {
				if (typeof styles[vendor[i] + prop] === "string") {
				  	return true;
				}
			}
			return false;
		},
		buildWidth: function(){
			var self = this;
			if ( typeof document.body.style.maxWidth === 'undefined' && self.opts.maxwidth ){
				self.$elem.css( width , '100%' );
				w = parseFloat( self.opts.maxwidth );
				if ( self.$elem.width() > w ) {
					self.$elem.css( width , w );
				}
			}
		},
		doResize: function(){
			var self = this;
			$(window).bind( 'resize', function() {
				self.buildWidth();
				// self.fixNav();
			});
		},
		fixNav: function(){
			var self = this;
			var th = self.$elem.find('.focuswp-headleft span').innerHeight();
			if( th > 80 ){
				self.$elem.find('.focuswp-head').addClass('focuswp-headright-vertical');
			}else{
				self.$elem.find('.focuswp-head button').css({ 'height' : th });
				self.$elem.find('.focuswp-head').removeClass('focuswp-headright-vertical');
			}
		},
		touchFn: function(selector) {
			var self = this;
		    if ( self.is_touch_device() ) {
		        var scrollStartPosY = 0;
		        var scrollStartPosX = 0;
		        self.slide.find( self.opts.content + ', .focuswp-bg, .focuswp-top-img'  ).delegate(selector, 'touchstart', function(e) {
		            scrollStartPosY = this.scrollTop+e.originalEvent.touches[0].pageY;
		            scrollStartPosX = this.scrollLeft+e.originalEvent.touches[0].pageX;
		        });
		        self.slide.find( self.opts.content + ', .focuswp-bg, .focuswp-top-img'  ).on( 'touchmove', selector , function(e) {


		        });
				self.slide.find( self.opts.content + ', .focuswp-bg, .focuswp-top-img' ).on( 'touchend', selector , function(e) {
					var x 	= e.originalEvent.changedTouches[0].pageX;
					var end = Math.abs(scrollStartPosX - x);
					if( scrollStartPosX > x ){
						self.navEl.find('.fcsprev').click();
						clearInterval( self.rotate );
					}else if( scrollStartPosX < x ){
						self.navEl.find('.fcsnext').click();
						clearInterval( self.rotate );
					}
					// console.log( end );
					// console.log( e.originalEvent.changedTouches[0].pageX);
				});
		    }
		},
		is_touch_device: function() {
		  return !!('ontouchstart' in window);
		}
	};

	$.fn.focuswp = function( opts ) {
		var i = 0;
		return this.each(function() {
			// Index for namespacing
      		i++;
			var focuswp = Object.create( constructFocus );
			focuswp.init( i, opts, this );
			$.data( this, 'focuswp', focuswp );
		});
	};

	$.fn.focuswp.opts = {
		'auto'			: false,
		'speed'			: 500,
		'timeout'		: 4000,
		'nav'			: true,
		'pager'			: false,
		'random'		: false,
		'pause'			: true,
		'pauseControls'	: true,
		'maxwidth'		: '',
		'prevBtn'		: '',
		'nextBtn'		: '',
		'prevText'		: '<',
		'nextText'		: '>',
		'navContainer' 	: '',
		'manualControls': '',
		'namespace'		: 'focusSlides',
		'content'		: '',
		'before'		: $.noop,
		'after'			: $.noop,
		'loaded'		: $.noop
	};

	$( '.focuswp-slides' ).focuswp({
		'prevBtn'		: '.focuswp-arrow.fsprev',
		'nextBtn'		: '.focuswp-arrow.fsnext',
		'content'		: '.focuswp-content',
		'loaded' 		: function(){
			$('.focuswp-slider').css({ 'visibility' : 'visible' });
			$('span.focuswp').parent('p').remove();
		}
	});

})( jQuery, window, document );
