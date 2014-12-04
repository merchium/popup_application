(function(window, $) 
{
    var Popup = {};
    Popup.getShopDomain = function(name)
    {
        return MerchiumApp.getShopDomain().split('/')[0];
    };

    Popup.getShopPath = function(name)
    {
        var domain = MerchiumApp.getShopDomain()
        return domain.replace(domain.split('/')[0], '');
    };

    Popup.getShopBaseDomain = function(name)
    {
        return MerchiumApp.getShopBaseDomain().split('/')[0];
    };

    Popup.getShopBasePath = function(name)
    {
        var domain = MerchiumApp.getShopBaseDomain()
        return domain.replace(domain.split('/')[0], '');
    };

    Popup.getCookie = function(name)
    {
        var matches = document.cookie.match(new RegExp("(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"));
        return matches ? decodeURIComponent(matches[1]) : undefined;
    };

    Popup.setCookie = function(name, value, props)
    {
        props = props || {};
        var exp = props.expires;
        if (typeof exp == 'number' && exp) {
            var d = new Date();
            d.setTime(d.getTime() + exp * 1000);
            exp = props.expires = d;
        }

        if (exp && exp.toUTCString) {
            props.expires = exp.toUTCString();
        }

        value = encodeURIComponent(value);
        var updatedCookie = name + '=' + value;
        for(var propName in props) {
            updatedCookie += '; ' + propName;
            var propValue = props[propName];
            if (propValue !== true) {
                updatedCookie += '=' + propValue;
            }
        }

        document.cookie = updatedCookie;
    };
 
    $(document).ready(function()
    {
        if (Popup.getCookie('popup_displayed') != 'Y') {
            $.getJSON('http://example.com/popup_app/data.php?callback=?', { shop_domain: Popup.getShopBaseDomain() + Popup.getShopBasePath() }, function(data) {
                if (data.title && data.body) {
                    $.ceNotification('show', {
                        type: 'I',
                        title: data.title,
                        message: '<div style="margin: 0 20px 0 20px;">' + data.body + '</div>',
                        message_state: 'S'
                    }, 'popupmodal');
                }
            });

            Popup.setCookie('popup_displayed', 'Y', {expires: /*20*/1209600, path: Popup.getShopPath(), domain: Popup.getShopDomain()});
        }
    });
})(window, $);