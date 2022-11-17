CKEDITOR.plugins.add( 'simplebox', {
    requires: 'widget',

    icons: 'simplebox',

    init: function( editor ) {
        editor.widgets.add( 'simplebox', {
            button: 'Create a simple box',

            allowedContent: 'div(!rowd);div(!colc)',
            requiredContent: 'div(rowd)',
            upcast: function(element) {
                return element.name == 'div' && element.hasClass('rowd');
            },

            template:
            '<div class="rowd" style="display: flex;">' +

            '<div style="width: 100%" class="colc"><p>Content...</p></div>' +
            '<div style="width: 100%" class="colc"><p>Content...</p></div>' +
            '</div>',


            editables: {

                content: {
                    selector: '.colc',
                    selector: '.colc'
                }
            },

        } );
    }
} );