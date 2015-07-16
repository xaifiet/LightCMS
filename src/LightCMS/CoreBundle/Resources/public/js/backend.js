
$(document).ready(function() {
    $('.summernote').summernote({
        height: 150
    });

    $('.sidebar-menu li a').each(function() {
        var events = $._data( this, "events" );
        var func = events.click[0].handler;
        $(this).off('click');
        $(this).on('click', function(event) {

            var link = $(this).closest('a');
            var i = $('i.pull-right', link);

            console.log(event.target.tagName);

            if (event.target.tagName == 'I' || event.target.tagName == 'i') {
                return false;
            }

            if ($(this).attr('href') != "#") {
                window.location.href = link.attr('href');

            }
            event.stopImmediatePropagation();
            return false;
        });
        $(this).on('click', func);
    });


});
