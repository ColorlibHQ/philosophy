(function( $ , api){

    // Customizer about page redirect
    api.section( 'philosophy_fof_section' , function( section ){

        section.expanded.bind( function( isExpanded ){

            if( isExpanded ){
                api.previewer.previewUrl.set( api.settings.url.home+'/maybe404page' );
            }else{
                api.previewer.previewUrl.set( api.settings.url.home );
            }
            
        } )

    } );

    // Customizer about page redirect
    api.section( 'philosophy_about_section' , function( section ){

        section.expanded.bind( function( isExpanded ){

            if( isExpanded ){
                api.previewer.previewUrl.set( api.settings.url.home+customizerdata.about_page );
            }else{
                api.previewer.previewUrl.set( api.settings.url.home );
            }
            


        } )

    } );

    // Customizer blog page redirect
    api.section( 'philosophy_blog_section' , function( section ){

        section.expanded.bind( function( isExpanded ){

            if( isExpanded ){
                api.previewer.previewUrl.set( customizerdata.blog_page );
            }else{
                api.previewer.previewUrl.set( api.settings.url.home );
            }
            


        } )

    } );

    // Customizer contact page redirect
    api.section( 'philosophy_contact_section' , function( section ){

        section.expanded.bind( function( isExpanded ){

            // Customizer contact form seclector 
            var customshortcodefield = $('#customize-control-philosophy_contact_custom_formshortcode'),
                selector = $('#_customize-input-philosophy_contact_formshortcode');

                if( selector.val() != 'cs' ){
                    customshortcodefield.hide();
                }

            // redirect url
            if( isExpanded ){

                api.previewer.previewUrl.set( api.settings.url.home+customizerdata.contact_page );
            }else{
                api.previewer.previewUrl.set( api.settings.url.home );
            }
            

            // Contact form select change event
            selector.on( 'change', function(){

                if( $(this).val() !== 'cs' ){
                    
                    customshortcodefield.hide();
                }else{
                    customshortcodefield.show();
                     
                }
                
            } );

            

        } );


    } );


})( jQuery, wp.customize );