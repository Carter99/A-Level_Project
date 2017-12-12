import json, math, urllib.request, time


block_length=6        ## DO NOT INCREASE BEYOND 50 ##
People=["Jack_Churchill","Elon_Musk","prince_(musician)","Jeff_Bezos","Kellyanne_Conway","Donald_Trump","Mike_Pence","Steve_Bannon","Hillary_Clinton","Bill_Clinton","Franklin_D._Roosevelt","George_W._Bush","Ann_Richards","Stephen_Colbert","Trevor_Noah","Tomi_Lahren","Jon_Stewart","Ken_Dodd","Keith_Richards","Miley_Cyrus","Elizabeth_Dawn","Andrew_Lloyd_Webber","Winston_Churchill","Theresa_May","John_Major","Tony_Blair","Gordon_Brown","David_Cameron","Elizabeth_II","George_VI","Nick_Clegg","John_Prescott","Michael_Howard","Greg_Clark","Sajid_Javid","Vince_Cable","Elton_John","Michael_Jackson","Ben_Howard","Tom_Odell","Alex_Ebert","Thom_Yorke","Jonny_Greenwood","Colin_Greenwood","Philip_Selway","Ed_O%27Brien","Philip_Pullman","Albert_Einstein","Tom_Odell","Roald_Dahl"]
prefix="https://en.wikipedia.org/w/api.php?action=query&prop=revisions&rvprop=content&rvsection&format=json&titles="


####### people_splitter #######
# parameter(s): 
# 	List_of_people: 1D list of type strings
# Output(s):
#	1: 2D array with type of string
# Notes:
# 	- Relative line 2: This list comprehension takes the list
#	of people from the 'People' list in blocks of size defined
#	by the 'block_length' constant. And within the loop, 
#	increments by the magnitude of the 'block_length' each time.
#	- Output 1 is a broken down section of the input parameter, 
#	split into equal length blocks of length described by the 
#	global constant as called inside the function 'block_length'.
###############################
def people_splitter(list_of_people):
	global block_length
	return[list_of_people[block_number*block_length:(block_number+1)*block_length]for block_number in range(math.ceil(len(list_of_people)/block_length))]




####### title_joiner #######
# parameter(s): 
# 	array: 1D list of type strings
# Output(s):
#	1: string
# Notes:
#	- Output 1 contains all of the information from the string 
#	just in a single string that is separated by the "|" 
#	character since this is the way the wikipedia API desires
#	the title parameters to be formatted when multiple are 
#	applicable.
############################
def title_joiner(array):
	return "|".join(array)


####### json_retrieval #######
# parameter(s): 
# 	array: 1D list of type strings
# Output(s):
#	1: Json
# Notes:
#	N/a
############################
def json_retrieval(call):
	with urllib.request.urlopen(call) as url:
		return json.loads(url.read().decode())


'''
#print(people_splitter(People))
for API_call in people_splitter(People):
	print(API_call)
	formatted=title_joiner(API_call)
	print(formatted)
	request=prefix+formatted
	print(request)
	json_return=json_retrieval(request)
	print(json_return)
'''


#Testing

json_return=json_retrieval("https://en.wikipedia.org/w/api.php?action=query&prop=revisions&rvprop=content&rvsection&format=json&titles=Jack_Churchill|Elon_Musk")


def find_normalised(JSON):
	name_normalisation=[]
	for correction in JSON["query"]["normalized"]:
		wikipedia_version=correction["from"]
		plain_english=correction["to"]
		name_normalisation+=[[wikipedia_version,plain_english]]
	print(name_normalisation)
	return name_normalisation

'''

#find_normalised(json_return)






#name_normalisation=[["Original_0","Normalized_0"],["Original_1","Normalized_1"],...,["Original_n","Normalized_n"]]









get_list_of_people=people_splitter(People)






























#print(json_return)



find_normalised(json_return)
'''

