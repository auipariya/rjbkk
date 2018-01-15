/**
 * Created by Aui on 15/5/2559.
 */

if(typeof jQuery === 'undefined'){
    throw new Error('Main\'s JavaScript requires jQuery');
}


/* Tooggle canvas */
+function($){
    'use strict';

    $('[data-toggle="tooltip"]').tooltip();

    $('[data-toggle="offcanvas"]').click(function(){
        $('.row-offcanvas').toggleClass('active');

        if($(this.children[0]).hasClass('glyphicon-chevron-right')){
            $(this.children[0])
                .removeClass('glyphicon-chevron-right')
                .addClass('glyphicon-chevron-left');
        }
        else{
            $(this.children[0])
                .removeClass('glyphicon-chevron-left')
                .addClass('glyphicon-chevron-right');
        }
    });
}(jQuery);

/* Switch language */
+function($){
    'use strict';

    $.ajaxSetup({
        headers: { 'X-CSRF-Token' : $('meta[name="_token"]').attr('content') }
    });

    $('#localization').on('click', function (e) {
        var localeCurrent = $('input[name="locale"]').val();
        var locale = e.target.value;
        if(locale !== null && locale != localeCurrent){
            location.href = '?lang=' + locale;
        }
    });
}(jQuery);