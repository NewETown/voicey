/**
 * Base js functions
 */

$(document).ready(function() {
    //Init jQuery Masonry layout
    init_masonry();
    });
);


function init_masonry(){
    var $container = $('#article_display');

    var gutter = 12;
    var min_width = Math.floor($('#article_display').width() * .33);
    $container.imagesLoaded( function(){
        $container.masonry({
            itemSelector : '.article',
            gutterWidth: gutter,
            isAnimated: true,
              columnWidth: function( containerWidth ) {
                var num_of_boxes = (containerWidth/min_width | 0);

                var box_width = (((containerWidth - (num_of_boxes-1)*gutter)/num_of_boxes) | 0) ;

                if (containerWidth < min_width) {
                    box_width = containerWidth;
                }

                $('.article').width(box_width);

                return box_width;
              }
        });
    });
}
