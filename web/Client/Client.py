import requests as req
import json;
from requests import get, post
import subprocess
import re

class Client(object):
    def run(self):

        resp = req.get("https://aqueous-dusk-24314.herokuapp.com/ip/all", timeout=20)

        li = []
        res = resp.text
        loaded_json = json.loads(res)
        for x in loaded_json:
            li.append(x['address'])

        traceroutes = []

        ip = get('https://api.ipify.org').text
        print(ip)
        startPattern = '^traceroute to (.+) packets$'
        foundPattern = "^\s?([0-9]+)? (.+) \((.+)\) ((.+) ms)*"
        notFoundPattern = "^ ?[0-9]+  [*] [*] [*] *$"
        for address in li:

            chemin = []
            popen = subprocess.Popen(['traceroute', address], stdout=subprocess.PIPE, universal_newlines=True)
            notFoundCount = 0
            # for stdout_line in iter(popen.stdout.readline, ""):
            it = iter(popen.stdout.readline, "")
            for stdout_line in iter(popen.stdout.readline, ""):
                start = re.search(startPattern, stdout_line)
                found = re.search(foundPattern, stdout_line)
                notFound = re.search(notFoundPattern, stdout_line)

                if start:
                    # print(start.group(0))
                    print("START")
                elif found:
                    # print(found.group(0))
                    print("FOUND")
                    print(found.groups())
                    print(found.group(3))
                    chemin.append(found.group(3))
                elif notFound:
                    # print(notFound.group(0))
                    print("NOT FOUND")
                    notFoundCount += 1
                else:
                    print("no match" + stdout_line)

                if notFoundCount == 3:
                    # popen.stdout.close()
                    # popen.terminate()
                    break

            popen.stdout.close()
            popen.terminate()
            traceroutes.append({"dst": address, "route": chemin})

        print({"traceroutes": traceroutes, "src": ip})
        resp = post(url="https://aqueous-dusk-24314.herokuapp.com/traceroute/",
                    json={"traceroutes": traceroutes, "src": ip})
        print(resp)

if __name__ == '__main__':
    Client().run()

