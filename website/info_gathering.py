
import sys
import re
import time
from newsapi.newsapi_client import NewsApiClient #use pip install newsapi-python
import requests
from bs4 import BeautifulSoup
import json

#Create queries based on the keywords, in order of potential usefulness
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

#Convert raw response to list of relevant features
def clean_articles(articles):
	for i in range(len(articles)):
		cleaned_article = {}
		article = articles[i]
		#cleaned_article['id'] = None
		cleaned_article['title'] = article['title']
		cleaned_article['publish_date'] = article['publishedAt'].split('T')[0]
		cleaned_article['url'] = article['url']
		cleaned_article['snippet'] = article['description']+'...'
		cleaned_article['type'] = 0
		cleaned_article['outlet'] = article['source']['name']
		articles[i] = cleaned_article
	return articles

def date_to_english(date):
	elements = date.split('-')
	return elements[2]+'-'+elements[0]+'-'+elements[1]

#Use queries based on the keywords to retrieve articles from the NewsAPI
def get_news_articles(queries, fromdate, todate):
	fromdate = '' if fromdate == 'nobound' else date_to_english(fromdate)
	todate = '' if todate == 'nobound' else date_to_english(todate)
	newsapi = NewsApiClient(api_key='2b7935c2680f46b487d833129210d4c3')
	not_enough_articles = True
	articles_to_find = 5
	articles = []
	titles = []
	for query in queries:
		all_articles = newsapi.get_everything(q=query,
											  from_param=fromdate,
											  to=todate,
											  sort_by='relevancy',
											  page=1)
		articles_found = all_articles['articles']
		for found_article in articles_found:
			if found_article['title'] not in titles and len(articles) < articles_to_find:
				print(found_article)
				articles.append(found_article)
				titles.append(found_article['title'])
		if len(articles) == articles_to_find:
			articles = clean_articles(articles)
			return articles
	articles = clean_articles(articles)
	return articles #if all queries together do not return 5 different articles, return what is found

"""
#def get_scientific_articles(keywords):
"""

def monthname_to_int(month):
	if month == 'jan':
		return '01'
	elif month == 'feb':
		return '02'
	elif month == 'mar':
		return '03'
	elif month == 'apr':
		return '04'
	elif month == 'mei':
		return '05'
	elif month == 'jun':
		return '06'
	elif month == 'jul':
		return '07'
	elif month == 'aug':
		return '08'
	elif month == 'sep':
		return '09'
	elif month == 'okt':
		return '10'
	elif month == 'nov':
		return '11'
	elif month == 'dec':
		return '12'
	else:	
		return '00'
		
#Convert dutch date to standard format
def reformat_date(date):
	elements = date.split(' ')
	day = elements[0]
	month = monthname_to_int(elements[1])
	year = elements[2]
	return year+'-'+month+'-'+day

#Concert raw html to list of relevant features
def clean_answers(answers):
	for i in range (len(answers)):
		cleaned_answer = {}
		answer = answers[i]
		cleaned_answer['id'] = answer.find("a", {"class": "code-nummer"}).getText()
		cleaned_answer['title'] = answer.findAll("a", href=True)[2].getText()
		cleaned_answer['publish_date'] = reformat_date(answer.find("div", {"class": "card__pretitle"}).getText().strip())
		cleaned_answer['url'] = "https://tweedekamer.nl/"+answer.find("a", {"class": "document__button"})['href']
		cleaned_answer['snippet'] = answer.find("p").getText()+'...'
		cleaned_answer['type'] = 1
		cleaned_answer['outlet'] = 'n.v.t.'
		answers[i] = cleaned_answer
	return answers

#Use queries to retrieve urls and metadata of related previous answers
def get_previous_answers(queries, fromdate, todate):
	if fromdate == 'nobound':
		fromdate = ''
	if todate == 'nobound':
		todate = ''
	answers = []
	prev_answers_to_find = 5
	for query in queries:
		url = 'https://www.tweedekamer.nl/kamerstukken/kamervragen?clusterName=Kamerstukken&dpp=25&fld_prl_kamerstuk=Kamervragen&fld_prl_soort=Antwoord%20schriftelijke%20vragen&fld_tk_categorie=kamerstukken&qry=%2A&srt=date%3Adesc%3Adate&sta=1&fromdate='+fromdate+'&todate='+todate+'&qry='+query
		response = requests.get(url)
		soup = BeautifulSoup(response.text,'html.parser')
		articlecards = soup.findAll("article", {"class": "card"})
		time.sleep(1)
		for articlecard in articlecards:
			if articlecard not in answers and len(answers) < prev_answers_to_find:
				answers.append(articlecard)
		if len(answers) == prev_answers_to_find:
			answers = clean_answers(answers)
			return answers
	answers = clean_answers(answers)
	return answers #if all queries together do not return 5 different previous answers, return what is found

def main(argv):
	keywords = argv[1]
	keywords = argv[1][:-1].split(",") #[:-1] is to remove last comma
	fromdate = argv[2]
	todate = argv[3]
	search_news = argv[4]
	search_prev_answers = argv[5]
	queries = create_queries(keywords)
	data = {}
	news_articles = []
	prev_answers = []
	if(search_news == 'on'):
		news_articles = get_news_articles(keywords, fromdate, todate)
	if(search_prev_answers == 'on'):
		prev_answers = get_previous_answers(queries, fromdate, todate)
	data = news_articles + prev_answers
	json_data = json.dumps(data)
	print(json_data)
	return

if __name__ == "__main__":
	main(sys.argv)
	
#Potential query improvements
#-Drop keywords with weight less than 0.2
#-Try tf-idf corpus based on more documents
#Remove duplicates from results. Duplicates very likely because of query overlap