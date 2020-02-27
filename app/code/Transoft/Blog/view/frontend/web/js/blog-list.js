define([
    'jquery',
    'underscore',
    'text!Transoft_Blog/template/blogList.html'
], function($, _, blogListTemplate){
    $.widget('mage.blogList', {
        options: {
            title: 'title'
        },
        /**
         * Widget initialization
         * @private
         */
        _create: function() {
            this.renderList();
        },

        /**
         * Creates list inside parent container
         */
        renderList: function () {
            let template = _.template(blogListTemplate);
            $(this.element).html(template({listData: this.options}));
        }
    });

    return $.mage.blogList;
});
