package com.hrbot.hrbot.Answers;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

@RestController
public class AnswerController {
    @Autowired
    private AnswerService answerService;

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
}
