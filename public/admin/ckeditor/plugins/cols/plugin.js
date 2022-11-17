CKEDITOR.plugins.add( 'cols', {
    icons: 'simage',

    init: function( editor ) {
        editor.addCommand('cols', {
            exec: function (editor) {

                editor.insertHtml('<div class="row" style="display:flex;width: 100%"><div style="display: inline-block;width: 50%"></div><div style="display: inline-block;width: 50%"></div><div style="display: inline-block;width: 50%"></div></div>');

            }
        });



        editor.ui.addButton( 'Cols', {
            label: 'Ccols',
            command: 'cols',
            toolbar: 'insert'
        });
    }
});

