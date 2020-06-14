#coding=utf8
import sys
import requests
from bs4 import BeautifulSoup
import time
import re
import json

#ssl._create_default_https_context = ssl._create_unverified_context
proxies={"https": "http://pneyndfg-rotate:87980thnxn1i@p.webshare.io:80/ "}

url = 'http://www.1034.cn/search/?tm=%s'%str(sys.argv[1])
response = requests.get(url, proxies=proxies)
soup = BeautifulSoup(response.text, 'lxml')

pattern = re.compile("(\w*)(?:<\/button>)(.*)")
items = re.findall(pattern,response.text)

#items = soup.select(".panel-default").string()
goods ={}
goods['barcoce'] = sys.argv[1]
for item in items:
    if item[0] == '商品名称':
        goods['name'] = item[1].replace('&nbsp;', '')
return_json = json.dumps( goods)

print(return_json)