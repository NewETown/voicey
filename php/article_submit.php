<?php

    require('dbconn.php');

    $db = new DBConnection();
    $conn = $db->GetConnection();
    $conn->beginTransaction();

    if($conn) {
        echo "\nConnected to database";
    } else  {
        echo "\nNot connected";
    }

    $title = null;
    $content = null;
    $major = null;
    $minor = null;
    $extra = null;
    $fbid = null;
    //$article_id = 01; // Develop a way to track article id

    if(isset($_GET['title'])) {
        $title = $_GET['title'];
        $title = trim($title);
        if($title == '') {
            $title = null;
        }
        echo "\nEchoing title: $title";
    }

    if(isset($_GET['content'])) {
        $content = $_GET['content'];
        $content = trim($content);
        if($content == '') {
            $content = null;
        }
        echo "\nEchoing content: $content";
    }

    if(isset($_GET['major_category'])) {
        $major = $_GET['major_category'];
        echo "\nEchoing major: $major";
    }

    if(isset($_GET['minor_category'])) {
        $minor = $_GET['minor_category'];
        echo "\nEchoing minor: $minor";
    }

    if(isset($_GET['extra_category'])) {
        $extra = $_GET['extra_category'];
        $extra = trim($extra);
        if($extra == '') {
            $extra = null;
        }
        echo "\nEchoing extra: $extra";
    }

    if(isset($_GET['fbid'])) {
        $fbid = $_GET['fbid'];
        echo "\nEchoing fbid: $fbid";
    }

    echo "\nAdding '$title' to database.";
    $sql = "INSERT INTO articles (content, primary_category, secondary_category, extra_category, article_title, FBID) 
                        VALUES (:content, :major_category, :minor_category, :extra_category, :title, :fbid)";
    $ins = $conn->prepare($sql);
    //$ins->bindParam(":FirstName", $FirstName, PDO::PARAM_STR);
    $ins->bindParam(":content", $content);
    $ins->bindParam(":major_category", $major);
    $ins->bindParam(":minor_category", $minor);
    $ins->bindParam(":extra_category", $extra);
    $ins->bindParam(":title", $title);
    $ins->bindParam(":fbid", $fbid);
    if (!$ins) {
        echo "\nPDO::errorInfo():\n";
        print_r($conn->errorInfo());
    }
    $ins->execute();
    $ins->closeCursor();
    $conn->commit();
    
    $conn = null;

    // Now we need to create a link title that we can use to spit out HTML with:
    $title = preg_replace('/\s+/', '_', $title);
    $title = $title.".html";
    echo "\nHTML link name: $title";

    echo "\n***End article_submit***";
?>