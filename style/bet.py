import re

s = 'aHello?dW?orldaByed'
a='?'
result = re.search('a(.*)a', s)
print(result.group(1))
print(a)