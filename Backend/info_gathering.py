import sys
import re
import time
from newsapi.newsapi_client import NewsApiClient
import requests
from bs4 import BeautifulSoup

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

#Convert raw response to list of relevant features
def clean_articles(articles):
	for i in range(len(articles)):
		cleaned_article = {}
		article = articles[i]
		cleaned_article['title'] = article['title']
		cleaned_article['date'] = article['publishedAt'].split('T')[0]
		cleaned_article['url'] = article['url']
		cleaned_article['snippet'] = article['description']
		articles[i] = cleaned_article
	return articles

#Use queries based on the keywords to retrieve articles from the NewsAPI
def get_news_articles(queries, fromdate, todate):
	fromdate = '2015-19-10'
	todate = '2018-20-10'
	newsapi = NewsApiClient(api_key='2b7935c2680f46b487d833129210d4c3')
	not_enough_articles = True
	articles_to_find = 5
	articles = []
	for query in queries:
		all_articles = newsapi.get_everything(q=query,
											  from_param=fromdate,
											  to=todate,
											  sort_by='relevancy',
											  page=1)
		articles_found = all_articles['articles']
		for found_article in articles_found:
			if found_article not in articles and len(articles) < articles_to_find:
				articles.append(found_article)
		if len(articles) == articles_to_find:
			articles = clean_articles(articles)
			return articles
	articles = clean_articles(articles)
	return articles #if all queries together do not return 5 different articles, return what is found

"""
def get_scientific_articles(keywords):
"""

#Concert raw html to list of relevant features
def clean_answers(answers):
	for i in range (len(answers)):
		cleaned_answer = {}
		answer = answers[i]
		cleaned_answer['id'] = answer.find("a", {"class": "code-nummer"}).getText()
		cleaned_answer['title'] = answer.findAll("a", href=True)[2].getText()
		cleaned_answer['date'] = answer.find("div", {"class": "card__pretitle"}).getText().strip()
		cleaned_answer['url'] = "https://tweedekamer.nl/"+answer.find("a", {"class": "document__button"})['href']
		cleaned_answer['snippet'] = answer.find("p").getText()
		answers[i] = cleaned_answer
	return answers

#Use queries to retrieve urls and metadata of related previous answers
def get_previous_answers(queries, fromdate, todate):
	fromdate = ''
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
	#keywords =  ["grond", "hergebruik", "betrokken", "handen", "inzichtelijk"]
	#fromdate = argv[2]
	#todate = argv[3]
	queries = create_queries(keywords)
	data = {}
	data['news_articles'] = get_news_articles(keywords, fromdate=None, todate=None)
	data['prev_answers'] = get_previous_answers(queries, fromdate=None, todate=None)
	json_data = json.dumps(data)
	print(json_data)
	return
	
if __name__ == "__main__":
	main(sys.argv)
	
#Potential query improvements
#-Drop keywords with weight less than 0.2
#-Try tf-idf corpus based on more documents
#Remove duplicates from results. Duplicates very likely because of query overlap