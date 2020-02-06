perform_tr () {
  IFS=',' # hyphen (-) is set as delimiter
  read -ra ADDR <<< "$str" # str is read into an array as tokens separated by IFS
  counter=0;
  for i in "${ADDR[@]}"; do
     echo "Tracerouting to"
     echo $i
     echo "__BEGIN_" >> pingpong.txt
     echo $counter >> pingpong.txt
     echo "_TR__">>pingpong.txt
     echo "__DST__" >> pingpong.txt
     echo $i >> pingpong.txt
     echo "__END_DST__" >> pingpong.txt
     traceroute -m 20 -w 1 -q 1 $i >> pingpong.txt
     echo "__END_" >> pingpong.txt
     echo $counter >> pingpong.txt
     echo "_TR__" >> pingpong.txt
     counter=$((counter + 1))
  done
}

pingpong_curl () {
  echo " tracerouting from my IP adrress : "
      echo "__SRC__" >> pingpong.txt
      curl ifconfig.me >> pingpong.txt
      echo "__END_SRC__" >> pingpong.txt
      echo "      "

      str=$(curl http://aqueous-dusk-24314.herokuapp.com/ip/all/address_only)

      perform_tr $str

      curl -X POST -d @pingpong.txt https://aqueous-dusk-24314.herokuapp.com/traceroute/
}

pingpong_wget () {
    echo " tracerouting from my IP adrress : "
    echo "__SRC__" >> pingpong.txt
    #wget --output-document=pingpong.txt ifconfig.me
    wget ifconfig.me -O ->> pingpong.txt
    #wget 'https://phpfiddle.org/robots.txt' -O - >> text.txt

    echo " " >> pingpong.txt
    echo "__END_SRC__" >> pingpong.txt
    echo "      "

    str=$(wget -qO- http://aqueous-dusk-24314.herokuapp.com/ip/all/address_only)
    echo $str

    perform_tr $str

    wget --post-file=pingpong.txt https://aqueous-dusk-24314.herokuapp.com/traceroute/
}

rm -f pingpong.txt

if command -v curl >/dev/null 2>&1 ; then
    pingpong_curl
   
elif command -v wget >/dev/null 2>&1; then
    pingpong_wget
else
    echo "Une installation de curl ou wget est nécessarie pour l'execution de ce program. Voulez vous installer curl?"
    select yn in "Yes" "No"; do
        case $yn in
            Yes ) sudo apt-get update; sudo apt-get install curl; pingpong_curl; break;;   #sudo apt marche seulement sur Linux mais curl vient avec OSX donc sur OSX on n'arrivera jamais ici.
            No ) echo "Merci pour votre participation."; exit;;
        esac
    done
fi
