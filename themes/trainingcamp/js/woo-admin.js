jQuery( function( $ ) {
    /**
     * Variations actions
     */
    var wc_meta_boxes_product_variations_actions = {

        /**
         * Initialize variations actions
         */
        init: function() {
            $( '#woocommerce-product-data' ).on( 'woocommerce_variations_loaded', this.variations_loaded );
            $( document.body ).on( 'woocommerce_variations_added', this.variation_added );
        },


        /**
         * Run actions when variations is loaded
         *
         */
        variations_loaded: function() {

            var wrapper = $(document).find( '#woocommerce-product-data' );
            // Datepicker fields
            $( '.wc-metabox-content',wrapper ).each( function() {
                var dates = $( this ).find( 'input.course_date' ).datepicker({
                    defaultDate:     '',
                    dateFormat:      'yy-mm-dd',
                    numberOfMonths:  1,
                    showButtonPanel: true,
                    onSelect:        function( selectedDate ) {
                        var option   = $( this ).is( '.sale_price_dates_from' ) ? 'minDate' : 'maxDate',
                            instance = $( this ).data( 'datepicker' ),
                            date     = $.datepicker.parseDate( instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings );

                        dates.not( this ).datepicker( 'option', option, date );
                        $( this ).change();
                    }
                });
            });
        },


        /**
         * Checked virtual for new variation
         *
         */
        check_virtual_on_add_variation: function() {
            var wrapper_new = $(document).find( '.variation-needs-update' );
            $(wrapper_new).find('.checkbox.variable_is_virtual').attr( 'checked', 'checked' ).trigger( 'change' );
        },


        /**
         * Run actions when added a variation
         *
         */
        variation_added: function( event, qty ) {
            if ( 1 === qty ) {
                wc_meta_boxes_product_variations_actions.variations_loaded();
                wc_meta_boxes_product_variations_actions.check_virtual_on_add_variation();
            }
        }

    };

    wc_meta_boxes_product_variations_actions.init();
});