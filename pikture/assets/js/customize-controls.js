/**
 * Scripts within the customizer controls window.
 *
 */

jQuery( document ).ready(function($) {
    //Chosen JS
    $(".theme-palace-chosen-select").chosen({
        width: "100%"
    });
    // Sortable sections
    jQuery( "body" ).on( 'hover', '.pikture-pro-drag-handle', function() {
        jQuery( 'ul.pikture-pro-sortable-list' ).sortable({
            handle: '.pikture-pro-drag-handle',
            axis: 'y',
            update: function( e, ui ){
                jQuery('input.pikture-pro-sortable-input').trigger( 'change' );
            }
        });
    });

    /* On changing the value. */
    jQuery( "body" ).on( 'change', 'input.pikture-pro-sortable-input', function() {
        /* Get the value, and convert to string. */
        this_checkboxes_values = jQuery( this ).parents( 'ul.pikture-pro-sortable-list' ).find( 'input.pikture-pro-sortable-input' ).map( function() {
            return this.value;
        }).get().join( ',' );

        /* Add the value to hidden input. */
        jQuery( this ).parents( 'ul.pikture-pro-sortable-list' ).find( 'input.pikture-pro-sortable-value' ).val( this_checkboxes_values ).trigger( 'change' );

    });

    //Switch Control
    $('body').on('click', '.onoffswitch', function(){
        var $this = $(this);
        if($this.hasClass('switch-on')){
            $(this).removeClass('switch-on');
            $this.next('input').val( false ).trigger('change')
        }else{
            $(this).addClass('switch-on');
            $this.next('input').val( true ).trigger('change')
        }
    });

    // Gallery Control
    $('.upload_gallery_button').click(function(event){
        var current_gallery = $( this ).closest( 'label' );

        if ( event.currentTarget.id === 'clear-gallery' ) {
            //remove value from input
            current_gallery.find( '.gallery_values' ).val( '' ).trigger( 'change' );

            //remove preview images
            current_gallery.find( '.gallery-screenshot' ).html( '' );
            return;
        }

        // Make sure the media gallery API exists
        if ( typeof wp === 'undefined' || !wp.media || !wp.media.gallery ) {
            return;
        }
        event.preventDefault();

        // Activate the media editor
        var val = current_gallery.find( '.gallery_values' ).val();
        var final;

        if ( !val ) {
            final = '[gallery ids="0"]';
        } else {
            final = '[gallery ids="' + val + '"]';
        }
        var frame = wp.media.gallery.edit( final );

        frame.state( 'gallery-edit' ).on(
            'update', function( selection ) {

                //clear screenshot div so we can append new selected images
                current_gallery.find( '.gallery-screenshot' ).html( '' );

                var element, preview_html = '', preview_img;
                var ids = selection.models.map(
                    function( e ) {
                        element = e.toJSON();
                        preview_img = typeof element.sizes.thumbnail !== 'undefined' ? element.sizes.thumbnail.url : element.url;
                        preview_html = "<div class='screen-thumb'><img src='" + preview_img + "'/></div>";
                        current_gallery.find( '.gallery-screenshot' ).append( preview_html );
                        return e.id;
                    }
                );

                current_gallery.find( '.gallery_values' ).val( ids.join( ',' ) ).trigger( 'change' );
            }
        );
        return false;
    });

    $( document ).on( 'click', '.customize_multi_add_field', pikture_pro_customize_multi_add_field )
        .on( 'change', '.customize_multi_single_field', pikture_pro_customize_multi_single_field )
        .on( 'click', '.customize_multi_remove_field', pikture_pro_customize_multi_remove_field )

    /********* Multi Input Custom control ***********/
    $( '.customize_multi_input' ).each(function() {
        var $this = $( this );
        var multi_saved_value = $this.find( '.customize_multi_value_field' ).val();
        if (multi_saved_value.length > 0) {
            var multi_saved_values = multi_saved_value.split( "|" );
            $this.find( '.customize_multi_fields' ).empty();
            var $control = $this.parents( '.customize_multi_input' );
            $.each(multi_saved_values, function( index, value ) {
                $this.find( '.customize_multi_fields' ).append( '<div class="set"><input type="text" value="' + value + '" class="customize_multi_single_field" /><span class="customize_multi_remove_field"><span class="dashicons dashicons-no-alt"></span></span></div>' );
            });
        }
    });

    function pikture_pro_customize_multi_add_field(e) {
        var $this = $( e.currentTarget );
        e.preventDefault();
            var $control = $this.parents( '.customize_multi_input' );
            $control.find( '.customize_multi_fields' ).append( '<div class="set"><input type="text" value="" class="customize_multi_single_field" /><span class="customize_multi_remove_field"><span class="dashicons dashicons-no-alt"></span></span></div>' );
            pikture_pro_customize_multi_write( $control );
    }

    function pikture_pro_customize_multi_single_field() {
        var $control = $( this ).parents( '.customize_multi_input' );
        pikture_pro_customize_multi_write( $control );
    }

    function pikture_pro_customize_multi_remove_field(e) {
        e.preventDefault();
        var $this = $( this );
        var $control = $this.parents( '.customize_multi_input' );
        $this.parent().remove();
        pikture_pro_customize_multi_write( $control );
    }

    function pikture_pro_customize_multi_write( $element) {
        var customize_multi_val = '';
        $element.find( '.customize_multi_fields .customize_multi_single_field' ).each(function() {
            customize_multi_val += $( this ).val() + '|';
        });
        $element.find( '.customize_multi_value_field' ).val( customize_multi_val.slice( 0, -1 ) ).change();
    }       
});

