jQuery.extend(jQuery.expr[':'], {
    bind: function (el) { if ($(el).data('bind') != undefined) { return true; } return false; }
});

/*
 * jQuery ajax functions
 *
 * Activate action by using attribute data-ajax
 *
 * Example <a href="/user/login" data-ajax="click[appendTo(body)]"
 * On click on this link, the appendTo function is called to add
 * link location content to body
 */
jQuery.fn.ajaxBind = function() {

    bindelem = function(elem, ajax) {
        var regexps = {
            'a': /^([^[]+)\[([^(]+)\(([^)]*)\)\]$/,
            'c': /^([^[]+)\{([^(]+)\(([^)]*)\)\}$/
        };
        var type = null;
        var matches = null;
        for(var key in regexps) {
            if (regexps[key].test(ajax)) {
                matches = ajax.match(regexps[key]);
                type = key;
                break;
            }
        }
        if (type == null) {
            return;
        }
        if (matches[1] == 'ready') {
            if (window[matches[2]] != undefined) {
                window[matches[2]](event, elem, matches[3].split(','));
            }
            return false;
        }
        $(elem).bind(matches[1], function(event) {
            if (type == 'a' && event.target != this) {
                return false;
            } else if (type == 'c' && (event.target != this && $(this).has(event.target).length == 0)) {
                return false;
            }
            if (window[matches[2]] != undefined) {
                window[matches[2]](event, elem, matches[3].split(','));
            }
            return false;
        });
    };

    $(this).each(function() {
        if ($(this).data('bind') != undefined) {
            if ($(this).data('bind').length > 0) {
                var events = $(this).data('bind').split('|');
                $(this).removeData('bind');
                $(this).removeAttr('data-bind');
                for (var i = 0; i < events.length; i++) {
                    bindelem(this, events[i]);
                }
            }
        }
    });
};

$(document).ready(function() {

    $('*:bind', document).ajaxBind();

    $(document).bind('DOMSubtreeModified', function () {
        $('*:bind', document).ajaxBind();
    });

});