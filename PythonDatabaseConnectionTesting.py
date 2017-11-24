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
        sql = "SELECT * FROM `Users`"
        cursor.execute(sql)
        result = cursor.fetchall()
        print(result)
finally:
    connection.close()