
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
    while ($('#'+id+'_'+newid, div).length > 0) {
        newid++;
    }

    var prototype = $(elem).data('prototype');
    var newitem = prototype.replace(/__name__/g, newid);
    $(div).append($(newitem));

    if ($(div).data('positions') !== undefined) {
        rePosition(div, $(div).data('positions'));
    }

    return false;
};

setWidgetSize = function(event, elem, params) {
    var widget = $(elem).closest('.widgetform');
    console.log(widget);
    $(widget).removeClass (function (index, css) {
        return (css.match (/(^|\s)col-\S+/g) || []).join(' ');
    });
    $(widget).addClass(params[1]);
    $('#'+$(widget).attr('id')+'_size', widget).val(params[0]);
};

rePosition = function(elem, input) {
    var position = 0;
    $(input, elem).each(function() {
        $(this).val(position);
        position += 1;
    })
};

sortable = function(event, elem, params) {
    $(elem).sortable({
        handle: params[0],
        forcePlaceholderSize: true,
        start: function(event, ui) {
            $(ui.placeholder).html($(ui.helper.html()));
            $(ui.placeholder).css('visibility', 'visible');
        },
        stop: function(event, ui) {
            if ($(elem).data('positions') !== undefined) {
                rePosition(elem, $(elem).data('positions'));
            }
        }
    });

};

inputSet = function(event, elem, params) {

    $(params[0]).val(params[1]);

};

changeModalEntity = function(event, elem, params) {
    var modal = $(elem).closest('div.modal');

    $('#'+modal.data('id')).val(params[0]);
    $('#'+modal.data('name')).val(params[1]);
    $(modal).modal('hide')
};

showHideTree = function(event, elem, params) {
    var li = $(elem).closest('li');
    $('> div.treetoggle i', li).toggleClass('fa-angle-right');
    $('> div.treetoggle i', li).toggleClass('fa-angle-down');
    $('> ul', li).toggle();
}

setFocus = function(event, elem, params) {
    if (params.length > 0) {
        $(params[0]).focus();
    } else {
        $(elem).focus();
    }
};

filter = function(event, elem, params) {

    var rex = new RegExp($(elem).val(), 'i');
    $('.searchable tr').hide();
    $('.searchable tr').filter(function () {
        return rex.test($(this).text());
    }).css('display', '');

};

loadFromElem = function(event, elem, params) {
    var widget = $('#'+params[0]);
    var body = $('.box-body', $(widget));

    $(elem).val($(body).html());
    $(elem).data('target', body);
};

saveWidget = function(event, elem, params) {
    var input = $('#test');
    var body = $(input).data('target');
    $(body).html($(input).code());
};

expandParentRecursive = function(elem) {

    if ($(elem).treegrid('isNode')) {
        if ($(elem).treegrid('getDepth') > 0) {
            var parent = $(elem).treegrid('getParentNode');
            $(parent).treegrid('expand');
            expandParentRecursive(parent);
        }
    }
}

treegrid = function(event, elem, params) {
    $(elem).treegrid({
        initialState: 'collapsed'
    });
    expandParentRecursive($('.tree-activate', elem));
}