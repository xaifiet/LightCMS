
jQuery.extend(jQuery.expr[':'], {
    dataaddprototype: function (el) { if ($(el).data('addprototype') != undefined) { return true; } return false; },
    datadelete: function (el) { if ($(el).data('delete') != undefined) { return true; } return false; },
    dataform: function (el) { if ($(el).data('form') != undefined) { return true; } return false; }
});

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

submitForm = function(event, elem, params) {
    var formName = params[0];
    var form = $('form[name="'+formName+'"]');

    $('*[type="submit"]', form).trigger('click');
}

addCollectionRow = function(event, elem, params) {

    var id = params[0];
    var div = $('#'+ id);

    var newid = 0;
    while ($('#'+id+'_'+newid, div).length > 0) {
        newid++;
    }

    var prototype = $(div).data('prototype');
    var newitem = prototype.replace(/__name__/g, newid);
    $(div).append($(newitem));

    return false;
}

deleteCollectionRow = function(event, elem, params) {
    var div = $(elem).closest(params[0]);
    $(div.remove());
    return false;
}