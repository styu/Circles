import java.util.*;
import java.io.*;

public class buildDB{
	public static void main(String[] args) throws IOException{
	    Scanner in = new Scanner(new File("data.txt"));
	    FileWriter promptStream = new FileWriter("prompts.txt");
	    BufferedWriter promptOut = new BufferedWriter(promptStream);
	    FileWriter choiceStream = new FileWriter("choice.txt");
	    BufferedWriter choiceOut = new BufferedWriter(choiceStream);
	    choiceOut.write("$SQL_STRING = \"INSERT INTO \'$db_info[choice_table](`text`, `character`, `distance`, `size`) VALUES");
	    choiceOut.newLine();
	    promptOut.write("$SQL_STRING = \"INSERT INTO \'$db_info[prompt_table]\' (`text`) VALUES");
            promptOut.newLine();
        
	    while (in.hasNextLine()){
	        String line = in.nextLine().trim();
	        String[] check = line.split(" ");
	        if (check[0].equals("prompt")){
	            promptOut.write("\t\t\t\t\t(\'"+line.substring(7)+"\'),");
	            promptOut.newLine();
	        }
	        else if (check[0].equals("choice")){

	            if (check[1].matches("[0-6]#-?[0-6]#-?[0-6]")){
	                String[] characters = check[1].split("#");
	                int start = check[0].length() + check[1].length()+2;
	                choiceOut.write("\t\t\t\t\t(\'"+line.substring(start)+"\', \'"+characters[0]+"\', \'"+characters[1]+"\', \'"+characters[2]+"\'),");
	                choiceOut.newLine();
	            }
	            else{
	                System.out.println(check[1]);
	                System.err.println("no point values found");
	            }
	        }
	        else{
	            System.err.println("line does not match anything. you fail");
	        }
	    }
	    choiceOut.close();
	    promptOut.close();
	}
}