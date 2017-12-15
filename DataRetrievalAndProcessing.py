import json, math, urllib.request, time, pymysql.cursors, random

blockLength=50    ## DO NOT INCREASE BEYOND 50 ##
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

def retrieve_all(connectionPath,sql):
	try:
		with connectionPath.cursor() as cursor:
			cursor.execute(sql)
			return cursor.fetchall()
	except:
		pass
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

def table_update(connectionPath,sql):
	try:
		with connectionPath.cursor() as cursor:
			cursor.execute(sql)
		connectionPath.commit()
	except:
		pass

loopNumber=0
try:
	while True:
		startTime=time.time()
		connection=database_connection()
		sql = "SELECT `Wiki_Name` FROM `Celebrities` WHERE `dead`=0"
		results=retrieve_all(connection,sql)
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
				if "death date and age|" in bulk:
					died+=["'"+name+"'"]

		random.shuffle(died)

		currentTime=time.time()
		for person in died:
			sql="UPDATE `Celebrities` SET `dead`=1 WHERE `Wiki_Name`="+person
			table_update(connection,sql)
			sql="SELECT `Selection`.`GroupID`, `Selection`.`UserID`, `Groups`.`LastDeath`, `Groups`.`CycleDuration`, `Groups`.`CycleInput`, `Celebrities`.`ID` FROM `Selection` INNER JOIN `Celebrities` ON `Celebrities`.`ID` = `Selection`.`CelebrityID` INNER JOIN `Groups` ON `Groups`.`ID` = `Selection`.`GroupID` WHERE `Celebrities`.`Wiki_Name` ="+person
			results=retrieve_all(connection,sql)
			print(person+" died @ "+str(currentTime)+", affecting "+str(len(results))+" groups.")
			for applicableGroup in results:
				perPersonPayout=((currentTime-applicableGroup["LastDeath"])//applicableGroup["CycleDuration"])*applicableGroup["CycleInput"]
				sql="SELECT `UserID` FROM `Memberships` WHERE `GroupID`="+str(applicableGroup["GroupID"])+" AND `UserID`<>"+str(applicableGroup["UserID"])
				results2=retrieve_all(connection,sql)
				winnings=perPersonPayout*len(results2)
				sql="INSERT INTO `Payouts`(`GroupID`, `UserID`, `PayTo`, `CelebID`, `UnixTime`, `Amount`) VALUES ("+str(applicableGroup["GroupID"])+",-1,"+str(applicableGroup["UserID"])+","+str(applicableGroup["ID"])+","+str(currentTime)+","+str(winnings)+")"
				table_update(connection,sql)
				for members in results2:
					sql="INSERT INTO `Payouts`(`GroupID`, `UserID`, `PayTo`, `CelebID`, `UnixTime`, `Amount`) VALUES ("+str(applicableGroup["GroupID"])+","+str(members["UserID"])+","+str(applicableGroup["UserID"])+","+str(applicableGroup["ID"])+","+str(currentTime)+","+str(-perPersonPayout)+")"
					table_update(connection,sql)
				sql="UPDATE `Groups` SET `LastDeath`="+str(currentTime)+" WHERE `ID`="+str(applicableGroup["GroupID"])
				table_update(connection,sql)
		connection.close()
		activeTime=time.time()-startTime
		print("["+str(loopNumber)+"]: loop completed in "+str(activeTime)+" seconds.")
		loopNumber+=1
		time.sleep(300) #RAISE TO LIKE 5 MINS OR SOMETHING!
except KeyboardInterrupt:
	print("\nMANUAL KILL COMMENCED - PROGRAM SHUT DOWN")
except:
	print("\nUNKNOWN ERROR - PROGRAM SHUT DOWN")