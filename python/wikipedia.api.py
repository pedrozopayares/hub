# -*- coding: utf-8 -*-
# Python 3
import requests
import json

urlLanguage = 'spa'
urlOutput = 'json'
wordSearch = 'python'.encode('utf-8')

urlDictionary = 'https://en.wikipedia.org/w/rest.php/v1/search/page?q=' + str(wordSearch) + '&limit=10'

res = requests.get(urlDictionary)
data = json.loads(res.text)


print(data['pages'][0]['title'])
