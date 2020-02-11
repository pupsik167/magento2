define([
    'jquery',
    'jquery/ui'
], function($){
    $.widget('mage.blogListWidget', {
        options: {
            content: 1,
            title: 'Title'
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
            let listLength = Object.keys(this.options).length - 2, //2 - extra option params to omit
                listData = [];

            $(".blog-list")
                .append(`<span class='blog-list-title'>${this.options.title}</span>`)
                .append('<ul></ul>');

            for (let i = 0; i < listLength; i++){
                let blogData = this.options[`blog${i}`];

                if(blogData){
                    listData = blogData.split(this.options.dataSeparator);

                    let link = `<a href='${listData[1]}'>${listData[0]}</a>`;
                    $(".blog-list ul").append(`<li>${link}</li>`);
                }
            }
        }
    });

    return $.mage.blogListWidget;
});
