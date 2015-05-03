<?php
  
  // ASYNC REQUESTS
  // ==============

  if(isset($_POST["action"])){
    $act = $_POST["action"];
    
    switch($act){
      case "edit" :

        $name = $_POST["name"];
  
        $path = "files/".$name;
        if($name == "readme") $path = $name;
        $path .= ".txt";
        
        $data = file_get_contents($path);
        echo $data;

        break;
      case "update" :

        $name = $_POST["name"];
        $data = stripslashes($_POST["data"]);

        $path = "files/".$name;
        if($name == "readme") $path = $name;
        $path .= ".txt";

        if(strlen($data) <= 0){
          if(file_exists($path))  unlink($path);
          echo "deleted";
        }else{
         file_put_contents($path, $data);
         echo $data; 
        }

        break;
    }

    die();
  }
  
?>

<?php

  // PAGE DISPLAY
  // ============

  //find file name in URL
  $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
  
  //if file name is empty (index) use readme file as default
  $url = explode("/", $url);
  $url = $url[count($url)-1];
  if(strlen($url) <= 0) $url = "readme";
  else if($url == "notes") $url = "readme";

  //solve file url
  $name = $url;
  $path = "files/".$name;
  if($name == "readme") $path = $name;
  $path .= ".txt";

  //create a new file if file doesn't exist yet
  if(!file_exists($path)){
    $h = fopen($path,'w');
    fclose($h);
  }

  //gather data
  $data = file_get_contents($path);

  //fill screen with default value if file is empty
  if(strlen($data) <= 0)  $data = "click here to start";
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8"/>
    <style>
      h1:hover:after{
        content:"EDIT";
        line-height: 12px;
        font-size: 12px;
        padding-left:20px;
        cursor:pointer;
        color:#d33;
      }
      #edit{
        display:none;
        position:fixed;
        z-index:200;
        width:700px;
        height:500px;
        left:50%;
        top:50%;
      }
      .navbar{
        cursor:pointer;
      }
    </style>
    <title><?php echo strtoupper($name).".txt"; ?></title>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

    <script>
      var edit;
      var body;

      $(function(){
        assignBind();
      });

      function assignBind(){
        edit = $("#edit");

        $(".navbar").click(function(){
          reboot();
        });

        $("h1,h2,h3").click(function(e){
          $this = $(this);
          //console.log($this);
          
          if($this.lastChild) e.preventDefault();

          //http://stackoverflow.com/questions/14048344/jquery-mouseup-function-on-left-mouse-button-only
          //e.which return diff values ?
          //button 0 left, 1 middle, 2 right
          if (e.button != 0) return false;

          edit.blur(function(){
            updateFile();
          });

          if(edit.is(":visible")){ return; }

          getFile(function(data){
            //console.log("init :: toggle edit");
            edit.val(data);

            var screenWidth = $(window).innerWidth();
            var screenHeight = $(window).innerHeight();
            var width = screenWidth * 0.8;
            var height = screenHeight * 0.8;
            //console.log("window: "+screenWidth+"x"+screenHeight+", reduced: "+width+"x"+height);
            
            edit.css("width", width);
            edit.css("height", height);
            edit.css("margin-left",-width * 0.5);
            edit.css("margin-top",-height * 0.5);
            edit.css("top","50%");
            edit.css("left","50%");
            //console.log(edit);

            edit.fadeIn();
          });
        });

        //$("a").click(function(e){});
        
      };

      function getFile(callback){
        var url = document.URL;
        //console.log(url);
        //if(url.indexOf("?") < 0)  url = "faq";
        url = url.split("/");
        url = url[url.length-1];
        if(url.length <= 0) url = "readme";
        else if(url == "notes") url = "readme";

        document.title = url;

        $.post("index.php",{action:"edit",name:document.title}, function(data){
          callback(data);
        });
      }

      function updateFile(){
        var file = document.title;

        //console.log("[update] file:"+file);
        $.post("index.php",{action:"update",name:file, data:edit.val()}, function(data){
          
          //console.log("   data:\n"+data);

          if(data == "deleted"){
            reboot();
            return;
          }
          
          edit.fadeOut(function(){
            reboot(document.URL);
          });

        });
      }

      function reboot(url){
        if(url == null) url = "./";
        else if(url.length <= 0) url = "./";
        document.location.href = url;
      }
    </script>
  </head>
  <body>
    <textarea id="all" theme="united" style="display:none;"><?php echo $data; ?></textarea>
    <script src="http://strapdownjs.com/v/0.2/strapdown.js"></script>
    <textarea id="edit"></textarea>
  </body>
</html>