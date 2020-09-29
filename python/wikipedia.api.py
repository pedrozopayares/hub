# -*- coding: utf-8 -*-
# Python 3
import requests
import json

# Parameters for Wikipedia API
wordSearch = 'python'

payload = {'q': wordSearch, 'limit': '10'}

urlDictionary = 'https://en.wikipedia.org/w/rest.php/v1/search/page'

res = requests.get(urlDictionary, params = payload)
data = json.loads(res.text)

x = randint(0, 9)

print(data['pages'][x]['title'])
print(data['pages'][x]['excerpt'])
