summernoteInit = function(event, elem, params) {
    $(elem).summernote({
        height: 150
    });
};

submitForm = function(event, elem, params) {
    var formName = params[0];
    var form = $('form[name="'+formName+'"]');

    $('*[type="submit"]', form).trigger('click');
};


loadModal = function(event, elem, params) {
    $(params[0]).modal({
        'remote': params[1]
    });
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
};

treegrid = function(event, elem, params) {
    $(elem).treegrid({
        initialState: 'collapsed'
    });
    expandParentRecursive($('.tree-activate', elem));
};