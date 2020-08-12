## HRBot Backend

This is a backend webservice for the HRBot

## Steps for installation

1. First clone the repo and move to the folder created
```
git clone https://github.com/usamaeltmsah/HR-Bot-Backend.git && cd HR-Bot-Backend
```

2. Install the dependecies
```
composer install
```

3. Generate a laravel project key
```
php artisan key:generate
```

4. Migrate the database tables
```
php artisan migrate
```

5. Install passport
```
php artisan passport:install
```

6. [optional] seed the database with some data
```
php artisan db:seed
```

7. run the application
```
php artisan serve
```

## End points

+-----------+-------------------------------------------------------------------+
| Method    | URI                                                               |
+-----------+-------------------------------------------------------------------+
| GET|HEAD  | api/admin                                                         |
| POST      | api/admin/logout                                                  |
| DELETE    | api/admin/model_answers/{model_answer}                            |
| GET|HEAD  | api/admin/model_answers/{model_answer}                            |
| PUT|PATCH | api/admin/model_answers/{model_answer}                            |
| PUT|PATCH | api/admin/questions/{question}                                    |
| GET|HEAD  | api/admin/questions/{question}                                    |
| DELETE    | api/admin/questions/{question}                                    |
| POST      | api/admin/questions/{question}/model_answers                      |
| GET|HEAD  | api/admin/questions/{question}/model_answers                      |
| GET|HEAD  | api/admin/skills                                                  |
| POST      | api/admin/skills                                                  |
| DELETE    | api/admin/skills/{skill}                                          |
| PUT|PATCH | api/admin/skills/{skill}                                          |
| GET|HEAD  | api/admin/skills/{skill}                                          |
| POST      | api/admin/skills/{skill}/questions                                |
| GET|HEAD  | api/admin/skills/{skill}/questions                                |
| GET|HEAD  | api/applicant                                                     |
| GET|HEAD  | api/applicant/interviews                                          |
| GET|HEAD  | api/applicant/interviews/{interview}                              |
| GET|HEAD  | api/applicant/interviews/{interview}/questions                    |
| POST      | api/applicant/interviews/{interview}/questions/{question}/answers |
| POST      | api/applicant/interviews/{interview}/submit                       |
| GET|HEAD  | api/applicant/jobs                                                |
| POST      | api/applicant/jobs/{job}/apply                                    |
| POST      | api/applicant/logout                                              |
| GET|HEAD  | api/guest/jobs                                                    |
| POST      | api/login                                                         |
| GET|HEAD  | api/recruiter                                                     |
| PUT       | api/recruiter/answers/{answer}/score                              |
| GET|HEAD  | api/recruiter/interviews/{interview}                              |
| PUT       | api/recruiter/interviews/{interview}/status                       |
| GET|HEAD  | api/recruiter/jobs                                                |
| POST      | api/recruiter/jobs                                                |
| DELETE    | api/recruiter/jobs/{job}                                          |
| GET|HEAD  | api/recruiter/jobs/{job}                                          |
| PUT       | api/recruiter/jobs/{job}                                          |
| GET|HEAD  | api/recruiter/jobs/{job}/interviews                               |
| POST      | api/recruiter/logout                                              |
| GET|HEAD  | api/recruiter/questions                                           |
| GET|HEAD  | api/recruiter/questions/{question}                                |
| GET|HEAD  | api/recruiter/skills                                              |
| GET|HEAD  | api/recruiter/skills/{skill}                                      |
| POST      | api/register                                                      |
| POST      | oauth/authorize                                                   |
| DELETE    | oauth/authorize                                                   |
| GET|HEAD  | oauth/authorize                                                   |
| POST      | oauth/clients                                                     |
| GET|HEAD  | oauth/clients                                                     |
| DELETE    | oauth/clients/{client_id}                                         |
| PUT       | oauth/clients/{client_id}                                         |
| GET|HEAD  | oauth/personal-access-tokens                                      |
| POST      | oauth/personal-access-tokens                                      |
| DELETE    | oauth/personal-access-tokens/{token_id}                           |
| GET|HEAD  | oauth/scopes                                                      |
| POST      | oauth/token                                                       |
| POST      | oauth/token/refresh                                               |
| GET|HEAD  | oauth/tokens                                                      |
| DELETE    | oauth/tokens/{token_id}                                           |
+-----------+-------------------------------------------------------------------+

## useful commands

To create an admin user run the following command:
```
php artisan make:admin
```

## Security Vulnerabilities

If you discover a security vulnerability within HRBot, please send an e-mail to Sherif Tarek via [sherift1552@gmail.com](mailto:sherift1552@gmail.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
