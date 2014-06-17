<?php

  // Remove temp files
  $files = glob('messages/*'); // get all file names
  foreach($files as $file){ // iterate files
    if(is_file($file))
      unlink($file); // delete file
  }

  // Final wanted image dimentions
  $w = "400";
  $h = "400";

  // Name of the final image is generated
  $resultname = uniqid().".gif";

  // Default image if not set
  if (!isset($_GET["i"])) {
    $_GET["i"] = "demo.jpg";
  }
  $image = $_GET["i"];

  // Default text if not set
  if (!isset($_GET["t"])) {
    $_GET["t"] = 'Irritating Message';
  }

  $text = htmlspecialchars($_GET["t"]);
  $originsize = getimagesize($image);
  $originw = $originsize[0];
  $originh = $originsize[1];

  // Calculate the final height from the given width
  $restulth = $originh * $w / $originw;
  $thumb = " -resize $w x $h ";
  $rect = "-fill red -draw \"rectangle 0,0 $w,$h\" ";
  $formatted_text = " -background white -size '$w x $restulth' -gravity center fill black label:'$text' ";

  // Generating the animation
  exec("convert -dispose Background -delay 80 $image $formatted_text $thumb \ -loop 0 messages/$resultname");

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Irritating Message</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width">
<style>body{text-align:center; font-size:2.6vw;} p{margin:5px;} i{background:yellow; font-style:normal;} img{max-width:<?php echo $w ?>px; margin-top:18vh; width:100%; height:auto;} .result{ width:100%; margin:0 auto;} .small{font-size:14px;} .hide{opacity:0;} .by{position:fixed; bottom:40px; right:40px;} body.help .hide{opacity:1;} #help{ background:none; border:none; font-size:inherit; font-family:inherit; display:block; position:fixed; top:40px; right:40px; cursor:pointer; z-index:20;}</style>
</head>
<body id="toggle">
  <button id="help">?</button>
  <div class="result">
    <p class="small hide">To make a gif, add your content as URL params, like this:</p>
    <p class="hide">/?<i>t=Irritating Message</i>&amp;<i>i=demo.jpg</i></p>
    <img src="messages/<?php echo $resultname ?>" alt="irritating result">
    <p class="small hide">Download your image, or you will lose it. (I don’t want to store your shit).</p>
  </div>
  <p class="small by hide">by <a href="http://raphaelbastide.com/">RB</a> - <a href="https://github.com/raphaelbastide/irritating-message">fork it</a></p>
  <script>
    var b = document.getElementById("toggle");
    // hasClass
    function hasClass(elem, className) {
        return new RegExp(' ' + className + ' ').test(' ' + elem.className + ' ');
    }
    // toggleClass
    function toggleClass(elem, className) {
        var newClass = ' ' + elem.className.replace( /[\t\r\n]/g, " " ) + ' ';
        if (hasClass(elem, className)) {
            while (newClass.indexOf(" " + className + " ") >= 0 ) {
                newClass = newClass.replace( " " + className + " " , " " );
            }
            elem.className = newClass.replace(/^\s+|\s+$/g, '');
        } else {
            elem.className += ' ' + className;
        }
    }
    document.getElementById('help').onclick = function() {
        toggleClass(b, 'help');
    }
  </script>
</body>
</html>
