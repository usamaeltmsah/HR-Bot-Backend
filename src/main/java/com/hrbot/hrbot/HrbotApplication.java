package com.hrbot.hrbot;

import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.SQLException;

@RestController
@SpringBootApplication
public class HrbotApplication {

	public static void main(String[] args) {
		SpringApplication.run(HrbotApplication.class, args);
	}

    @RequestMapping("/eval_answer")
    public double evalAnswer(String answer)
    {
        double score = 0.0;

        /*
        *
        * ToDo: Receive score from evalModel, and save it in score variable
        *
        * */

        return score;
    }

    public boolean saveScoreToDB(double score, Connection conn, int cand_id) throws SQLException {
        boolean saved = false;
        PreparedStatement query = conn.prepareStatement("UPDATE 'candidate' SET 'score' = "+ score + " WHERE 'candidat_id' = + cand_id + ");
        int count = query.executeUpdate();
        /*
         * ToDo: Create the database and check the UPDATE query
         * */

        // If update done set saved to true
        if(count > 0)
        {
            saved = true;
        }
        else
        {
            System.err.println("Error in Database !!");
        }
        return saved;
    }

}
