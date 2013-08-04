$( document ).ready(function($) {

  loadPlaceholders();
  var colWid = Math.floor($('#article_display').width() *.25);
  var $article_display = $('#article_display');
  $('#article_display').imagesLoaded(function() {
    $article_display.masonry({
      columnWidth: colWid,
      itemSelector: '.article',
      isAnimated: !Modernizr.csstransitions
    });
  });

  $article_display.infinitescroll({
    navSelector  : '#page_nav',    // selector for the paged navigation
    nextSelector : '#page_nav a',  // selector for the NEXT link (to page 2)
    itemSelector : '.article',     // selector for all items you'll retrieve
    maxPage: 3,
    loading: {
      msgText: "Loading the next set of posts...",
      finishedMsg: 'No more pages to load.',
      img: 'http://i.imgur.com/6RMhx.gif'
      }
    },
    // trigger Masonry as a callback
    function( newElements ) {
      // hide new items while they are loading
      var $newElems = $( newElements ).css({ opacity: 0 });
      // ensure that images load before adding to masonry layout
      $newElems.imagesLoaded(function(){
        // show elems now they're ready
        $newElems.animate({ opacity: 1 });
        $article_display.masonry( 'appended', $newElems, true );
      });
    }
  );
});

function loadPlaceholders() {
  var idx = 0;
  var size = "";
  var pxSize = Math.floor($('#article_display').width() * .25);
  var pxHeight = 0;
  var t_height = 0;
  var el = null;
  for(var i = 0; i < 15; i++) {
    idx = Math.random() * 6;
    if (idx < 3) {
      pxHeight = Math.floor($('#article_display').width() * .2);
      size = "reg";
    } else {
      pxHeight = Math.floor($('#article_display').width() * .4);
      size = "featured";
    }
    el = '<div class="article '+size+'"><img src=http://placehold.it/'+pxSize+'x'+pxHeight+'></div>';
    $('#article_display').append(el);
  }
}