/**
 * Add a listener to update other controls to new values/defaults.
 */

( function( api ) {
    // Only show the color hue control when there's a custom color scheme.
    wp.customize( 'pikture_pro_theme_options[colorscheme]', function( setting ) {
        wp.customize.control( 'pikture_pro_theme_options[colorscheme_hue]', function( control ) {
            var visibility = function() {
                if ( 'custom' === setting.get() ) {
                    control.container.slideDown( 180 );
                } else {
                    control.container.slideUp( 180 );
                }
            };

            visibility();
            setting.bind( visibility );
        });
    });

    wp.customize( 'pikture_pro_theme_options[reset_options]', function( setting ) {
        setting.bind( function( value ) {
            var code = 'needs_refresh';
            if ( value ) {
                setting.notifications.add( code, new wp.customize.Notification(
                    code,
                    {
                        type: 'info',
                        message: pikture_pro_cusomizer_control_data.reset_message
                    }
                ) );
            } else {
                setting.notifications.remove( code );
            }
        } );
    } );

    wp.customize( 'pikture_pro_theme_options[panorama_num_of_img]', function( setting ) {
        setting.bind( function( value ) {
            var code = 'needs_refresh';
            if ( value ) {
                setting.notifications.add( code, new wp.customize.Notification(
                    code,
                    {
                        type: 'info',
                        message: pikture_pro_cusomizer_control_data.num_chng_msg
                    }
                ) );
            } else {
                setting.notifications.remove( code );
            }
        } );
    } );

    wp.customize( 'pikture_pro_theme_options[portrait_num_of_img]', function( setting ) {
        setting.bind( function( value ) {
            var code = 'needs_refresh';
            if ( value ) {
                setting.notifications.add( code, new wp.customize.Notification(
                    code,
                    {
                        type: 'info',
                        message: pikture_pro_cusomizer_control_data.num_chng_msg
                    }
                ) );
            } else {
                setting.notifications.remove( code );
            }
        } );
    } );

    wp.customize( 'pikture_pro_theme_options[client_num]', function( setting ) {
        setting.bind( function( value ) {
            var code = 'needs_refresh';
            if ( value ) {
                setting.notifications.add( code, new wp.customize.Notification(
                    code,
                    {
                        type: 'info',
                        message: pikture_pro_cusomizer_control_data.num_chng_msg
                    }
                ) );
            } else {
                setting.notifications.remove( code );
            }
        } );
    } );

    wp.customize( 'pikture_pro_theme_options[landscape_num_of_img]', function( setting ) {
        setting.bind( function( value ) {
            var code = 'needs_refresh';
            if ( value ) {
                setting.notifications.add( code, new wp.customize.Notification(
                    code,
                    {
                        type: 'info',
                        message: pikture_pro_cusomizer_control_data.num_chng_msg
                    }
                ) );
            } else {
                setting.notifications.remove( code );
            }
        } );
    } );

    wp.customize( 'pikture_pro_theme_options[testimonial_num]', function( setting ) {
        setting.bind( function( value ) {
            var code = 'needs_refresh';
            if ( value ) {
                setting.notifications.add( code, new wp.customize.Notification(
                    code,
                    {
                        type: 'info',
                        message: pikture_pro_cusomizer_control_data.num_chng_msg
                    }
                ) );
            } else {
                setting.notifications.remove( code );
            }
        } );
    } );


    wp.customize( 'pikture_pro_theme_options[about_slider_num]', function( setting ) {
        setting.bind( function( value ) {
            var code = 'needs_refresh';
            if ( value ) {
                setting.notifications.add( code, new wp.customize.Notification(
                    code,
                    {
                        type: 'info',
                        message: pikture_pro_cusomizer_control_data.num_chng_msg
                    }
                ) );
            } else {
                setting.notifications.remove( code );
            }
        } );
    } );

    wp.customize( 'pikture_pro_theme_options[about_temp_counter_num]', function( setting ) {
        setting.bind( function( value ) {
            var code = 'needs_refresh';
            if ( value ) {
                setting.notifications.add( code, new wp.customize.Notification(
                    code,
                    {
                        type: 'info',
                        message: pikture_pro_cusomizer_control_data.num_chng_msg
                    }
                ) );
            } else {
                setting.notifications.remove( code );
            }
        } );
    } );

    wp.customize( 'pikture_pro_theme_options[about_temp_slider_num]', function( setting ) {
        setting.bind( function( value ) {
            var code = 'needs_refresh';
            if ( value ) {
                setting.notifications.add( code, new wp.customize.Notification(
                    code,
                    {
                        type: 'info',
                        message: pikture_pro_cusomizer_control_data.num_chng_msg
                    }
                ) );
            } else {
                setting.notifications.remove( code );
            }
        } );
    } );
    
    // Deep linking for counter section to about section.
    wp.customize.bind('ready', function() {
        jQuery('a[rel="pikture-counter"]').click(function(e) {
            e.preventDefault();
            wp.customize.control( 'pikture_pro_theme_options[enable_about_section]' ).focus()
        });
    });

} )( wp.customize );