(function ($) {
    /*=========================================
    Epsilon Framework Sidebar Responsive Tools 
    =============================================*/
    $( document ).ready(function() {
        var desktop = $( '.preview-desktop' ),
            tablet  = $( '.preview-tablet' ),
            mobile  = $( '.preview-mobile' );

            desktop.on( 'click', function(){
                desktop.addClass('active');
                tablet.removeClass('active'); 
                mobile.removeClass('active'); 
            } );

            tablet.on( 'click', function(){
                desktop.removeClass('active'); 
                tablet.addClass('active');
                mobile.removeClass('active'); 
            } );
        
            mobile.on( 'click', function(){
                desktop.removeClass('active'); 
                tablet.removeClass('active');
                mobile.addClass('active'); 
            } );
         
    });


})(jQuery);