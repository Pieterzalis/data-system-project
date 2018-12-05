/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.mycompany.kamervragen;

import java.io.*;
import java.util.ArrayList;
import java.util.List;
import org.apache.poi.xwpf.usermodel.XWPFDocument;
import org.apache.poi.xwpf.usermodel.XWPFParagraph;
import org.apache.pdfbox.pdmodel.PDDocument;
import org.apache.pdfbox.text.PDFTextStripper;
import org.apache.pdfbox.text.PDFTextStripperByArea;

/**
 *
 * @author flori
 */
public class Reader {
    
    public static void main (String [] Args) throws IOException{
        File path = new File("C:\\Users\\flori\\Downloads\\kamervragenI&W");
        File [] files = path.listFiles();
        for (int i = 0; i < files.length; i++)
            if (files[i].isFile()) //this line weeds out other directories/folders
                if (files[i].toString().endsWith("pdf"))
                    CSVWriter.write(readPDF(files[i]));
    }

    public static List<Questiondata> readPDF(File file) throws IOException {
        String id = file.getName().split("_")[0];
        System.out.println(id);
        String date = file.getName().split("_")[1].split("\\.")[0];
        List<Questiondata> results = new ArrayList<>();
        try (PDDocument document = PDDocument.load(file)) {
            document.getClass();
            if (!document.isEncrypted()) {
                PDFTextStripperByArea stripper = new PDFTextStripperByArea();
                stripper.setSortByPosition(true);
                PDFTextStripper tStripper = new PDFTextStripper();
                String pdfFileInText = tStripper.getText(document);
                String topic = "";
                try {
                    topic = pdfFileInText.substring(pdfFileInText.indexOf("over"))
                        .split("\\.")[0].replace("\n","").replace("\r","").replace("\"","'")
                        .replace(",","").replaceAll("\\(.*\\)", "").replaceFirst("over","").trim();
                } catch (Exception e){
                    topic = pdfFileInText.substring(pdfFileInText.indexOf("inzake"))
                        .split("\\.")[0].replace("\n","").replace("\r","").replace("\"","'")
                        .replace(",","").replaceAll("\\(.*\\)", "").replaceFirst("inzake","").trim();                        
                }
                String [] questions = pdfFileInText.split("Vraag ");
                for (int i = 1; i < questions.length; i++){
                    try {
                        Questiondata data = new Questiondata();
                        data.id = id;
                        data.date = date;
                        data.topic = topic;
                        questions[i] = questions[i].substring(questions[i].indexOf("\n"))
                                .substring(0,questions[i].lastIndexOf("?")).replace("\n","")
                                .replace("\r","").replace("\"","'").replace(",","").trim();
                        data.question = questions[i];
                        results.add(data);
                    } catch (Exception e){
                        System.out.println("error: "+questions[i].substring(questions[i].indexOf("\n")));
                    }
                }
            }
        }
        return results;
    }

    public static List<Questiondata> readWord(Questiondata basedata) {
        String id = basedata.id;
        List<Questiondata> results = new ArrayList<>();
        String targetmap = "C:\\Users\\flori\\Downloads\\kamervragen\\";
        String filename = targetmap + id + ".docx";
        try {
            File file = new File(filename);
            FileInputStream fis = new FileInputStream(file.getAbsolutePath());
            XWPFDocument document = new XWPFDocument(fis);
            List<XWPFParagraph> paragraphs = document.getParagraphs();
            for (int i = 0; i < paragraphs.size(); i++) {
                XWPFParagraph para = paragraphs.get(i);
                String paratext = para.getText();
                if (!"".equals(paratext.trim()) && (isNumeric(paratext) || isNumeric(paratext.split(" ")[1]))) { //then the next paragraph is a question
                    Questiondata data = new Questiondata();
                    data.id = basedata.id;
                    data.date = basedata.date;
                    data.indiener = basedata.indiener;
                    data.downloadlink = basedata.downloadlink;
                    data.topic = basedata.topic;
                    data.questionnumber = paratext.trim();
                    String question = paragraphs.get(i + 1).getText().trim(); //question
                    data.question = question.replace("\"", "\'").replace("\n", "").replace(",","");
                    System.out.println(data.question);
                    data.answer = "";
                    /*if (paragraphs.get(i+3).getText().contains("Antwoord") &&
                            isNumeric(paragraphs.get(i+3).getText().split("Antwoord")[1].split("\\.")[0]))
                        data.answer = "\""+paragraphs.get(i+4).getText().trim()+"\""; //answer
                    else
                        data.answer = "\""+paragraphs.get(i+3).getText().trim()+"\""; //answer */
                    results.add(data);
                }
            }
            fis.close();
        } catch (Exception e) {
            e.printStackTrace();
        }
        return results;
    }

    public static boolean isNumeric(String str) {
        for (char c : str.toCharArray())
            if (!Character.isDigit(c))
                return false;
        return true;
    }
}
