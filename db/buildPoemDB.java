import java.util.*;
import java.io.*;

public class buildPoemDB{
	public static void main(String[] args) throws IOException{
		Scanner in = new Scanner(new File("poem.txt"));
		FileWriter filestream = new FileWriter("promptPoems.txt");
	    BufferedWriter out = new BufferedWriter(filestream);
		int cnt = 1;
		while (in.hasNextLine()){
			String input = in.nextLine().trim().replaceAll("\'", "\\\\\'");
			String output = String.format("mysql_query(\"UPDATE `prompts` SET poem = \'%s\' WHERE id = \'%06d\'\", $link);",  input, cnt++);
			out.write(output);
			out.newLine();
		}
		out.close();
	}
}