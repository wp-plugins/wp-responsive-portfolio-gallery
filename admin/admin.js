jQuery(document).ready(function() {
  jQuery('#la-loader').hide();
  jQuery('#la-saved').hide();
  jQuery('.ui-state-default').last().hide();
  
  jQuery('.clonecol .uploadImage').click(function( event ){
     
        event.preventDefault();
     
     var parent = jQuery(this).closest('.clonecol').find('.collection');
     console.log(parent);
        // Create the media frame.
        la_portfolio_gallery = wp.media.frames.la_portfolio_gallery = wp.media({
          title: 'Select Images for Portfolio',
          button: {
            text: 'Add',
          },
          multiple: false  // Set to true to allow multiple files to be selected
        });
     
        // When an image is selected, run a callback.
        la_portfolio_gallery.on( 'select', function() {
            // We set multiple to false so only get one image from the uploader
            var selection = la_portfolio_gallery.state().get('selection');
            selection.map( function( attachment ) {
                attachment = attachment.toJSON();
                
                parent.append('<div><img src="'+attachment.url+'"><span class="dashicons dashicons-dismiss"></span></div>');

            });  
        });
     
        // Finally, open the modal 
        la_portfolio_gallery.open();
    });

  jQuery('.collection').on('click', '.dashicons-dismiss', function() {
        jQuery(this).parent('div').remove();
  });

  var divs = jQuery("div .row > div.col-sm-4");
  console.log(divs);
  for(var i = 0; i < divs.length; i+=3) {
    divs.slice(i, i+3).wrapAll("<div class='row'></div>");
  }

  jQuery('#accordion #add').click(function(event) {
    var parent = jQuery(this).closest('.row');

      jQuery(this).closest('.col-sm-4').clone(true).appendTo(parent);
      
  });

   jQuery('#accordion #dell').click(function(event) {
    // var parent = jQuery(this).closest('.row');

      jQuery(this).closest('.col-sm-4').remove();
      
  });

    jQuery('.saveData').click(function(event) {
     event.preventDefault();
     jQuery('#la-saved').hide();
     jQuery('#la-loader').show();
     var allport = [];
     jQuery('.clonecol').each(function(index, el) {
      var portfolio = {};
      portfolio.title = jQuery(this).find('.portTitle').val();
      portfolio.content = jQuery(this).find('.portContent').val();
      portfolio.url = jQuery(this).find('.portUrl').val();

      portfolio.portImages = [];
       jQuery(this).find('.collection div').each(function(index, el) {
        portfolio.portImages[index] = jQuery(this).find('img').attr('src'); 
       });
       allport.push(portfolio);
     });
     // console.log(allport);
     
    
     
     var portData = {
      action: 'la_save_portfolio_gallery_data',
      port: allport,
      urllable: jQuery('.urllabel').val(),
      urlbtnsize: jQuery('#btnsize').val()
     }

     jQuery.post(laAjax.url, portData, function(resp) {
        jQuery('#la-loader').hide();
        jQuery('#la-saved').show();
        jQuery('#la-saved').delay(2000).fadeOut();

     });
    });
});