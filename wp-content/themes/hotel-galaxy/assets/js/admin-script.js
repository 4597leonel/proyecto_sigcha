( function( $ ){
    $( document ).ready( function(){
      $( '.hotelgalaxy-btn-get-started' ).on( 'click', function( e ) {
          e.preventDefault();
          $( this ).html( 'Processing.. Please wait' ).addClass( 'updating-message' );
          $.post( hotelgalaxy_ajax_object.ajax_url, { 'action' : 'install_act_plugin' }, function( response ){
              location.href = 'customize.php';
          } );
      } );
    } );

    $( document ).on( 'click', '.notice-get-started-class .notice-dismiss', function () {
        
        var type = $( this ).closest( '.notice-get-started-class' ).data( 'notice' );
        
        $.ajax( ajaxurl,
          {
            type: 'POST',
            data: {
              action: 'hotelgalaxy_dismissed_notice_handler',
              type: type,
            }
          } );
      } );
}( jQuery ) )
