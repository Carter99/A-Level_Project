import json, math, urllib.request, time, pymysql.cursors

blockLength=7    ## DO NOT INCREASE BEYOND 50 ##
prefix="https://en.wikipedia.org/w/api.php?action=query&prop=revisions&rvprop=content&rvsection&format=json&titles="

def database_connection():
	return pymysql.connect(host='localhost', user='root', password='password', db='DEATHLIST', charset='utf8mb4', cursorclass=pymysql.cursors.DictCursor)
	#
	# Parameter(s):
	#	N/a
	# Output(s):
	#	- 1: Returns a pymysql data structure for the open path to a
	#	database.
	# Notes:
	#	- The database that the function is connecting to is that for
	#	my DEATHLIST database.
	#################################################################

def retrieve_alive_names(connectionPath):
	try:
		with connectionPath.cursor() as cursor:
			sql = "SELECT `Wiki_Name` FROM `Celebrities` WHERE `dead`=0"
			cursor.execute(sql)
			return cursor.fetchall()
	finally:
		connectionPath.close()
	#
	# Parameter(s):
	#	- connectionPath: open path to connect to the DEATHLIST 
	#	database.
	# Output(s):
	#	- 1: Returns an array of dictionaries
	# Notes:
	#	- The output in this case is in the format of: 
	#	[{"Wiki_Name": value},...], continuing for the length of the
	#	number of names returned.
	#################################################################

def dictionary_value_unzip(dictArray):
	return[dictionary["Wiki_Name"] for dictionary in dictArray]
	#
	# Parameter(s):
	#	- dictArray: 1D array containing dictionaries
	# Output(s):
	#	- 1: 1D array of type strings.
	# Notes:
	#	- The array of dictionaries that will be used for the input 
	#	were outputted from the sourcing of information from the call
	#	to the database for the list of celebrities.
	#################################################################

def people_split(array,length):
	return[array[i*length:(i+1)*length]for i in range(math.ceil(len(array)/length))]
	#
	# Parameter(s): 
	# 	- array: 1D array of type strings
	#	- length: int
	# Output(s):
	#	- 1: 2D array of arrays of type of string
	# Notes:
	# 	- Relative line 2: This list comprehension takes the list
	#	of people from the 'array' list in blocks of size defined
	#	by the 'length' constant. Within the loop, increments by the 
	#	magnitude of the 'length' each time.
	#	- Output 1 is a broken down section of the input parameter, 
	#	split into equal length blocks of length described by the 
	#	global constant as called inside the function 'length'.
	#################################################################

def request_string(block,prefix):
	return prefix+"|".join(block)
	#
	# Parameter(s): 
	# 	block: 1D array of type strings
	# Output(s):
	#	1: String
	# Notes:
	#	The outputted string will be of the prefix (in this case the
	#	aspect of the API request that will remain the same for all
	#	requests) followed by the list of names from the block
	#	parameter formatted into one string with '|' as a divider.
	#################################################################

def json_retrieval(call):
	with urllib.request.urlopen(call) as url:
		return json.loads(url.read().decode())
	#
	# Parameter(s): 
	# 	array: 1D array of type strings
	# Output(s):
	#	1: JSON
	# Notes:
	#	N/a
	#################################################################

def TOADD():
	with connection.cursor() as cursor:
		# Create a new record
		sql = "INSERT INTO `users` (`email`, `password`) VALUES (%s, %s)"
		cursor.execute(sql, ('webmaster@python.org', 'very-secret'))
	connection.commit()

connection=database_connection()
results=retrieve_alive_names(connection)
people=dictionary_value_unzip(results)
blocks=people_split(people,blockLength)

died=[]

for requestBlock in blocks:
	request=request_string(requestBlock,prefix)
	JSON=json_retrieval(request)
	normalisation={dictionary["to"]:dictionary["from"] for dictionary in JSON["query"]["normalized"]}

	pages=JSON["query"]["pages"]
	for pageid in pages.keys():
		name=pages[pageid]["title"]
		try:
			name=normalisation[name]
		except KeyError:
			pass
		bulk=pages[pageid]["revisions"][0]["*"].lower()
		print(name,end=": ")
		print("death date and age|" in bulk)
		if "death date and age|" in bulk:
			died+=[name]
	#print({JSON["query"]["pages"][pageid]["title"]:JSON["query"]["pages"][pageid]["revisions"][0]["*"]})
print(died)