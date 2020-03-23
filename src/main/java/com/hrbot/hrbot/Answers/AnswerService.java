package com.hrbot.hrbot.Answers;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.SQLException;

@Service
public class AnswerService {
    @Autowired
    private AnswerRepo answerRepo;
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
