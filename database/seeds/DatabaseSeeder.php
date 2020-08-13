<?php

use App\Skill;
use App\User;
use App\Question;
use App\ModelAnswer;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $questions = ["What is a Primary key?", "What is a Unique key?", "What is a Foreign key?", "What do you mean by data integrity?", "What is the difference between clustered and non clustered index in SQL?", "What do you mean by Denormalization?", "What is an Index?", "What do you mean by 'Trigger' in SQL?", "What is the difference between cross join and natural join?", "What is the need of MERGE statement?"];

        $answers = [["uniquely identifies each record in a table", "must contain UNIQUE values, and cannot contain NULL values", "A table can have only ONE primary key; and in the table, this primary key can consist of single or multiple columns (fields)"], ["is a set of one or more than one fields / columns of a table that uniquely identify a record in a database table", "it is little like primary key but it can accept only one null value and it cannot have duplicate values", "The unique key and primary key both provide a guarantee for uniqueness for a column or a set of columns", "There is an automatically defined unique key constraint within a primary key constraint", "There may be many unique key constraints for one table, but only one PRIMARY KEY constraint for one table"], ["a key used to link two tables together", "a field (or collection of fields) in one table that refers to the PRIMARY KEY in another table", "The table containing the foreign key is called the child table, and the table containing the candidate key is called the referenced or parent table"], ["Data Integrity defines the accuracy as well as the consistency of the data stored in a database. It also defines integrity constraints to enforce business rules on the data when it is entered into an application or a database"], ["Clustered index is used for easy retrieval of data from the database and its faster whereas reading from non clustered index is relatively slower", "Clustered index alters the way records are stored in a database as it sorts out rows by the column which is set to be clustered index whereas in a non clustered index, it does not alter the way it was stored but it creates a separate object within a table which points back to the original table rows after searching"], ["refers to a technique which is used to access data from higher to lower forms of a database. It helps the database managers to increase the performance of the entire infrastructure as it introduces redundancy into a table. It adds the redundant data into a table by incorporating database queries that combine data from various tables into a single table"], ["refers to a performance tuning method of allowing faster retrieval of records from the table. An index creates an entry for each value and hence it will be faster to retrieve data"], ["are a special type of stored procedures that are defined to execute automatically in place or after data modifications. It allows you to execute a batch of code when an insert, update or any other query is executed against a specific table"], ["produces the cross product or Cartesian product of two tables whereas the natural join is based on all the columns having the same name and data types in both the tables"], ["This statement allows conditional update or insertion of data into a table. It performs an UPDATE if a row exists, or an INSERT if the row does not exist"]];

        $skill = Skill::create(['name' => 'relational databases']);
        foreach ($questions as $index => $question) {
            $question = $skill->questions()->create(['body' => $question]);

            foreach ($answers[$index] as $answer) {
                $question->modelAnswers()->create(['body' => $answer]);    
            }
        }
    }
}
