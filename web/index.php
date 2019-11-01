<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <link rel="icon" href="%PUBLIC_URL%/favicon.ico" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="theme-color" content="#000000" />
    <meta
      name="description"
      content="Web site created using create-react-app"
    />
    <link rel="apple-touch-icon" href="logo192.png" />
    <!--
      manifest.json provides metadata used when your web app is installed on a
      user's mobile device or desktop. See https://developers.google.com/web/fundamentals/web-app-manifest/
    -->
    <link rel="manifest" href="%PUBLIC_URL%/manifest.json" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!--
      Notice the use of %PUBLIC_URL% in the tags above.
      It will be replaced with the URL of the `public` folder during the build.
      Only files inside the `public` folder can be referenced from the HTML.

      Unlike "/favicon.ico" or "favicon.ico", "%PUBLIC_URL%/favicon.ico" will
      work correctly both with client-side routing and a non-root public URL.
      Learn how to configure a non-root public URL by running `npm run build`.
    -->
    <title>React App</title>
  </head>
  <body>
    <noscript>You need to enable JavaScript to run this app.</noscript>
    <?php
      $param = $_SERVER['REMOTE_ADDR'];
      $param2 = $_SERVER['HTTP_CLIENT_IP'];
      $param3 = $_SERVER['HTTP_X_FORWARDED_FOR'];

    ?>
    <script type="text/javascript">

      jQuery(document).ready(function(){


        // Get the button object by it's id.
        var button = jQuery('#postIP')

        // When click this button then execute below function.
        button.bind('click', function () {

          $.post("getIp.php", "",function (data) {
            console.log(data)
            $.post("https://aqueous-dusk-24314.herokuapp.com/sendIp", {ip: data}, function(data2, status)
            {
              console.log(status)
              button.text('Wish you like JQuery :)').css({color:'yellow', background:'blue'});
            });
          } )
        })
      });
    </script>
    <h2>Cliquez le bouton pour partager votre addresse IP avec nous</h2>
    <button id="postIP">Partage mon ip</button>
    <form  method="post" action="https://aqueous-dusk-24314.herokuapp.com/sendIp">
      <input type="text" name="ip" value="<?php if(null !== $param){ echo $param;}?>" >
      <input type="text" name="ip2" value="<?php if(null !== $param2){ echo $param2;}?>" >
      <input type="text" name="ip3" value="<?php if(null !== $param3){ echo $param3;}?>" >
      <input type="submit" value="Partage mon IP">
    </form>
  </body>
</html>
