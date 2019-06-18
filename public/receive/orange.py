import requests
import json

c100 = "100";
url ="http://api.orange.com/smsmessaging/v1/outbound/tel+21654614211/requests"

payload = {
  "outboundSMSMessageRequest": {
    "address": "tel+21653424499",
    "outboundSMSTextMessage": {
      "message": "Capteur "+ c100 +"  est en incendie"
    },
    "senderAddress": "tel+21654614211",
    "senderName": "GCI"
  }
}
headers = {'content-type': 'application/json'}
r = requests.post(url, auth=('Basic U0cwUE1aeGZmZ0JLbUkzWUV2ZWlsM0xBdEt0UVZ4Q1k6SVRqWXQxRU5nWlV4SGM5OQ=='), data=payload, headers=headers)