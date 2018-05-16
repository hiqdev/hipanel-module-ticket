(function ($, window, document, undefined) {
    var pluginName = "threadChecker",
        defaults = {
            'queryInterval': 30*1000,
            'threadId': undefined,
            'lastAnswerId': undefined,
            'ajax': {}
        };

    function Plugin(element, options) {
        this.element = $(element);
        this.settings = $.extend({}, defaults, options);
        this._defaults = defaults;
        this._name = pluginName;
        this.intervalId = null;
        this.init();
    }

    Plugin.prototype = {
        init: function () {
            this.bindListeners();
        },
        bindListeners: function () {
            var _this = this;
            var interval = this.settings.queryInterval;

            this.intervalId = Visibility.every(interval, 5 * interval, function () {
                if (window.Pace !== undefined) {
                    Pace.ignore(_this.query.bind(_this));
                } else {
                    _this.query();
                }
            });
        },
        query: function () {
            var _this = this;

            $.ajax($.extend({}, {
                type: 'GET',
                dataType: 'json',
                data: this.prepareQueryData(),
                success: this.processQuery.bind(this),
                statusCode: {
                    403: function () {
                        // Once '403 Forbidden' response received,
                        // user is deauthenticated. Stop flooding server.
                        clearInterval(_this.intervalId);
                    }
                }
            }, this.settings.ajax));
        },
        prepareQueryData: function () {
            return {
                id: this.settings.threadId,
                answer_id: this.settings.lastAnswerId
            };
        },
        processQuery: function (data) {
            if (data.html) {
                this.element.html(data.html);
            }
        }
    };

    $.fn[pluginName] = function (options) {
        this.each(function () {
            if (!$.data(this, 'plugin_' + pluginName)) {
                $.data(this, 'plugin_' + pluginName, new Plugin(this, options));
            }
        });
        return this;
    };
})(jQuery, window, document);
