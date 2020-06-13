import requests
import pymysql
import json
import time

class KakaoAPI:

    def __init__(self):
        self.CLIENT_ID = 'e88dc6e8a3c14d8a611dbb9d511d4cf9'
        self.REDIRECT_URI = 'http://flora.gomi.land/oauth'
        self.OLD_CODE = ''
        self.ACCESS_TOKEN = ''
        self.REFRESH_TOKEN = ''
        self.DB = pymysql.connect(host='db', port=3306, user='root', passwd='sksmschlrhek1', db='iotadmin_db', charset='utf8')
        self.CURS = self.DB.cursor(pymysql.cursors.DictCursor)

    def _exec_query(self, query):
        self.CURS.execute(query, ('imgomi'))
        rows = self.CURS.fetchall()
        return rows

    def set_tokens_from_db(self):
        rows = self._exec_query("SELECT * FROM flora WHERE name=%s")
        url = 'https://kauth.kakao.com/oauth/token'
        self.OLD_CODE = rows[0]['code']
        d = {
            'grant_type': 'authorization_code',
            'client_id': self.CLIENT_ID,
            'redirect_uri': self.REDIRECT_URI,
            'code': self.OLD_CODE
        }
        x = requests.post(url, data=d)
        json_data = json.loads(x.text)
        self.ACCESS_TOKEN = json_data['access_token']
        self.REFRESH_TOKEN = json_data['refresh_token']

    def is_new_code(self):
        rows = self._exec_query("SELECT * FROM flora WHERE name=%s")
        cur_code = rows[0]['code']
        return self.OLD_CODE != cur_code

    def get_limit_sensor_data_from_db(self):
        rows = self._exec_query("SELECT * FROM flora WHERE name=%s")
        return rows[0]['water'], rows[0]['battery']

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


def main():
    template_list = {'water': '30086', 'battery': '30087'}
    kakao = KakaoAPI()
    kakao.set_tokens_from_db()

    state_water = False
    state_battery = False

    while True:
        if kakao.is_new_code():
            kakao.set_tokens_from_db()
        water, battery = kakao.get_limit_sensor_data_from_db()

        if water <= 0 and not state_water:
            kakao.send_template_message_for_me(template_list['water'])
            state_water = True
        elif water >= 20 and state_water:
            state_water = False
        
        if battery <= 15 and not state_battery:
            kakao.send_template_message_for_me(template_list['battery'])
            state_battery = True
        elif battery >= 15 and state_battery:
            state_battery = False

        time.sleep(5)


if __name__ == '__main__':
    main()
