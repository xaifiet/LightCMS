
jQuery.extend(jQuery.expr[':'], {
    dataaddprototype: function (el) { if ($(el).data('addprototype') != undefined) { return true; } return false; },
    datadelete: function (el) { if ($(el).data('delete') != undefined) { return true; } return false; },
    dataform: function (el) { if ($(el).data('form') != undefined) { return true; } return false; },
});

summernoteInit = function(event, elem, params) {
    $(elem).summernote({
        height: 150
    });
};

sidebarReady = function(event, elem, params) {
    var events = $._data(elem, "events" );
    var func = events.click[0].handler;
    $(elem).off('click');
    $(elem).on('click', sidebarClick);
    $(elem).on('click', func);
};

sidebarClick = function(event) {
    var link = $(this).closest('a');
    var i = $('i.pull-right', link);

    if (event.target.tagName == 'I' || event.target.tagName == 'i') {
        return false;
    }

    if ($(this).attr('href') != "#") {
        window.location.href = link.attr('href');

    }
    event.stopImmediatePropagation();
    return false;

};

submitForm = function(event, elem, params) {
    var formName = params[0];
    var form = $('form[name="'+formName+'"]');

    $('*[type="submit"]', form).trigger('click');
};

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
};

deleteCollectionRow = function(event, elem, params) {
    var div = $(elem).closest(params[0]);
    $(div.remove());
    return false;
};

loadModal = function(event, elem, params) {
    $(params[0]).modal({
        'remote': params[1]
    });
};

addPrototype = function(event, elem, params) {
    var id = params[0];
    var div = $('#'+ id);

    var newid = 0;
    console.log(div);
    console.log('#'+id+'_'+newid);
    while ($('#'+id+'_'+newid, div).length > 0) {
        console.log('loop');
        newid++;
    }

    var prototype = $(elem).data('prototype');
    var newitem = prototype.replace(/__name__/g, newid);
    $(div).append($(newitem));

    return false;
};

setWidgetSize = function(event, elem, params) {
    var widget = $(elem).closest('.widgetform');
    $(widget).removeClass (function (index, css) {
        return (css.match (/(^|\s)col-\S+/g) || []).join(' ');
    });
    $(widget).addClass(params[1]);
    $('#'+$(widget).attr('id')+'_size', widget).val(params[0]);
};

sortable = function(event, elem, params) {
    $(elem).sortable({
        handle: params[0]
    });

};