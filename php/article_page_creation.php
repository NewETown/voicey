<?php

	// Here we'll create a portion of the page that displays articles
	// The file will export the HTML and then redirect the user to the article that they just posted

	class ArticleCreation {
	 	

	    public function GenerateHTML($title, $content, $tags=array("life", "success", "noyolo")) {

	    	$opener = "<!DOCTYPE html>\n<html lang=\"en\">\n\t<head>\n\t\t<meta charset=\"utf-8\">\n\t\t<title>Voice-Y | Make your voice heard.</title>\n\t\t<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">\n\t\t<meta name=\"description\" content=\"\">\n\t\t<meta name=\"author\" content=\"\">";
		 	$styles = "\n\t\t<link rel=\"stylesheet\" href=\"http://localhost/voicey/font-awesome/css/font-awesome.min.css\">\n\t\t<link href=\"http://localhost/voicey/css/bootstrap.css\" rel=\"stylesheet\">\n\t\t<link href=\"http://localhost/voicey/css/bootstrap-responsive.css\" rel=\"stylesheet\">\n\t\t<link href=\"http://localhost/voicey/css/social-buttons.css\" rel=\"stylesheet\">";
		 	$favAndTouchIco = "\n\t\t<link rel=\"apple-touch-icon-precomposed\" sizes=\"144x144\" href=\"../assets/ico/apple-touch-icon-144-precomposed.png\">\n\t\t<link rel=\"apple-touch-icon-precomposed\" sizes=\"114x114\" href=\"../assets/ico/apple-touch-icon-114-precomposed.png\">\n\t\t<link rel=\"apple-touch-icon-precomposed\" sizes=\"72x72\" href=\"../assets/ico/apple-touch-icon-72-precomposed.png\">\n\t\t\t<link rel=\"apple-touch-icon-precomposed\" href=\"../assets/ico/apple-touch-icon-57-precomposed.png\">\n\t\t\t\t<link rel=\"shortcut icon\" href=\"../assets/ico/favicon.png\">";
		 	$postHead = "\n\t</head>";
		 	$bodyOpen = "\n\t<body>\n\t\t<div class=\"container-full\">\n\t\t\t<div id=\"fb-root\"></div>\n\t\t\t\t<header id=\"head\" class=\"headerRow top-header\">\n\t\t\t\t</header>\n\t\t\t\t<nav id=\"top-nav\" class=\"navbar navbar-inverse\">\n\t\t\t\t</nav>\n\t\t\t\t<div class=\"container col-wrap\">\n\t\t\t\t\t<div class=\"row-fluid\">\n\t\t\t\t\t\t<div class=\"span9\">\n\t\t\t\t\t\t\t<div id=\"content-well\" class=\"well well-centered\">";
		    $bodyEnd = "\n\t\t\t\t\t\t</div> <!-- End article container -->\n\t\t\t\t\t</div>\n\t\t\t\t\t<div class=\"well-centered well span3\">\n\t\t\t\t\t\t<p>Scrolling content window</p>\n\t\t\t\t\t</div>\n\t\t\t\t</div>\n\t\t\t</div>\n\t\t\t<hr>\n\t\t\t<footer>\n\t\t\t\t<p>&copy; Mental Tangent, ltd. 2013</p>\n\t\t\t</footer>\n\t\t</div>";
		    $js = "\n\t\t<script src=\"http://code.jquery.com/jquery-latest.min.js\"></script>\n\t\t<script src=\"http://localhost/voicey/js/bootstrap-transition.js\"></script>\n\t\t<script src=\"http://localhost/voicey/js/bootstrap-alert.js\"></script>\n\t\t<script src=\"http://localhost/voicey/js/bootstrap-modal.js\"></script>\n\t\t<script src=\"http://localhost/voicey/js/bootstrap-dropdown.js\"></script>\n\t\t<script src=\"http://localhost/voicey/js/bootstrap-scrollspy.js\"></script>\n\t\t<script src=\"http://localhost/voicey/js/bootstrap-tab.js\"></script>\n\t\t<script src=\"http://localhost/voicey/js/bootstrap-tooltip.js\"></script>\n\t\t<script src=\"http://localhost/voicey/js/bootstrap-popover.js\"></script>\n\t\t<script src=\"http://localhost/voicey/js/bootstrap-button.js\"></script>\n\t\t<script src=\"http://localhost/voicey/js/bootstrap-collapse.js\"></script>\n\t\t<script src=\"http://localhost/voicey/js/bootstrap-carousel.js\"></script>\n\t\t<script src=\"http://localhost/voicey/js/bootstrap-typeahead.js\"></script>\n\t\t<script src=\"http://localhost/voicey/js/facebook-init.js\"></script>";
			$closer = "\n\t</body>\n</html>";

	    	$fn = str_replace(" ", "_", $title);
	        $fn .= ".html";
	        $filepath = "../pages/$tags[0]";

	        if (!file_exists($filepath)) {
			    mkdir($filepath, 0777, true);
			}

			$filepath .= "/$tags[1]";

			if (!file_exists($filepath)) {
			    mkdir($filepath, 0777, true);
			}

			$url = "http://localhost/voicey/pages/$tags[0]/$tags[1]/$fn";

	        // We're going to inject the article HTML here:
	        // Ideally we'll get the HTML pre-formatted from the submit page... let's see if we can do that:
	        $articleTitle = "\n\t\t\t\t\t\t\t\t<div class=\"row-fluid\">\n\t\t\t\t\t\t\t\t\t<div class=\"article-title span12\">\n\t\t\t\t\t\t\t\t\t\t<h2>$title</h2>\n\t\t\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t\t</div>";
	        $articleContent = "\n\t\t\t\t\t\t\t\t<div class=\"row-fluid\">\n\t\t\t\t\t\t\t\t\t<div class=\"article-content span12\">\n\t\t\t\t\t\t\t\t\t\t$content\n\t\t\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t\t</div>";
	        $articleTagsAndLikes = "\n\t\t\t\t\t\t\t\t<div class=\"row-fluid\">\n\t\t\t\t\t\t\t\t\t<div class=\"article-tags span12\">\n\t\t\t\t\t\t\t\t\t\t<p>#$tags[0], #$tags[1], #$tags[2]</p>\n\t\t\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t\t\t<div class=\"article-likes offset3 span3\">\n\t\t\t\t\t\t\t\t\t\t<div class=\"fb-like\" data-href=\"$url\" data-width=\"450\" data-layout=\"button_count\" data-action=\"recommend\" data-show-faces=\"true\" data-send=\"true\"></div>\n\t\t\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t\t</div>";
	        $commentsSection = "\n\t\t\t\t\t\t\t\t<div class=\"row-fluid\">\n\t\t\t\t\t\t\t\t\t<div class=\"article-title span12\">\n\t\t\t\t\t\t\t\t\t\t<div class=\"fb-comments\" data-href=\"$url\" data-width=\"470\"></div>\n\t\t\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t\t</div>";
	        $contentCloser = "\n\t\t\t\t\t</div>\n\t\t\t\t</div>";

	        $html = $opener . $styles . $favAndTouchIco . $postHead . $bodyOpen . $articleTitle . $articleContent . $articleTagsAndLikes . $commentsSection . $bodyEnd . $js . $closer;

			$file = fopen("$filepath/$fn", 'w');
			if( $file == false )
			{
				echo ( "Error in opening new file" );
				exit();
			}

			fwrite( $file, $html );
			fclose( $file );

			return $url;
	    }

	    function SaveHTMLFile($html, $filepath, $fn) {
	    	// Check to see if the directory exists
	    	if (!file_exists($filepath)) {
			    mkdir($filepath, 0777, true);
			}

			$file = fopen($filepath."/".$fn, 'w');
			if( $file == false )
			{
				echo ( "Error in opening new file" );
				exit();
			}

			fwrite( $file, $html );
			fclose( $file );
			echo "url!http://localhost/voicey/".$filepath.$fn;
	    }
	}

?>

