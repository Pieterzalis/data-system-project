import PyPDF2
import sys
import re
import os
from nltk.corpus import stopwords
import json
from gensim.corpora.dictionary import Dictionary
from gensim.models.tfidfmodel import TfidfModel
import docx2txt

# Take file location and return text of file

def read_pdf(target):
	pdfFileObject = open(target, 'rb')
	pdfReader = PyPDF2.PdfFileReader(pdfFileObject)
	count = pdfReader.numPages
	full_text = ''
	for i in range(count):
		page = pdfReader.getPage(i)
		text = page.extractText()
		full_text += text + ' '
	return full_text
	
def read_docx(target):
	text = docx2txt.process(target)
	return text
	
def remove_footnotes(text):
	return text

def read_file(target):
	extension = target.rpartition('.')[2]
	if extension == 'pdf':
		text = read_pdf(target)
	elif extension == 'docx':
		text = read_docx(target)
	else:
		text = ''
	return remove_footnotes(text)


def doc_to_metadata(doc):
	print(doc.split('\n')[0].strip())
	metadict = {} # dictionary with metadata
	doc = doc.replace('Vragen door', 'Vragen van').replace('\naan', ' aan ').replace('aan\n', ' aan ').replace('inzake', 'over').replace('\n', ' ')
	metadict['indiener'] = doc.split('Vragen van')[1].split('aan')[0].replace('de leden','').replace('het lid','').replace('lid','').replace('leden','').strip()
	if ',' in metadict['indiener']:
		metadict['indiener'] = metadict['indiener'].split(',')[0].strip()	
	elif ' en ' in metadict['indiener']:
		metadict['indiener'] = metadict['indiener'].split(' en ')[0].strip()
	metadict['topic'] = doc.split('over', 1)[1].split('(')[0].strip()
	if 'der Kamer' in doc:
		metadict['id'] = doc.split('der Kamer')[1].split('Vragen')[0].strip()
	else:
		metadict['id'] = doc.split(' ')[0].strip()
	metadict['date'] = doc.replace('Ingezonden','ingezonden').split('ingezonden')[1].split(')')[0].strip()
	return metadict


# Parse questions from file text
def doc_to_questions(text):
	# To do: Handle footnotes ending up in questions crossing the page boundary. e.g. 2018D50780_ 2018-10-24.
	# Proposed solution: first and last of the words to remove seem always to contain both letters and number,
	# use that to remove them.
	# To do: special characters (e met puntjes)
	# To do: numbers footnotes: Remove every number that is directly attached to the end of a non-number
	questions = []
	if 'Vraag ' in text: #for pdf files
		questions = text.split('Vraag ')
		questions = questions[1:]
	else: #for doc files
		paragraphs = text.split('\n')
		questions = [paragraph for paragraph in paragraphs if '? ' in paragraph]
	for i in range(len(questions)):
		question = questions[i]
		question = question[:question.rfind('?')]
		question = re.sub(r'-\n','',question) # handle dashes breaking up words at end of line
		question = re.sub(r'\n',' ',question)
		question = 'Vraag ' + question + '?'
		question = re.sub(r'\s+', ' ', question)
		questions[i] = question
	return questions


# Get keywords out of text by tf_idf method
def tf_idf_keywords(text, bow, dictionary):	
	tfidf = TfidfModel(bow) # generates the model
	text = dictionary.doc2bow(text)
	tfidf_weights = tfidf[text]  
	sorted_tfidf_weights = sorted(tfidf_weights, key=lambda w: w[1], reverse=True) # sort by value
	keywords = []
	for term_id, weight in sorted_tfidf_weights[:5]:
		print(str(dictionary.get(term_id)), weight)
		keywords.append(str(dictionary.get(term_id)))
	return keywords

def preprocess_question(question):
	question = question.lower()
	question = re.sub("'",' ',question).replace('_', ' ').replace(' -',' ')
	question = re.sub(r'[0-9]','',question)
	question = re.sub(r'[^A-Za-z^-]', ' ', question)
	question = re.sub(r'\s+', ' ', question)
	words = [word for word in question.split() if word not in stopwords.words('dutch')]
	return words
	
# Given questions, get keywords. Can be done both per question or for the set of questions
def questions_to_keywords(questions, per_question):
	with open('corpus.json') as bowfile:
		bow = json.load(bowfile)
		dictionary = Dictionary.load('dictionary.dict')
		if per_question:
			keywords_per_question = []
			for question in questions:
				words = preprocess_question(question)
				keywords_per_question.append(tf_idf_keywords(words,bow,dictionary))
			return keywords_per_question
		else:
			for i in range(len(questions)):
				question = questions[i]
				words = preprocess_question(question)
				questions[i] = words
			questions = [word for question in questions for word in question]
			return tf_idf_keywords(questions,bow,dictionary)


def main(argv):
	target = argv[1].replace('%26', '&').replace('%20', ' ')
	print(target)
	text = read_file(target)

	metadata = doc_to_metadata(text)
	questions = doc_to_questions(text)
	questions_orig = questions.copy()
	keywords = questions_to_keywords(questions, False)

	# returndict = {}
	# returndict['metadata'] = metadata
	# returndict['questions'] = questions_orig
	# returndict['keywords'] = keywords

	# json is easier to decode in php
	# please check this florijn!!
	data = {}
	data['metadata'] = metadata
	data['questions'] = questions_orig
	data['keywords'] = keywords
	json_data = json.dumps(data)

	print(json_data)
	return


if __name__ == "__main__":
	main(sys.argv)
	
#To do: make it work for word files