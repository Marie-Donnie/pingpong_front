<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="theme-color" content="#000000" />
    <meta
      name="description"
      content="website to collect public ip addresses"
    />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <title>PingPong</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="./index.css">
  </head>
  <body>
    <noscript>You need to enable JavaScript to run this app.</noscript>
    <script type="text/javascript">
      jQuery(document).ready(function(){

        // Get the button object by it's id.
        var button = jQuery('#postIP')
        var ipdiv = jQuery('#ip_data');

        // When click this button then execute below function.
        button.bind('click', function () {
          jQuery.post("getIp.php", "",function (data) {
            console.log(data)
            jQuery.post("https://aqueous-dusk-24314.herokuapp.com/ip/add", {ip: data}, function(resp, status)
            {
            console.log(resp, status)
             if (resp && (status === "success")) {
                ipdiv.append("<tr><td>" + resp.address + "</td><td>" + resp.latitude + "</td><td>" + resp.longitude + "</td></tr>");
             }
            });
          } )
        });
      });
    </script>
    <div class="jumbotron">
      <h1 class="display-4">Partagez votre IP</h1>
      <p class="lead">Cliquez le bouton pour partager votre addresse IP avec nous.</p>
      <hr class="my-4">
      <button class="btn btn-primary btn-lg" id="postIP">Partage mon ip</button>
    </div>
  </body>
</html>
