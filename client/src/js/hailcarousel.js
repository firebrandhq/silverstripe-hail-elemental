jQuery(($) => {
    $('.hail-carousel').each((index, element) => {
        //Build carousel options (from the Hail carousel DataObject)
        var slickOptions = {
            lazyLoad: 'ondemand',
            dots: ($(element).data('showdots') === "Yes"),
            slidesToShow: $(element).data('lg-toshow'),
            slidesToScroll: $(element).data('lg-toscroll'),
            responsive: [
                {
                    breakpoint: $(element).data('md-break'),
                    settings: {
                        slidesToShow: $(element).data('md-toshow'),
                        slidesToScroll: $(element).data('md-toscroll')
                    }
                },
                {
                    breakpoint: $(element).data('sm-break'),
                    settings: {
                        slidesToShow: $(element).data('sm-toshow'),
                        slidesToScroll: $(element).data('sm-toscroll'),
                        arrows: false
                    }
                }
            ]
        };
        //Remove arrows padding in the wrapper for the lowest breakpoint
        var css = "@media (max-width:" + $(element).data('sm-break') + "px) { .hail-carousel-wrapper { padding-left: 0; padding-right: 0; } }",
            head = document.head || document.getElementsByTagName('head')[0],
            style = document.createElement('style');

        style.type = 'text/css';
        if (style.styleSheet) {
            style.styleSheet.cssText = css;
        } else {
            style.appendChild(document.createTextNode(css));
        }

        head.appendChild(style);

        //Create Slick carousel
        $(element).slick(slickOptions);
    });
});
