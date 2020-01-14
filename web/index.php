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
        var shellButton = jQuery('#shell_button');
        var consentBox = jQuery('#consent');

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
        consentBox.bind('click', function() {
            if (consentBox.checked) {
                shellButton.removeClass("disabled");
            } else {
                shellButton.addClass("disabled");
            }
        });
      });
    </script>
    <div class="jumbotron">
      <h1 class="display-4">Projet Pingpong</h1>
      <hr class="my-4">
      <p class="lead">Cliquez le bouton pour partager votre addresse IP avec nous.</p>
      <button class="btn btn-primary btn-lg mb-3" id="postIP">Partager mon ip</button>
      <br/>
      <div class="consent-div">
        <input type="checkbox" class="form-check-input" id="consent">
        <label class="form-check-label" for="exampleCheck1">Je consente de télécharger ce fichier shell et l'éxecuter dans le terminal.</label>
      </div>
      <p class="lead">Dans le terminal, veuillez naviguer dans le dossier où le fichier pingpong.sh est localisé. Executez le command suivant:</p>
      <p class="lead">bash pingpong.sh</p>
      <p class="lead">et laissez le processus terminer. Ça peut prendre quelques minutes.</p>
      <a href="pingpong.sh" id="shell_button" download class="btn btn-dark btn-lg disabled">Télécharger fichier shell</a>
    </div>
    <style>
        .map {
          width: 100%;
          height:500px;
        }
      </style>
      <div id="map" class="map"></div>
    <script>
      // Initialize and add the map
      function initMap() {
        var france = {lat: 48.8556, lng: 2.3522};
        var map = new google.maps.Map(
                document.getElementById('map'), {zoom: 6, center: france});
        // var marker = new google.maps.Marker({position: f, map: map});
        $.get('https://aqueous-dusk-24314.herokuapp.com/ip/all', function(data, status){
          data.map((ip) => {
            let ping = {lat: parseFloat(ip.latitude), lng: parseFloat(ip.longitude)};
            let title = "ISP: " + ip.isp;
            let marker = new google.maps.Marker({position: ping, map: map,title: title, label: "U"})
          });
        });

        $.get('https://aqueous-dusk-24314.herokuapp.com/ip/intermediate/all', function(data, status){
          data.map((ip) => {
            let ping = {lat: parseFloat(ip.latitude), lng: parseFloat(ip.longitude)};
            let title = "ISP: " + ip.isp;
            let marker = new google.maps.Marker({position: ping, map: map,title: title, icon: {
                url: "http://maps.google.com/mapfiles/ms/icons/blue-dot.png"}})
          });
        });

        $.get('https://aqueous-dusk-24314.herokuapp.com/traceroute/all', function(data, status){
          let dataJson = JSON.parse(data)
          dataJson.map((pingDat) => {
              let src = pingDat.src.properties;
              let target = pingDat.target.properties;
              let ping = [{lat: parseFloat(src.latitude),
                lng: parseFloat(src.longitude)},
                {lat: parseFloat(target.latitude), lng: parseFloat(target.longitude)}];
              let lineSymbol = {
                path: google.maps.SymbolPath.FORWARD_OPEN_ARROW
              };
              let pingPath = new google.maps.Polyline({
                path: ping,
                geodesic: true,
                strokeColor: '#FF0000',
                strokeOpacity: 1.0,
                strokeWeight: 2,
                icons: [{
                  icon: lineSymbol,
                  offset: '100%'
                }],
              });
              pingPath.setMap(map)
          });
        });

      }
    </script>
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDrm6a-zK_Yog2qR98gNfq10QNITvfdaPg&callback=initMap">
    </script>
  </body>
</html>
