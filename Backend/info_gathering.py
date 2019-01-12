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
		article = articles[i]
		title = article['title']
		date = article['publishedAt'].split('T')[0]
		url = article['url']
		snippet = article['description']
		articles[i] = [title, date, url, snippet]
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
		print(query)
		all_articles = newsapi.get_everything(q=query,
											  from_param=fromdate,
											  to=todate,
											  sort_by='relevancy',
											  page=1)
		articles_found = all_articles['articles']
		print(len(articles_found))
		if len(articles_found) > articles_to_find:
			articles.append(articles_found[:articles_to_find])
			articles = [article for article_list in articles for article in article_list] #flatten list
			articles = clean_articles(articles)
			return articles
		else:
			articles.append(articles_found)
			articles_to_find -= len(articles_found)
	articles = [article for article_list in articles for article in article_list] #flatten list
	articles = clean_articles(articles)
	return articles

"""
def get_scientific_articles(keywords):
"""

#Concert raw html to list of relevant features
def clean_answers(answers):
	for i in range (len(answers)):
		answer = answers[i]
		id = answer.find("a", {"class": "code-nummer"}).getText()
		title = answer.findAll("a", href=True)[2].getText()
		date = answer.find("div", {"class": "card__pretitle"}).getText().strip()
		url = "https://tweedekamer.nl/"+answer.find("a", {"class": "document__button"})['href']
		snippet = answer.find("p").getText()
		answers[i] = [id, title, date, url, snippet]
	return answers

#Use queries to retrieve urls and metadata of related previous answers
def get_previous_answers(queries, fromdate, todate):
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
		print(len(articlecards))
		if len(articlecards) > prev_answers_to_find:
			answers.append(articlecards[:prev_answers_to_find])
			answers = [answer for answer_list in answers for answer in answer_list] #flatten list
			answers = clean_answers(answers)
			return answers
		else:
			answers.append(articlecards)
			prev_answers_to_find -= len(articlecards)
	answers = [answer for answer_list in answers for answer in answer_list] #flatten list
	answers = clean_answers(answers)
	return answers
		
def main(argv):
	keywords = argv[1]
	#fromdate = argv[2]
	#todate = argv[3]
	queries = create_queries(keywords)
	articles = get_news_articles(keywords, fromdate=None, todate=None)
	prev_answers = get_previous_answers(queries, fromdate=None, todate=None)
	for answer in prev_answers:
		print(answer, '\n')
	for article in articles:
		print(article, '\n')
	
if __name__ == "__main__":
	main(sys.argv)
	
#Potential query improvements
#-Drop keywords with weight less than 0.2
#-Try tf-idf corpus based on more documents
#Remove duplicates from results. Duplicates very likely because of query overlap