define([
    'jquery',
    'jquery/ui',
    'underscore',
    'mage/template'
], function($, _, mageTemplate){
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
            let listLength = this.options.length,
                listData = this.options,
                titleOutput = mageTemplate.template('<span class="blog-list-title">' +
                    '<%- title %></span><ul></ul>');

            $(this.element).append(titleOutput({title: this.options.title}));

            for (let i = 0; i < listLength; i++){
                let listOutput = mageTemplate.template('<li><a href="<%- listData.url %>">' +
                    '<%= listData.theme %></a></li>');

                $('ul', this.element).append(listOutput({listData: listData[i]}));
            }
        }
    });

    return $.mage.blogList;
});
