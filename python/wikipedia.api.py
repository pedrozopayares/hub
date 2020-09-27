# -*- coding: utf-8 -*-
# Python 3
import requests
import json

# Parameters for Wikipedia API
urlLanguage = 'spa'
urlOutput = 'json'
wordSearch = 'python'

payload = {'q': 'wordSearch', 'limit': '10'}

urlDictionary = 'https://en.wikipedia.org/w/rest.php/v1/search/page?q='

res = requests.get(urlDictionary, params = payload)
data = json.loads(res.text)

print(data['pages'][0]['title'])
print(data['pages'][0]['excerpt'])
