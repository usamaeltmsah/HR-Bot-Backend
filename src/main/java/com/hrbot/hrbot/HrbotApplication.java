package com.hrbot.hrbot;

import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

@RestController
@SpringBootApplication
public class HrbotApplication {

    public static void main(String[] args) {
        SpringApplication.run(HrbotApplication.class, args);
    }

    @RequestMapping("/send_answer")
    public double evalAnswer(String answer) {
        double score = 0.0;

        /*
         *
         * ToDo: Receive score from evalModel, and save it in score variable
         *
         * */

        return score;
    }

}
