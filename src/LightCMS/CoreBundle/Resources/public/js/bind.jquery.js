jQuery.extend(jQuery.expr[':'], {
    bind: function (el) { return $(el).data('bind') != undefined;  }
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

    var matchEvent = function (event) {

        var regexps = {
            'a': /^([^[]+)\[([^\]]+)\]$/,
            'c': /^([^[]+)\{([^\}]+)\}$/
        };

        var type = null;
        for (key in regexps) {
            if (regexps[key].test(event)) {
                type = key;
            }
        }
        if (type == null) {
            return null;
        }

        var matches = event.match(regexps[type]);

        return {
            'event': matches[1].replace(/^@/, ''),
            'return': matches[1].charAt(0) == '@',
            'type': type,
            'actions': matches[2]
        };

    };

    var execActions = function (event, elem, actionsString) {
        var regexp = /^([^(]+)\(([^)]*)\)$/;

        var actions = actionsString.split(';');

        for (var i = 0; i < actions.length; i++) {
            if (regexp.test(actions[i])) {
                var matches = actions[i].match(regexp);
                if (window[matches[1]] != undefined) {
                    window[matches[1]](event, elem, matches[2].split(','));
                }
            }
        }
    };

    var bindElement = function (elem, bindString) {

        var bind = matchEvent(bindString);

        if (bind == null) {
            return;
        }

        if (bind['event'] == 'ready') {
            execActions(null, elem, bind['actions']);
            return bind['return'];
        }
        $(elem).bind(bind['event'], function (event) {
            if (bind['type'] == 'a' && event.target != this) {
                return false;
            } else if (bind['type'] == 'c' && (event.target != this && $(this).has(event.target).length == 0)) {
                return false;
            }
            execActions(event, elem, bind['actions']);
            return bind['return'];
        });
    };

    $(this).each(function() {
        if ($(this).data('bind') != undefined) {
            if ($(this).data('bind').length > 0) {
                var events = $(this).data('bind').split('|');
                $(this).removeData('bind');
                $(this).removeAttr('data-bind');
                for (var i = 0; i < events.length; i++) {
                    bindElement(this, events[i]);
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