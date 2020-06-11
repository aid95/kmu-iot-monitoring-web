import requests
import pymysql
import json

class KakaoAPI:

    def __init__(self):
        self.CLIENT_ID = 'e88dc6e8a3c14d8a611dbb9d511d4cf9'
        self.REDIRECT_URI = 'http://flora.gomi.land/oauth'
        self.ACCESS_TOKEN = ''
        self.REFRESH_TOKEN = ''
        self.DB = pymysql.connect(host='db', port=3306, user='root', passwd='sksmschlrhek1', db='iotadmin_db', charset='utf8')
        self.CURS = self.DB.cursor(pymysql.cursors.DictCursor)

    def set_tokens_from_db(self):
        sql = "SELECT * FROM flora WHERE name=%s"
        curs.execute(sql, ('imgomi'))
        rows = curs.fetchall()

        url = 'https://kauth.kakao.com/oauth/token'
        code = rows[0]['code']
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
        d = {'template_id': '30087'}
        x = requests.post(url, headers=h, data=d)


def main():
    template_list = {'water': '30086', 'battery': '30087'}
    kakao = KakaoAPI()
    kakao.set_tokens_from_db()
    print(kakao.get_access_token())


if __name__ == '__main__':
    main()
