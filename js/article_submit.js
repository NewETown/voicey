$(function(){
  function initToolbarBootstrapBindings() {
    var fonts = ['Arial Black', 'Courier', 'Lucida Grande'],
          fontTarget = $('[title=Font]').siblings('.dropdown-menu');
    $.each(fonts, function (idx, fontName) {
        fontTarget.append($('<li><a data-edit="fontName ' + fontName +'" style="font-family:\''+ fontName +'\'">'+fontName + '</a></li>'));
    });

    $('a[title]').tooltip({container:'body'});

    $('.dropdown-menu input').click(function() {return false;})
      .change(function () {$(this).parent('.dropdown-menu').siblings('.dropdown-toggle').dropdown('toggle');})
      .keydown('esc', function () {this.value='';$(this).change();});

    $('[data-role=magic-overlay]').each(function () { 
      var overlay = $(this), target = $(overlay.data('target')); 
      overlay.css('opacity', 0).css('position', 'absolute').offset(target.offset()).width(target.outerWidth()).height(target.outerHeight());
    });

    if ("onwebkitspeechchange"  in document.createElement("input")) {
      var editorOffset = $('#editor').offset();
      $('#voiceBtn').css('position','absolute').offset({top: editorOffset.top, left: editorOffset.left+$('#editor').innerWidth()-35});
    } else {
      $('#voiceBtn').hide();
    }

  };

  function showErrorAlert (reason, detail) {
    var msg='';
    if (reason==='unsupported-file-type') { msg = "Unsupported format " +detail; }
    else {
      console.log("error uploading file", reason, detail);
    }
    $('<div class="alert"> <button type="button" class="close" data-dismiss="alert">&times;</button>'+ 
     '<strong>File upload error</strong> '+msg+' </div>').prependTo('#alerts');
  };
  
  initToolbarBootstrapBindings();

  $('#editor').wysiwyg({ fileUploadError: showErrorAlert} );
    window.prettyPrint && prettyPrint();
});

function UpdateMinorCategoryList() {
  var major = $('#majorCategory').val();
  var elems = $(major+' > li');
  var minor = $('#minorCategory');
  minor.empty();
  $.each(elems, function() {
    //console.log($(this).text());
    minor.append($('<option />').val('#'+$(this).text()).text('#'+$(this).text()));
  });
};

// Load major categories:
$(function() {
  var categories = $('a.dropdown-toggle[href*=#]');
  var major = $('#majorCategory');
  $.each(categories, function() {
    //console.log($(this).text());
    major.append($('<option />').val('#'+$(this).text()).text('#'+$(this).text()));
  });
  UpdateMinorCategoryList();
});

$('#majorCategory').change(function () {
  UpdateMinorCategoryList();
});

$('input#Title').maxlength({
    threshold: 20
});

$('input#CustomTag').maxlength({
    threshold: 20
});

$('#submit').click(function() {
  console.log("Submit clicked");
  var title = $("#Title").val().trim();
  var content = $("#editor").text().trim();
  var primary = $("#majorCategory").val().replace('#','');
  var secondary = $("#minorCategory").val().replace('#','');
  var extra = $("#CustomTag").val().replace('#','');

  console.log(primary);
  console.log(secondary);
  console.log(extra);

  FB.api('/me', function(response) {
    var fbid = response.id;
    var url = 'php/article_submit.php?title='+title+'&content='+content+'&major_category='+primary+'&minor_category='+secondary+'&extra_category='+extra+'&fbid='+fbid;
    $.post(url, function(response) {
        // POST callback
        // console.log("POST callback arrived: " + response);

        window.location.replace(response);
    });
  });
});