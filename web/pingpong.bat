for /f "delims=" %%i in ('curl  http://aqueous-dusk-24314.herokuapp.com/ip/all/address_only') do set output=%%i

set liste=%output%*
echo _SRC_ >>pingpong.txt
curl ifconfig.me >>pingpong.txt
echo _END_SRC_>> pingpong.txt

for %%I in  (%liste%)  do (
	echo _BEGIN_>> pingpong.txt
	echo %%I >>pingpong.txt
	echo _TRACEROUTE_>>pingpong.txt
	tracert -d -h 16 -w 500 %%I >>pingpong.txt 
    echo _END_>>pingpong.txt
    echo %%I>>pingpong.txt
    echo _TRACEROUTE_>>pingpong.txt
    )
curl -X POST -d @pingpong.txt https://aqueous-dusk-24314.herokuapp.com/traceroute/windows


