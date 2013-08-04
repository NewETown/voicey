$( document ).ready(function($) {
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '201931593302996', // App ID
      channelUrl : 'www.voice-y.com/channel.html', // Channel File
      status     : true, // check login status
      cookie     : true, // enable cookies to allow the server to access the session
      xfbml      : true  // parse XFBML
    });

    // Here we subscribe to the auth.authResponseChange JavaScript event. This event is fired
    // for any authentication related change, such as login, logout or session refresh. This means that
    // whenever someone who was previously logged out tries to log in again, the correct case below 
    // will be handled. 
    FB.Event.subscribe('auth.authResponseChange', function(response) {
      // Here we specify what we do with the response anytime this event occurs. 
      if (response.status === 'connected') {
        // The response object is returned with a status field that lets the app know the current
        // login status of the person. In this case, we're handling the situation where they 
        // have logged in to the app.
        
        userID = response.authResponse.userID;
        
        $('#logout').on('click', function () { 
          FB.logout(function (response) {console.log("Logged out");}) 
        });
        $('#loginArea').hide();
        $('#postLogin').show();
        $('#fbPic').attr('src', 'https://graph.facebook.com/'+userID+'/picture?type=small');
        $('.social-media-btn').css('margin-top', '.75em');
        //printInfo(response);

        FB.api('/me', function(response) {
          firstName = response.first_name;
          lastName = response.last_name;
          email = response.email;
          var url = 'http://localhost/voicey/php/user_handler.php?id='+userID+'&firstName='+firstName+'&lastName='+lastName+'&email='+email;
          // using jQuery to perform AJAX POST.



          $.post(url, function(response) {
              // POST callback
              console.log("POST callback arrived: " + response);
          });
        });

      } else {
        // The user isn't auth'd

        $('#fbLogin').on('click', function () { 
          FB.login( function (response) {
            console.log("Logged in");}, {scope: 'email,user_likes,publish_actions,user_online_presence,access_token'}) 
        });
        $('#postLogin').hide();
        $('#loginArea').show();
      }
    });
  };

  // Load the SDK asynchronously
  (function(d){
   var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
   if (d.getElementById(id)) {return;}
   js = d.createElement('script'); js.id = id; js.async = true;
   js.src = "http://connect.facebook.net/en_US/all.js";
   ref.parentNode.insertBefore(js, ref);
  }(document));

  // load the top  nav, every page loads this Facebook stuff so we're making it all nice and easy here
  $('#head').load('http://localhost/voicey/templates/header_load.html');
  if($('#nav-container').length == 0) {
    console.log("nav-container == 0");
    $('#top-nav').load('http://localhost/voicey/templates/article_categories.html');
  }
});



// Here we run a very simple test of the Graph API after login is successful. 
// This testAPI() function is only called in those cases. 
function testAPI() {
  console.log('Welcome!  Fetching your information.... ');
  FB.api('/me', function(response) {
    console.log('Good to see you, ' + response.name + '.');
    console.log('User ID: ' + response.id);
  });

  FB.api('/me/permissions', function (response) {
    console.log("Permissions");
    console.log(response.data[0]);
  });
};