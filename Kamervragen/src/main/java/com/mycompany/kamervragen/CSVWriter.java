/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.mycompany.kamervragen;

import java.io.File;
import java.io.FileNotFoundException;
import java.io.FileWriter;
import java.io.IOException;
import java.util.List;

/**
 *
 * @author flori
 */
public class CSVWriter {
    
    public static void write(List<Questiondata> datalist) throws FileNotFoundException, IOException{
        String target = "C:\\Users\\flori\\Downloads\\questionsI&WwithTopic.csv";
        FileWriter pw = new FileWriter(new File(target), true);
        StringBuilder sb = new StringBuilder();
        for (Questiondata data : datalist){
            sb.append(data.id);
            sb.append(',');
            sb.append(data.date);
            sb.append(',');
            sb.append(data.topic);
            sb.append(',');
            /*sb.append(data.indiener);
            sb.append(',');
            sb.append(data.questionnumber);
            sb.append(',');*/
            sb.append(data.question);
            //sb.append(',');
            //sb.append(data.answer);
            sb.append('\n');
        }
        pw.write(sb.toString());
        pw.close();
    }
    
}
