import PyPDF2
import sys
import re
import time
from nltk.corpus import stopwords
import json
from gensim.corpora.dictionary import Dictionary
from gensim.models.tfidfmodel import TfidfModel

from newsapi.newsapi_client import NewsApiClient

import requests
from bs4 import BeautifulSoup

#Take file location and return text of file
def read_doc(target):
	pdfFileObject = open(target, 'rb')
	pdfReader = PyPDF2.PdfFileReader(pdfFileObject)
	count = pdfReader.numPages
	full_text = ''
	for i in range(count):
		page = pdfReader.getPage(i)
		text = page.extractText()
		full_text += text + ' '
	return full_text

#Parse questions from file text
def doc_to_questions(doc):
	questions = doc.split('Vraag ')
	questions = questions[1:]
	for i in range(len(questions)):
		question = questions[i]
		question = question.lower()
		question = question[:question.rfind('?')]
		question = re.sub(r'-\n','',question) # handle dashes breaking up words at end of line
		question = re.sub("'",' ',question).replace('_', ' ')
		question = re.sub(r'[^A-Za-z^-]', ' ', question)
		question = re.sub(r'\s+', ' ', question)
		words = [word for word in question.split() if word not in stopwords.words('dutch')]
		#To do: Handle footnotes ending up in questions crossing the page boundary. e.g. 2018D50780_ 2018-10-24.
		#Proposed solution: first and last of the words to remove seem always to contain both letters and number, use that to remove them.
		#To do: special characters (e met puntjes)
		questions[i] = words
	return questions

#Get keywords out of text by tf_idf method
def tf_idf_keywords(text, bow, dictionary):	
	tfidf = TfidfModel(bow)#generates the model
	text = dictionary.doc2bow(text)
	tfidf_weights = tfidf[text]  
	sorted_tfidf_weights = sorted(tfidf_weights, key=lambda w: w[1], reverse=True) #sort by value
	keywords = []
	for term_id, weight in sorted_tfidf_weights[:5]:
		print(str(dictionary.get(term_id)), weight)
		keywords.append(str(dictionary.get(term_id)))
	return keywords

#Given questions, get keywords. Can be done both per question or for the set of questions				
def questions_to_keywords(questions, per_question):
	with open('corpus.json') as bowfile:
		bow = json.load(bowfile)
		dictionary = Dictionary.load('dictionary.dict')
		if per_question:
			keywords_per_question = []
			for question in questions:
				keywords_per_question.append(tf_idf_keywords(question,bow,dictionary))
			return keywords_per_question
		else:
			questions = [word for question in questions for word in question]
			return tf_idf_keywords(questions,bow,dictionary)

#Create potential news queries based on the keywords, in order of potential usefulness
#First use all keywords, then repeatedly drop the last one untill only the first two remain
#Then drop the first one and repeat the process
def create_queries(keywords):
	queries = []
	for first in range(len(keywords)):
		new_keywords = keywords[first:]
		num_keywords = len(new_keywords)
		for last in range(num_keywords,1,-1):
			query = ''
			for keyword in new_keywords[:last]:
				query += keyword + ' '
				query.strip()
			queries.append(query)
	return queries

#Use queries based on the keywords to retrieve articles from the NewsAPI
def get_news_articles(queries):
	newsapi = NewsApiClient(api_key='2b7935c2680f46b487d833129210d4c3')
	not_enough_articles = True
	articles_to_find = 5
	articles = []
	for query in queries:
		print(query)
		all_articles = newsapi.get_everything(q=query,
											  from_param='2015-19-10',
											  to='2018-20-10',
											  sort_by='relevancy',
											  page=1)
		articles_found = all_articles['articles']
		print(len(articles_found))
		if len(articles_found) > articles_to_find:
			articles.append(articles_found[:articles_to_find])
			articles = [article for article_list in articles for article in article_list] #flatten list
			return articles
		else:
			articles.append(articles_found)
			articles_to_find -= len(articles_found)
	articles = [article for article_list in articles for article in article_list] #flatten list
	return articles

"""
def get_scientific_articles(keywords):
"""

#Use queries to retrieve urls and metadata of related previous answers
def get_previous_answers(queries):
	fromdate = ''
	todate = ''
	answers = []
	prev_answers_to_find = 5
	for query in queries:
		print(query)
		url = 'https://www.tweedekamer.nl/kamerstukken/kamervragen?clusterName=Kamerstukken&dpp=25&fld_prl_kamerstuk=Kamervragen&fld_prl_soort=Antwoord%20schriftelijke%20vragen&fld_tk_categorie=kamerstukken&qry=%2A&srt=date%3Adesc%3Adate&sta=1&fromdate='+fromdate+'&todate='+todate+'&qry='+query
		response = requests.get(url)
		soup = BeautifulSoup(response.text,'html.parser')
		articlecards = soup.findAll("article", {"class": "card"})
		time.sleep(1)
		if len(articlecards) > prev_answers_to_find:
			answers.append(articlecards[:prev_answers_to_find])
			answers = [answer for answer_list in answers for answer in answer_list] #flatten list
			return answers
		else:
			answers.append(articlecards)
			prev_answers_to_find -= len(articlecards)
	answers = [answer for answer_list in answers for answer in answer_list] #flatten list
	return answers
		
def main(argv):
	target = argv[1]
	doc = read_doc(target)
	questions = doc_to_questions(doc)
	keywords = questions_to_keywords(questions, False)
	queries = create_queries(keywords)
	articles = get_news_articles(queries)
	prev_answers = get_previous_answers(queries)
	
if __name__ == "__main__":
	main(sys.argv)
	
#Potential query improvements
#-Drop keywords with weight less than 0.2
#-Try tf-idf corpus based on more documents