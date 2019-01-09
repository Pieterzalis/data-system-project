#Script used to construct a Bag of Words for tf_idf based on the corpus in the path provided

import os
from os.path import join
import PyPDF2
import sys
import json
from nltk.corpus import stopwords
import re
from gensim.corpora.dictionary import Dictionary

path = 'C:\\Users\\flori\\Downloads\\kamervragenI&W' #path to directory with kamervragen files
files = [join(path,file) for file in os.listdir(path)] #create list of filenames

#given file path to pdf, return content as string
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

#make list of cleaned words on all texts in corpus
def make_token_list():
	token_list = []
	for file in files:
		try:
			text = read_doc(file)
			text = text.lower()
			text = re.sub(r'-\n','',text) # handle dashes breaking up words at end of line
			text = re.sub("'",' ',text).replace('_', ' ')
			text = re.sub(r'[^A-Za-z^-]', ' ', text)
			text = re.sub(r'\s+', ' ', text)
			words = [word for word in text.split() if word not in stopwords.words('dutch') and len(word) > 2]
			token_list.append(words)
		except:
			print(file)
	return token_list

#Create and store corpus and dictionary on kamervragen files	
def main(argv):
	token_list = make_token_list()
	dictionary = Dictionary(token_list)
	corpus = [dictionary.doc2bow(doc_tokens) for doc_tokens in token_list]
	dictionary.save('dictionary.dict')
	with open('corpus.json', 'w') as out:
		json.dump(corpus, out)
		
if __name__ == "__main__":
	main(sys.argv)
