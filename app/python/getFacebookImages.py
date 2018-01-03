# import urllib2
# content = urllib2.urlopen("https://graph.facebook.com/v2.11/1269385029858946/photos?fields=images&access_token=904329973077806|1d04e986d4a518aade88f062e8943f21").read()
# print (content)

# from urllib.request import urlopen
# html = urlopen("https://graph.facebook.com/v2.11/1269385029858946/photos?fields=images&access_token=904329973077806|1d04e986d4a518aade88f062e8943f21")
# print(html)


import csv
import requests
import sys

if __name__ == '__main__':
    url = sys.argv[1]
    csvName = sys.argv[2]
    # print(url)
    # url = "https://www.facebook.com/pg/onyxbkk/photos/?tab=album&album_id=1175154482615335"
    album_id = url[url.index('album_id')+9:]

    r = requests.get("https://graph.facebook.com/v2.11/%s/photos?fields=images&access_token=904329973077806|1d04e986d4a518aade88f062e8943f21"%album_id)
    # print(r.json()['data'][0]['images'][0]['source'])
    count = 0
    with open('./csv/'+csvName, 'w') as csvfile:
        fieldnames = ['imagePath']
        writer = csv.DictWriter(csvfile, fieldnames=fieldnames)
        writer.writeheader()
        while(1):
            count = count + len(r.json()['data'])
            for i in r.json()['data']:
                writer.writerow({'imagePath':i['images'][0]['source']})
                print(i['images'][0]['source'])
            if "next" in r.json()['paging']:
                r = requests.get(r.json()['paging']['next'])
            else: break
    print(count)
