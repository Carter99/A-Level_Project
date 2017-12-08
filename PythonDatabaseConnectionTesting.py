'''import pymysql.cursors

def connect():
	return pymysql.connect(host='localhost',
								 port = 3306,
								 user='root',
								 password='password',
								 db='DEATHLIST',
								 charset='utf8mb4',
								 cursorclass=pymysql.cursors.DictCursor)


connection=connect()
try:
	with connection.cursor() as cursor:
		sql = "SELECT * FROM `Users`"
		cursor.execute(sql)
		result = cursor.fetchall()
		for i in result:
			print("\n",i,"\n")
finally:
	connection.close()

	'''


import pymysql.cursors

# Connect to the database
connection = pymysql.connect(host='localhost',
                             user='root',
                             password='password',
                             db='DEATHLIST',
                             charset='utf8mb4',
                             cursorclass=pymysql.cursors.DictCursor)
try:
    with connection.cursor() as cursor:
        sql = "SELECT 'Wiki_Name' FROM `Celebrities` WHERE `dead`=0"
        cursor.execute(sql)
        result = cursor.fetchall()
        print(result)
finally:
    connection.close()


'''

import urllib.request, json
def json_retrieval(call):
	req = urllib.request.Request(call, headers = {
		"user-agent": "connorbot"
	})
	with urllib.request.urlopen(req) as url:
	    return json.loads(url.read().decode())

#print((json_retrieval("http://maps.googleapis.com/maps/api/geocode/json?address=google")))

'''
	
#print(json_retrieval("https://en.wikipedia.org/w/api.php?action=query&prop=revisions&rvprop=content&format=json&titles=Jack_Churchill|Elon_Musk|prince_(musician)|Jeff_Bezos|Kellyanne_Conway|Donald_Trump|Mike_Pence|Steve_Bannon|Hillary_Clinton|Bill_Clinton|Franklin_D._Roosevelt|George_W._Bush|Ann_Richards|Stephen_Colbert|Trevor_Noah|Tomi_Lahren|Jon_Stewart|Ken_Dodd|Keith_Richards|Miley_Cyrus|Elizabeth_Dawn|Andrew_Lloyd_Webber|Winston_Churchill|Theresa_May|John_Major|Tony_Blair|Gordon_Brown|David_Cameron|Elizabeth_II|George_VI|Nick_Clegg|John_Prescott|Michael_Howard|Greg_Clark|Sajid_Javid|Vince_Cable|Elton_John|Michael_Jackson|Ben_Howard|Tom_Odell|Alex_Ebert|Thom_Yorke|Jonny_Greenwood|Colin_Greenwood|Philip_Selway|Ed_O%27Brien|Philip_Pullman|Albert_Einstein|Tom_Odell|Roald_Dahl"))


