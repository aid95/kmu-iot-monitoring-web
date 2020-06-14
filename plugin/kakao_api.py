import requests
import pymysql
import json
import time
import base64


def stringToBase64(s):
    return base64.b64encode(s.encode('utf-8')).decode('utf-8')

def base64ToString(b):
    return base64.b64decode(b).decode('utf-8')


class DBController:

    def __init__(self, host, user, passwd, db):
        self.DB = pymysql.connect(host=host, port=3306, user=user, passwd=passwd, db=db, charset='utf8')
        self.CURS = self.DB.cursor(pymysql.cursors.DictCursor)

    def exec_query(self, query, args):
        self.CURS.execute(query, args)
        rows = self.CURS.fetchall()
        return rows


class KakaoAPI:

    def __init__(self):
        self.CLIENT_ID = 'e88dc6e8a3c14d8a611dbb9d511d4cf9'
        self.REDIRECT_URI = 'http://flora.gomi.land/oauth'
        self.OLD_CODE = ''
        self.ACCESS_TOKEN = ''
        self.REFRESH_TOKEN = ''

    def set_tokens(self, code):
        rows = self._exec_query("SELECT * FROM flora WHERE name=%s")
        url = 'https://kauth.kakao.com/oauth/token'
        d = {
            'grant_type': 'authorization_code',
            'client_id': self.CLIENT_ID,
            'redirect_uri': self.REDIRECT_URI,
            'code': code
        }
        x = requests.post(url, data=d)
        json_data = json.loads(x.text)
        self.ACCESS_TOKEN = json_data['access_token']
        self.REFRESH_TOKEN = json_data['refresh_token']

    def get_access_token(self):
        return self.ACCESS_TOKEN

    def get_refresh_token(self):
        return self.REFRESH_TOKEN

    def send_template_message_for_me(self, template_id):
        if self.ACCESS_TOKEN == '':
            return
        url = 'https://kapi.kakao.com/v2/api/talk/memo/send'
        h = {'Authorization': 'Bearer {}'.format(self.ACCESS_TOKEN)}
        d = {'template_id': template_id}
        x = requests.post(url, headers=h, data=d)


class KTIoTMakers:

    def __init__(self, device_id, app_id, secret, uid, upw):
        self.DEVICE_ID = device_id
        self.APP_ID = app_id
        self.SECRET = secret
        self.USER_ID = uid
        self.USER_PASS = upw
        self.ACCESS_TOKEN = ''

    def init(self):
        k = stringToBase64('{}:{}'.format(self.APP_ID, self.SECRET))
        h = {
            'Authorization': 'Basic {}'.format(k)
        }
        d = {
            'grant_type': 'password',
            'username': self.USER_ID,
            'password': self.USER_PASS
        }
        x = requests.post('https://iotmakers.kt.com/oauth/token', headers=h, data=d)
        json_x = json.loads(x.text)
        self.ACCESS_TOKEN = json_x['access_token']

    def get_last_tag_stream(self):
        h = {
            'Authorization': 'Bearer {}'.format(self.ACCESS_TOKEN)
        }
        x = requests.get('https://iotmakers.kt.com/api/v1/streams/{}/log/last'.format(self.DEVICE_ID), headers=h)
        json_x = json.loads(x.text)
        return json_x['data'][0]['attributes']


def main():
    template_list = {'water': '30086', 'battery': '30087'}

    kakao = KakaoAPI()
    dbc = DBController("db", "root", "sksmschlrhek1", "iotadmin_db")
    ktiot = KTIoTMakers('imgomiD1591093976479', '4yiHlwhIMx8ScLWk', 'VTotN1KWF8XlGOiA', 'imgomi', 'dkdldhxl0p9o-')
    ktiot.init()

    rows = dbc.exec_query("SELECT * FROM flora WHERE name=%s", ('imgomi'))
    kakao.set_tokens(rows[0]['code'])

    is_notify_water = False
    is_notify_battery = False

    while True:
        sensor_datas = ktiot.get_last_tag_stream()
        if sensor_datas['battery'] <= rows[0]['battery'] and not is_notify_battery:
            kakao.send_template_message_for_me(template_list['battery'])
            is_notify_battery = True
        elif sensor_datas['battery'] > rows[0]['battery'] and is_notify_battery:
            is_notify_battery = False

        if sensor_datas['moisture'] <= rows[0]['water'] and not is_notify_water:
            kakao.send_template_message_for_me(template_list['water'])         
            is_notify_water = True
        elif sensor_datas['moisture'] > rows[0]['water'] and is_notify_water:
            is_notify_water = False

        time.sleep(10)
        rows = dbc.exec_query("SELECT * FROM flora WHERE name=%s", ('imgomi'))
        

if __name__ == '__main__':
    main()
