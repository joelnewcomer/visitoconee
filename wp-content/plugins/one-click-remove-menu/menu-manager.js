'use strict';

(function ($) {
    var Menu_Manager = Backbone.View.extend({
        el: '#menu-to-edit',

        removable_item: false,

        events: {
            'click .item-controls': 'onClickControls'
        },

        onClickControls: function (e) {
            if (e.offsetX >= 0) {
                return;
            }

            if (!this.removable_item) {
                var r = confirm(one_click_rm.confirm);
                if (!r) {
                    return;
                }
            }

            this.removable_item = true;

            var $current = this.$(e.currentTarget);
            var $menu_item = $current.closest('.menu-item');
            var $delete_item = $menu_item.find('.item-delete');
            if ($delete_item) {
                $delete_item.click();
            }
        }
    });


    $(document).ready(function () {
        new Menu_Manager();
    });
})(jQuery);