#!/bin/bash

echo " tracerouting from my IP adrress : "
echo "%SRC%" >> save.txt
curl ifconfig.me >> save.txt
echo "%END_SRC%" >> save.txt
echo "      "

str=$(curl http://aqueous-dusk-24314.herokuapp.com/ip/all/address_only)

IFS=',' # hyphen (-) is set as delimiter
read -ra ADDR <<< "$str" # str is read into an array as tokens separated by IFS
for i in "${ADDR[@]}"; do # access each element of array
   echo "Tracerouting to"
   echo $i
   echo "%BEGIN_TR%" >> save.txt
   traceroute -m 20 -w 1 -q 1 $i >> save.txt
   echo "%END_TR%" >> save.txt


done

curl -X POST -d @save.txt https://aqueous-dusk-24314.herokuapp.com/traceroute/
