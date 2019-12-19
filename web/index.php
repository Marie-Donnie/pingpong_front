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

        var button = jQuery('#postIP');
        var ipdiv = jQuery('#ip_data');

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
          })
        });



      });
    </script>
    <div class="jumbotron">
      <h1 class="display-4">Projet Pingpong</h1>
      <hr class="my-4">
      <p class="lead">Cliquez le bouton pour partager votre addresse IP avec nous.</p>
      <button class="btn btn-primary btn-lg mb-3" id="postIP">Partager mon ip</button>
      <p class="lead">Cliquez le bouton pour télécharger le client python afin de lancer des requêtes traceroutes. Lors du complétion du téléchargement, veuillez unzipper le programme, et executer le ficher éxécutable dans le dossier. Lorsque son éxécution est terminée, vous pouvez supprimer le téléchargement. Merci pour votre participation ! </p>
      <a href="p/" download="Interface" class="btn btn-dark btn-lg">Télécharger client </a>
    </div>
  </body>
</html>
