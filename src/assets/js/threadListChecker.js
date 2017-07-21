(function ($, window, document, undefined) {
    var pluginName = "threadListChecker",
        defaults = {
            'queryInterval': 30 * 1000,
            'pjaxSelector': ''
        };

    function Plugin(element, options) {
        this.element = $(element);
        this.settings = $.extend({}, defaults, options);
        this._defaults = defaults;
        this._name = pluginName;
        this.intervalId = null;
        this.isPaused = false;
        this.init();
    }

    Plugin.prototype = {
        init: function () {
            this.bindListeners();
        },
        bindListeners: function () {
            this.registerTimer();

            // Kartik widgets trigger `change` event on initialization.
            // The entire page initialization takes up to 500 ms
            // Delay registerInputListeners by 1000 ms to be sure
            setTimeout(function () {
                this.registerInputListeners();
            }.bind(this), 1000);
        },
        registerInputListeners: function () {
            $(this.settings.pjaxSelector).find('input')
                .on('change ifChecked', function (e) {
                    this.deleteTimer();
                    return true;
                }.bind(this))
                .on('focus', function (e) {
                    this.pauseTimer();
                    return true;
                }.bind(this))
                .on('blur', function (e) {
                    this.resumeTimer();
                    return true;
                }.bind(this));
        },
        registerTimer: function () {
            if (this.intervalId !== null) {
                return;
            }

            var interval = this.settings.queryInterval;

            this.intervalId = Visibility.every(interval, 3 * interval, function () {
                if (window.Pace !== undefined) {
                    Pace.ignore(this.query.bind(this));
                } else {
                    this.query();
                }
            }.bind(this));
        },
        deleteTimer: function () {
            if (this.intervalId === null) {
                return;
            }

            Visibility.stop(this.intervalId);
        },
        pauseTimer: function () {
            if (this.isPaused === true) {
                return;
            }

            this.isPaused = true;
        },
        resumeTimer: function () {
            if (this.isPaused === false) {
                return;
            }

            this.isPaused = false;
        },
        query: function () {
            if (this.isPaused) {
                return;
            }

            this.deleteTimer();
            $.pjax.reload(this.settings.pjaxSelector);
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
