package com.hrbot.hrbot.Answers;

import javax.persistence.Entity;
import javax.persistence.Id;

@Entity
public class Answer {
    @Id
    private int id;
    private String body;
    private float rate;
    private boolean is_reviewed;
    private int archived_at;

    public Answer() {
        super();
    }

    public Answer(String body, float rate, boolean is_reviewed, int archived_at) {
        this.body = body;
        this.rate = rate;
        this.is_reviewed = is_reviewed;
        this.archived_at = archived_at;
    }

    public int getId() {
        return id;
    }

    public String getBody() {
        return body;
    }

    public void setBody(String body) {
        this.body = body;
    }

    public float getRate() {
        return rate;
    }

    public void setRate(float rate) {
        this.rate = rate;
    }

    public boolean isIs_reviewed() {
        return is_reviewed;
    }

    public void setIs_reviewed(boolean is_reviewed) {
        this.is_reviewed = is_reviewed;
    }

    public int getArchived_at() {
        return archived_at;
    }

    public void setArchived_at(int archived_at) {
        this.archived_at = archived_at;
    }
}
