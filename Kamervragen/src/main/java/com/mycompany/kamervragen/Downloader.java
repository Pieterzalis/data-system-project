/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.mycompany.kamervragen;

import java.io.IOException;
import java.io.InputStream;
import java.net.MalformedURLException;
import java.net.URL;
import java.nio.file.Files;
import java.nio.file.Paths;
import java.nio.file.StandardCopyOption;
import java.util.logging.Level;
import java.util.logging.Logger;
import org.jsoup.Jsoup;
import org.jsoup.nodes.Document;
import org.jsoup.nodes.Element;
import org.jsoup.select.Elements;

/**
 *
 * @author flori
 */
public class Downloader {

    //static String url = "https://www.tweedekamer.nl/kamerstukken/kamervragen?qry=%22Infrastructuur+en+Waterstaat%22&fld_tk_categorie=kamerstukken&srt=date%3Adesc%3Adate&fld_prl_kamerstuk=Kamervragen&dpp=25&fld_prl_soort=Schriftelijke+vragen&clusterName=Kamerstukken&sta=1";
    static String url = "https://www.tweedekamer.nl/kamerstukken/kamervragen?qry=Infrastructuur+Waterstaat&fld_tk_categorie=kamerstukken&srt=date%3Adesc%3Adate&fld_prl_kamerstuk=Kamervragen&dpp=25&clusterName=Kamerstukken&sta=1&fld_prl_soort=Antwoord+schriftelijke+vragen";
    
    private static Questiondata getquestiondata(Element entry) {
        Questiondata questiondata = new Questiondata();
        questiondata.date = parsedate(entry.select("div.card__pretitle").get(0).text());
        questiondata.downloadlink = entry.select("a[href]").get(1).attr("href");
        questiondata.downloadlink = "https://tweedekamer.nl/" + questiondata.downloadlink;
        questiondata.topic = "\"" + entry.select("a[href]").get(2).text() + "\"";
        questiondata.id = entry.select(".code-nummer").text();
        questiondata.indiener = "\"" + entry.text().split("Indiener")[1].trim() + "\"";
        return questiondata;
    }

    private static String parsedate(String date) {
        String[] els = date.split(" ");
        String day = els[0];
        String year = els[2];
        String monthstring = els[1];
        String month = null;
        switch (monthstring) {
            case "jan":
                month = "1";
                break;
            case "feb":
                month = "2";
                break;
            case "mrt":
                month = "3";
                break;
            case "apr":
                month = "4";
                break;
            case "mei":
                month = "5";
                break;
            case "jun":
                month = "6";
                break;
            case "jul":
                month = "7";
                break;
            case "aug":
                month = "8";
                break;
            case "sep":
                month = "9";
                break;
            case "okt":
                month = "10";
                break;
            case "nov":
                month = "11";
                break;
            case "dec":
                month = "12";
                break;
        }
        return year + "-" + month + "-" + day;
    }

    public static void main(String[] Args) throws IOException {
        Document doc = Jsoup.connect(url).get();
        while (true) {
            Elements entries = doc.select("article.card");
            for (Element entry : entries) {
                Questiondata questiondata = getquestiondata(entry);
                downloadfile(questiondata.downloadlink, questiondata.id, questiondata.date);
                try {
                    Thread.sleep(5000);
                } catch (InterruptedException ex) {
                    Logger.getLogger(Downloader.class.getName()).log(Level.SEVERE, null, ex);
                }
                System.out.println(questiondata.id);
            }
            String nextpage = doc.select("a.read-more.next").attr("href");
            try {
                nextpage = "https://www.tweedekamer.nl/kamerstukken/kamervragen" + nextpage;
                doc = Jsoup.connect(nextpage).get();
            } catch (Exception e){
                break;
            }
        }
    }

    public static void downloadfile(String downloadlink, String id, String date) throws MalformedURLException, IOException {
        String[] downloadEls = downloadlink.split("\\.");
        String extension = downloadEls[downloadEls.length - 1];
        String targetmap = "C:\\Users\\flori\\Downloads\\vragenmetantwoorden\\";
        String filename = targetmap + id + "_ " + date + "." + extension;
        InputStream in = new URL(downloadlink).openStream();
        Files.copy(in, Paths.get(filename), StandardCopyOption.REPLACE_EXISTING);
    }
}
