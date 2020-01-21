#!/bin/bash

echo " tracerouting from my IP adrress : "
echo "__SRC__" >> save.txt
curl ifconfig.me >> save.txt
echo "__END_SRC__" >> save.txt
echo "      "

str=$(curl http://aqueous-dusk-24314.herokuapp.com/ip/all/address_only)

IFS=',' # hyphen (-) is set as delimiter
read -ra ADDR <<< "$str" # str is read into an array as tokens separated by IFS
counter=0;
for i in "${ADDR[@]}"; do # access each element of array
   echo "Tracerouting to"
   echo $i
   echo "__BEGIN_" >> save.txt
   echo $counter >> save.txt
   echo "_TR__">>save.txt
   echo "__DST__" >> save.txt
   echo $i >> save.txt
   echo "__END_DST__" >> save.txt
   traceroute -m 20 -w 1 -q 1 $i >> save.txt
   echo "__END_" >> save.txt
   echo $counter >> save.txt
   echo "_TR__" >> save.txt
   counter=$((counter + 1))
done

curl -X POST -d @save.txt https://aqueous-dusk-24314.herokuapp.com/traceroute/
