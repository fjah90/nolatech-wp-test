jQuery(document).ready(function($){

    $('body').on('click', '.flush-it', function(event) {
        $.ajax ({
            url     : sublime_blog_cdata.ajax_url,  
            type    : 'post',
            data    : 'action=flush_local_google_fonts',    
            nonce   : sublime_blog_cdata.nonce,
            success : function(results){
                //results can be appended in needed
                $( '.flush-it' ).val(sublime_blog_cdata.flushit);
            },
        });
    });
    
});