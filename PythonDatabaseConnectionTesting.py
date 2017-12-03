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
        # Read a single record
        sql = "SELECT `Wiki_Name` FROM `Celebrities` WHERE `dead`=0"
        cursor.execute(sql)
        result = cursor.fetchall()
        print(result)
finally:
    connection.close()





import urllib.request, json
def json_retrieval(call):
	with urllib.request.urlopen(call) as url:
	    data = json.loads(url.read().decode())
	    print(data)

json_retrieval("http://maps.googleapis.com/maps/api/geocode/json?address=google")



	
json_retrieval("https://en.wikipedia.org/w/api.php?action=query&prop=revisions&rvprop=content&rvsection&format=json&titles=Theresa_May")