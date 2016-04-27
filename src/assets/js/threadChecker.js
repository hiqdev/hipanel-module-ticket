(function ($, window, document, undefined) {
    var pluginName = "threadChecker",
        defaults = {
            'queryInterval': 15*1000,
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

            $(window).on('blur focus', function(e) {
                var prevType = $(this).data('prevType');

                if (prevType != e.type) {
                    switch (e.type) {
                        case 'blur':
                            _this.startQuerier();
                            break;
                        case 'focus':
                            _this.stopQuerier();
                            break;
                    }
                }

                $(this).data('prevType', e.type);
            });

            this.startQuerier();
        },
        startQuerier: function () {
            var _this = this;
            this.intervalId = setInterval(function () {
                if (window.Pace !== undefined) {
                    Pace.ignore(_this.query.bind(_this));
                } else {
                    _this.query();
                }
            }, this.settings.queryInterval);
            return this;
        },
        stopQuerier: function () {
            if (this.intervalId !== null) {
                window.clearInterval(this.invervalId);
            }
        },
        query: function () {
            $.ajax($.extend({}, {
                type: 'GET',
                dataType: 'json',
                data: this.prepareQueryData(),
                success: this.processQuery.bind(this)
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
