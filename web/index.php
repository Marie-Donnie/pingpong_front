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
        var buttonForm = jQuery('#postIPForm');
        var ipdiv = jQuery('#ip_data');
        var shellButton = jQuery('#shell_button');
        var batButton = jQuery('#bat_button');
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

        buttonForm.bind('click', function () {
            let ip = $("#ip_input"). val();
            jQuery.post("https://aqueous-dusk-24314.herokuapp.com/ip/add", {ip: ip}, function(resp, status) {
                 console.log(resp, status)
                 if (resp && (status === "success")) {
                    ipdiv.append("<tr><td>" + resp.address + "</td><td>" + resp.latitude + "</td><td>" + resp.longitude + "</td></tr>");
                 }
            });
          })

        consentBox.bind('click', function() {
            if (consentBox.is(':checked')) {
                shellButton.removeClass("disabled");
                batButton.removeClass("disabled");
            } else {
                shellButton.addClass("disabled");
                batButton.addClass("disabled");
            }
        });
      });
    </script>
    <div class="jumbotron">
      <h1 class="display-4">Projet Pingpong</h1>
      <hr class="my-4">
      <div>
        <div>
          <p class="lead">Cliquez le bouton pour partager votre addresse IP avec nous.</p>
          <button class="btn btn-primary btn-lg mb-3" id="postIP">Partager mon ip</button>
          <br/>
         </div>
        <div class="form-group" id="enter-ip">
           <label for="ip_input">Ou, saisez une addresse IP</label>
           <input name="ip" class="form-control" id="ip_input" value="">
           <button class="btn btn-primary btn-md mb-3" id="postIPForm">Envoyer IP</button>
        </div>
      </div>
      <div class="consent-div">
        <input type="checkbox" class="form-check-input" id="consent">
        <label class="form-check-label" for="exampleCheck1">Je consens de télécharger ce fichier shell/batch et l'éxecuter.</label>
      </div>
      <div class="download-div">
          <h3 class="display-5">Mac/Linux</h3>
          <p class="lead">Dans le terminal, veuillez naviguer dans le dossier où le fichier pingpong.sh est localisé. Executez le command suivant:</p>
          <p class="lead" id="bash-command">bash pingpong.sh</p>
          <p class="lead">et laissez le processus terminer. Ça peut prendre quelques minutes.</p>
          <a href="pingpong.sh" id="shell_button" download class="btn btn-dark btn-lg disabled">Télécharger fichier shell</a>
      </div>
      <div class="download-div">
          <h3 class="display-5">Windows</h3>
          <p class="lead">Double-clickez le fichier téléchargé, et confirmez si demandé de l'éxecuter en tant qu'administrateur. Laissez le processus terminer. Ça peut prendre quelques minutes.</p>
          <a href="pingpong.bat" id="bat_button" download class="btn btn-dark btn-lg disabled">Télécharger fichier batch</a>
      </div>
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
//        $.get('https://aqueous-dusk-24314.herokuapp.com/ip/all/condensed', function(data, status){
//          data.map((dataPoint) => {
//            let ping = {lat: parseFloat(dataPoint.latitude), lng: parseFloat(dataPoint.longitude)};
//            if (dataPoint.type === "USER") {
//               let marker = new google.maps.Marker({position: ping, map: map,title: dataPoint.label, label: "U"})
//            } else {
//                let marker = new google.maps.Marker({position: ping, map: map,title: dataPoint.label, icon: {
//                                url: "http://maps.google.com/mapfiles/ms/icons/blue-dot.png"}})
//            }
//          });
//        });
        let polylines = [];
        $.get('https://aqueous-dusk-24314.herokuapp.com/traceroutes/all/condensed', function(data, status){

              data.map((src) => {
                  let ping = {lat: parseFloat(src.latitude), lng: parseFloat(src.longitude)};
                  let marker = new google.maps.Marker({position: ping, map: map,title: dataPoint.label, label: "U"})

                  marker.addListener('click', function() {
                      polylines.map((pl) => {pl.setMap(null)});
                      src.destinations.map((dest) => {
                          dest.traceroute.map((hop) => {
                              let ping = [{lat: parseFloat(hop.src.latitude),
                                  lng: parseFloat(hop.src.longitude)},
                                  {lat: parseFloat(hop.target.latitude), lng: parseFloat(hop.target.longitude)}];
                              let lineSymbol = {
                                  path: google.maps.SymbolPath.FORWARD_OPEN_ARROW
                              };
                              let pingPath = new google.maps.Polyline({
                                  path: ping,
                                  geodesic: true,
                                  strokeColor: '#FF0000',
                                  strokeOpacity: 1.0,
                                  strokeWeight: 100 * pingDat.frequency,
                                  icons: [{
                                      icon: lineSymbol,
                                      offset: '100%',
                                      scale: 3,
                                      strokeWeight: 3
                                  }],
                              });
                              polylines.push(pingPath);
                              pingPath.setMap(map)
                          })
                      })
                  });
              })
        });

      }
    </script>
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDrm6a-zK_Yog2qR98gNfq10QNITvfdaPg&callback=initMap">
    </script>
  </body>
</html>
