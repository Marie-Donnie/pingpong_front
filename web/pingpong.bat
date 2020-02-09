for /f "delims=" %%i in ('curl  http://aqueous-dusk-24314.herokuapp.com/ip/all/address_only') do set output=%%i

set liste=%output%

for %%I in  (%liste%)  do (tracert -d -h 16 -w 500 %%I >>pingpong.txt )

curl -X POST -d @pingpong.txt https://aqueous-dusk-24314.herokuapp.com/traceroute/windows


