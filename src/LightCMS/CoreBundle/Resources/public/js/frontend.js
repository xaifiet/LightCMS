paddingNavigation = function(event, elem, params) {
    var nav = $('nav');
    var navHeight = $(nav).height();
    $('body').css('padding-top', navHeight+'px');
};