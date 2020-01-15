#!/bin/bash

echo " tracerouting from my IP adrress : "
curl ifconfig.me

echo "      "

str=$(curl http://aqueous-dusk-24314.herokuapp.com/ip/all/address_only)

IFS=',' # hyphen (-) is set as delimiter
read -ra ADDR <<< "$str" # str is read into an array as tokens separated by IFS
for i in "${ADDR[@]}"; do # access each element of array
   echo "Tracerouting to"
   echo $i

   traceroute $i >> save.txt


done

curl -X POST -d @save.txt https://aqueous-dusk-24314.herokuapp.com/traceroute/
