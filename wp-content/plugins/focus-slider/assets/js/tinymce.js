(function() {
	// global tinymce;
	tinymce.PluginManager.add('focuswp_edit', function(editor, url) {
	  var toolbarActive = false;

	  // Add a button that opens a window. This is just the toolbar.
	  editor.addButton('focuswp_edit', {
	    text: false,
	    icon: 'icon dashicons-chart-area',
		classes: 'focuswp-mce-btn-icon',
	    onclick: function() {
	      // Open window
	      editor.windowManager.open({
	        title: focuswp_localized.title,
	        width: jQuery(window).width() - 100,
	        height: jQuery(window).height() - 100,
	        url: focuswp_localized.url,
	        buttons: false
	      });
	    }
	  });

	  function editImage( img ) {
	    // Open window
	    editor.windowManager.open({
	      title: focuswp_localized.title,
	      width: jQuery(window).width() - 100,
	      height: jQuery(window).height() - 100,
	      url: focuswp_localized.url,
	      buttons: false
	      },
	      { // This object is passed to the receiving URL via parent.tinymce.activeEditor.windowManager.getParams()
	        scdata: img
	      }
	    );
	  }
	  // Remove the element if the "delete" button is clicked.
	  function removeImage( node ) {
	    var wrap;

	    if ( node.nodeName === 'DIV' && editor.dom.hasClass( node, 'mceTemp' ) ) {
	      wrap = node;
	  } else if ( node.nodeName === 'SPAN' || node.nodeName === 'DT' || node.nodeName === 'A' ) {
	      wrap = editor.dom.getParent( node, 'div.mceTemp' );
	    }

	    if ( wrap ) {
	      if ( wrap.nextSibling ) {
	        editor.selection.select( wrap.nextSibling );
	      } else if ( wrap.previousSibling ) {
	        editor.selection.select( wrap.previousSibling );
	      } else {
	        editor.selection.select( wrap.parentNode );
	      }

	      editor.selection.collapse( true );
	      editor.nodeChanged();
	      editor.dom.remove( wrap );
	    } else {
	      editor.dom.remove( node );
	    }
	    removeToolbar();
	  }

	  // This adds the "edit" and "delete" buttons.
	  function addToolbar( node ) {
	    var rectangle, toolbarHtml, toolbar, left,
	      dom = editor.dom;

	    removeToolbar();

	    // Don't add to placeholders
	    if ( ! node || node.nodeName !== 'SPAN' || isPlaceholder( node ) ) {
	      return;
	    }
	    dom.setAttrib( node, 'data-wp-focuswpselect', 1 );
	    rectangle = dom.getRect( node );

	    toolbarHtml = '<div class="dashicons dashicons-edit edit" data-mce-bogus="1"></div>' +
	      '<div class="dashicons dashicons-no remove" data-mce-bogus="1"></div>';

	    toolbar = dom.create( 'div', {
	      'id': 'focuswp-toolbar',
		  'class': 'focuswp-toolbar-grp',
	      'data-mce-bogus': '1',
		  'style' : 'position: absolute;',
	      'contenteditable': false
	    }, toolbarHtml );

	    if ( editor.rtl ) {
	      left = rectangle.x + rectangle.w - 82;
	    } else {
	      left = rectangle.x;
	    }

	    editor.getBody().appendChild( toolbar );
	    dom.setStyles( toolbar, {
	      top: rectangle.y,
	      left: left
	    });

		// console.log( toolbar );
	    toolbarActive = true;
	  }

	  function isPlaceholder( node ) {
	    var dom = editor.dom;

	    if ( /*dom.hasClass( node, 'mceItem' ) ||*/ dom.getAttrib( node, 'data-mce-placeholder' ) ||
	      dom.getAttrib( node, 'data-mce-object' ) ) {

	      return true;
	    }

	    return false;
	  }

	  editor.on( 'mousedown', function( event ) {
	    if ( editor.dom.getParent( event.target, '#focuswp-toolbar' ) ) {
	      if ( tinymce.Env.ie ) {
	        // Stop IE > 8 from making the wrapper resizable on mousedown
	        event.preventDefault();
	      }
	  } else if ( event.target.nodeName !== 'SPAN' ) {
	      removeToolbar();
	    }
	  });

	  editor.on( 'mouseup', function( event ) {
	    var image,
	      node = event.target,
	      dom = editor.dom;

	    // Don't trigger on right-click
	    if ( event.button && event.button > 1 ) {
	      return;
	    }

	    if ( node.nodeName === 'DIV' && dom.getParent( node, '#focuswp-toolbar' ) ) {
	      image = dom.select( 'span[data-wp-focuswpselect]' )[0];
		  if ( image ) {
	        editor.selection.select( image );
	        if ( dom.hasClass( node, 'remove' ) ) {
	          removeImage( image );
	        } else if ( dom.hasClass( node, 'edit' ) ) {
	          editImage( image );
	        }
	      }
	    } else if ( node.nodeName === 'SPAN' && ! editor.dom.getAttrib( node, 'data-wp-focuswpselect' ) && ! isPlaceholder( node ) ) {
	      addToolbar( node );
		  } else if ( node.nodeName !== 'SPAN' ) {
		      removeToolbar();
			}
	  });

	  editor.on( 'cut', function() {
	    removeToolbar();
	  });

	  // This removes the edit and delete buttons.
	  function removeToolbar() {
	    var toolbar = editor.dom.get( 'focuswp-toolbar' );

	    if ( toolbar ) {
	      editor.dom.remove( toolbar );
	    }

	    editor.dom.setAttrib( editor.dom.select( 'span[data-wp-focuswpselect]' ), 'data-wp-focuswpselect', null );

	    toolbarActive = false;
	  }

	  editor.on( 'PostProcess', function( event ) {
	    if ( event.get ) {
	      event.content = event.content.replace( / data-wp-focuswpselect="1"/g, '' );
	    }
	  });

	});
})();
