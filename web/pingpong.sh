#perform_tr () {
#  IFS=',' # hyphen (-) is set as delimiter
#  read -ra ADDR <<< "$str" # str is read into an array as tokens separated by IFS
#  counter=0;
#  for i in "${ADDR[@]}"; do
#     rm -f pingpong.txt
#       echo " tracerouting from my IP adrress : "
#     echo "__SRC__" >> pingpong.txt
#     $src >> pingpong.txt
#     echo "__END_SRC__" >> pingpong.txt
#     echo "      "
#     echo "Tracerouting to"
#     echo $i
#     echo "__BEGIN_" >> pingpong.txt
#     echo $counter >> pingpong.txt
#     echo "_TR__">>pingpong.txt
#     echo "__DST__" >> pingpong.txt
#     echo $i >> pingpong.txt
#     echo "__END_DST__" >> pingpong.txt
#     traceroute -m 20 -w 1 -q 1 $i >> pingpong.txt
#     echo "__END_" >> pingpong.txt
#     echo $counter >> pingpong.txt
#     echo "_TR__" >> pingpong.txt
#     counter=$((counter + 1))
#     curl -X POST -d @pingpong.txt https://aqueous-dusk-24314.herokuapp.com/traceroute/
#  done
#}

perform_tr () {
     echo $1 #filename
     echo $2 #src
     echo $3 #addr
     rm -f $1
     echo " tracerouting from my IP adrress : "
     echo "__SRC__" >> $1
     echo $2 >> $1
     echo "__END_SRC__" >> $1
     echo "      "
     echo "Tracerouting to"
     echo $3
     echo "__BEGIN_" >> $1
     echo 1 >> $1
     echo "_TR__">>$1
     echo "__DST__" >> $1
     echo $3 >> $1
     echo "__END_DST__" >> $1
     traceroute -m 16 -w 1 -q 1 $3 >> $1
     echo "__END_" >> $1
     echo 1 >> $1
     echo "_TR__" >> $1
}

pingpong_curl () {

  src=$(curl ifconfig.me)
  str=$(curl http://aqueous-dusk-24314.herokuapp.com/ip/all/address_only)
  IFS=',' # hyphen (-) is set as delimiter
  read -ra ADDR <<< "$str" # str is read into an array as tokens separated by IFS
  counter=0;
  for addr in "${ADDR[@]}"; do
     filename="pingpong_${counter}.txt"
     one_pingpong_curl $filename $src $addr
     #perform_tr $filename $src $addr
     #curl -X POST -d @$filename https://aqueous-dusk-24314.herokuapp.com/traceroute/
     counter=$((counter + 1))
  done
}

one_pingpong_curl() {
     perform_tr $1 $2 $3  #filname src addr
     curl -X POST -d @$1 https://aqueous-dusk-24314.herokuapp.com/traceroute/
     rm -f $1
}
pingpong_wget () {


      src=$(wget -qO- ifconfig.me)
      str=$(wget -qO- http://aqueous-dusk-24314.herokuapp.com/ip/all/address_only)
      IFS=',' # hyphen (-) is set as delimiter
      read -ra ADDR <<< "$str" # str is read into an array as tokens separated by IFS
      counter=0;
      for addr in "${ADDR[@]}"; do
         echo $filename
         echo $src
         echo $addr
         filename="pingpong_${counter}.txt"
         one_pingpong_wget $filename $src $addr
         #perform_tr $filename $src $addr
         #curl -X POST -d @$filename https://aqueous-dusk-24314.herokuapp.com/traceroute/
         counter=$((counter + 1))
      done
}

one_pingpong_wget(){
     perform_tr $1 $2 $3  #filname src addr
     wget --post-file=$1 -qO- https://aqueous-dusk-24314.herokuapp.com/traceroute/
     rm -f $1
}

install_curl(){
    if command -v apt-get ; then
        sudo apt-get update; sudo apt-get install curl;
    elif command -v yum; then
        sudo yum check-update; sudo yum install curl;
    fi
}


if command -v curl >/dev/null 2>&1 ; then
    pingpong_curl
   
elif command -v wget >/dev/null 2>&1; then
    pingpong_wget
else
    echo "Une installation de curl ou wget est nécessarie pour l'execution de ce program. Voulez vous installer curl?"
    select yn in "Yes" "No"; do
        case $yn in
            Yes ) install_curl; pingpong_curl; break;;
            No ) echo "Merci pour votre participation."; exit;;
        esac
    done
fi
