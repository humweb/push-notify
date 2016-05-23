/*
 * jQuery PushMenu plugin v1.0
 *
 * Copyright 2016, Ryun Shofner <ryun@humboldtweb.com>
 * Dual licensed under the MIT or GPL Version 2 licenses.
 *
 * Depends:
 *	jquery (duh!)
 */
(function (window, $) {

  var PushMenu = function (e, cfg) {
    this.el = e;
    this.$el = $(e);
    this.cfg = cfg || {};
    this.storage = window.localStorage;

    // Try and decode data from local storage
    // If none found we default to an empty array
    try {
      this.items = JSON.parse(this.storage.getItem(this.cfg.storageKey));
    } catch (e) {
      this.items = [];
    }

    // Init plugin
    this.init();
  };

  /**
   * Init plugin
   */
  PushMenu.prototype.init = function () {
    this.reload();
    this.registerEvents();
  };

  /**
   * Add item to menu
   *
   * @param {object} payload
   */
  PushMenu.prototype.add = function (payload) {
    // Push item to array
    this.items.push(payload);

    // Update count display
    this.updateCount();

    // Prepend item to menu
    this.$el.prepend(this.template(payload));

    // Persist data to storage
    return this.persist();
  };

  /**
   * Remove item from menu
   *
   * @param {int} index
   */
  PushMenu.prototype.remove = function (index) {
    // Remove item from array
    this.items.splice(index, 1);

    // Reload menu
    this.reload();

    // Persist data to storage
    return this.persist();
  };


  /**
   * Reload menu
   */
  PushMenu.prototype.reload = function () {
    var str = '';
    for (var len = this.items.length - 1; len >= 0; len--) {
      str += this.template(this.items[len]);
    }

    // Update count when we update menu to ensure our count stays in sync
    this.updateCount();

    // Render menu items
    this.$el.html(str);
  };

  /**
   * Count menu items
   *
   * @returns {Number}
   */
  PushMenu.prototype.count = function () {
    return this.items.length;
  };

  /**
   * Update menu count display
   */
  PushMenu.prototype.updateCount = function () {
    if (this.cfg.countEl) {
      $(this.cfg.countEl).html(this.count());
    }
  };

  /**
   * Get menu item template
   *
   * @param {object} data
   * @returns {string}
   */
  PushMenu.prototype.template = function (data) {
    return this.cfg.template(data);
  };

  /**
   * Persist menu to local storage
   *
   * @returns {PushMenu}
   */
  PushMenu.prototype.persist = function () {
    this.storage.setItem(this.cfg.storageKey, JSON.stringify(this.items));
    return this;
  };

  /**
   * Register plugin events
   */
  PushMenu.prototype.registerEvents = function () {
    var self = this;

    // Register custom events
    this.$el.on('pushmenu.add', function (e, item) {
      self.add(item);
    }).on('pushmenu.remove', function (e, index) {
      self.remove(index);
    }).on('pushmenu.reload', function (e, index) {
      self.reload();
    })


    // Register menu item events
    this.$el.on('click', '.item-remove', function (e) {
      e.preventDefault();
      e.stopPropagation();
      self.remove(self.$el.find('.notification-item').index(this));
    }).on('click', '.notification-title', function (e) {
      e.preventDefault();
      e.stopPropagation();
      $(this).next('.notification-details').slideToggle('fast');
    })
  };


  /**
   * pushMenu (jquery plugin)
   *
   * @param option
   * @returns {*}
   */
  $.fn.pushMenu = function (option) {
    return this.each(function () {
      var $this = $(this)
      , data = $this.data('pushMenu')
      , options = $.extend({}, $.fn.pushMenu.defaults, $this.data(), typeof option == 'object' && option);
      if (!data) $this.data('pushMenu', (data = new PushMenu(this, options)));
      if (typeof option == 'string') {
        data[option].apply(this, Array.prototype.slice.call(arguments));
      }
    })
  };

  /**
   * Default pushMenu config
   *
   * @type {{countEl: boolean, storageKey: string, template: $.fn.pushMenu.defaults.template}}
   */
  $.fn.pushMenu.defaults = {
    countEl: false,
    storageKey: '_pushMenuItems',
    template: function (data) {
      return '<li class="notification-item">' +
      '<div class="item">' +
      '<b class="notification-title">' +
      data.title +
      '</b>' +
      '<div class="notification-details">' + data.body + '</div>' +
      '<button class="item-remove btn btn-xs btn-default"><i class="fa fa-trash"></i></button>' +
      '</div></li>';
    }
  };

})(window, jQuery);