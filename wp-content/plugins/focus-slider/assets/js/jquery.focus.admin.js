(function( $, window, document, undefined ) {
	if( $('.focuswp-widget--tabs').length > 0 ){
		focuswp_opts_init( '', 'loaded' );
	}

	$(document).ready(function(){
		if( $('.focuswp-media-frame-inner .focuswp-widget--tabs').length > 0 ){
			focuswp_opts_init( '', 'loaded' );
		}
		$(".widget-liquid-right .widget, .inactive-sidebar .widget, #accordion-panel-widgets .customize-control-widget_form").each(function (i, widget) {
	    	focuswp_opts_init( '', 'loaded' );
	  	});
	  	$(document).on('widget-added', function(event, widget) {
		    focuswp_opts_init( widget, 'added' );

		});
		$(document).on('widget-updated', function(event, widget) {
			focuswp_opts_init( widget, 'updated' );
		});
	});

	function focuswp_opts_init( widget, action ){
		selected = 0;
		if( ''	!=	widget ){
			if( $( '#' + widget.attr('id') ).find('#focuswp-widget-opts-selectedtab').length > 0 ){
				selected = $( '#' + widget.attr('id') ).find('#focuswp-widget-opts-selectedtab').val();
				selected = parseInt( selected );
			}
		}
		if( action == 'added' ){
			selected 			= 0;
		}

	    if( '' != widget ){
	    	if( $( '#' + widget.attr('id') ).find('.focuswp-widget--tabs').length > 0 ){
	    		$( '#' + widget.attr('id') ).find('.focuswp-widget--tabs').tabs({ active: selected });
	    	}

	    }else{
	    	$('.focuswp-widget--tabs').tabs({ active: selected });
	    }

	    $('.focuswp-widget--tabs').click('tabsselect', function (event, ui) {
			if( $(this).find('#focuswp-widget-opts-selectedtab').length > 0 ){
				$(this).find('#focuswp-widget-opts-selectedtab').val( $(this).tabs('option', 'active') );
			}
		});
	}

})( jQuery, window, document );
