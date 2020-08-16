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

3. Copy the enviroment varaibales file template
```
cp .env.example .env
```

4. Set your own enviroment variables, replace the following pseudo variables with your values in the following commands, then execute them from the terminal:

- `YOUR_DATABASE_HOST_HERE`
- `YOUR_DATABASE_NAME_HERE`
- `YOUR_DATABASE_USERNAME_HERE`
- `YOUR_DATABASE_PASSWORD_HERE`

```
sed -i "s/DB_HOST=.*/DB_HOST=YOUR_DATABASE_HOST_HERE/" .env
sed -i "s/DB_DATABASE=.*/DB_DATABASE=YOUR_DATABASE_NAME_HERE/" .env
sed -i "s/DB_USERNAME=.*/DB_USERNAME=YOUR_DATABASE_USERNAME_HERE/" .env
sed -i "s/DB_PASSWORD=.*/DB_PASSWORD=YOUR_DATABASE_PASSWORD_HERE/" .env
```

5. Generate a laravel project key
```
php artisan key:generate
```

6. Migrate the database tables
```
php artisan migrate
```

7. Install passport
```
php artisan passport:install
```

8. [optional] seed the database with some data
```
php artisan db:seed
```

9. run the application
```
php artisan serve
```


## Useful commands

To create an admin user run the following command:
```
php artisan make:admin
```


## End points

|Method | URI|                                                        
|---|---|
| **GET or HEAD**  | api/admin                                                         |
| **POST**      | api/admin/logout                                                  |
| **DELETE**    | api/admin/model_answers/{model_answer}                            |
| **GET or HEAD**  | api/admin/model_answers/{model_answer}                            |
| ****PUT** or PATCH** | api/admin/model_answers/{model_answer}                            |
| ****PUT** or PATCH** | api/admin/questions/{question}                                    |
| **GET or HEAD**  | api/admin/questions/{question}                                    |
| **DELETE**    | api/admin/questions/{question}                                    |
| **POST**      | api/admin/questions/{question}/model_answers                      |
| **GET or HEAD**  | api/admin/questions/{question}/model_answers                      |
| **GET or HEAD**  | api/admin/skills                                                  |
| **POST**      | api/admin/skills                                                  |
| **DELETE**    | api/admin/skills/{skill}                                          |
| ****PUT** or PATCH** | api/admin/skills/{skill}                                          |
| **GET or HEAD**  | api/admin/skills/{skill}                                          |
| **POST**      | api/admin/skills/{skill}/questions                                |
| **GET or HEAD**  | api/admin/skills/{skill}/questions                                |
| **GET or HEAD**  | api/applicant                                                     |
| **GET or HEAD**  | api/applicant/interviews                                          |
| **GET or HEAD**  | api/applicant/interviews/{interview}                              |
| **GET or HEAD**  | api/applicant/interviews/{interview}/questions                    |
| **POST**      | api/applicant/interviews/{interview}/questions/{question}/answers |
| **POST**      | api/applicant/interviews/{interview}/submit                       |
| **GET or HEAD**  | api/applicant/jobs                                                |
| **POST**      | api/applicant/jobs/{job}/apply                                    |
| **POST**      | api/applicant/logout                                              |
| **GET or HEAD**  | api/guest/jobs                                                    |
| **POST**      | api/login                                                         |
| **GET or HEAD**  | api/recruiter                                                     |
| **PUT**       | api/recruiter/answers/{answer}/score                              |
| **GET or HEAD**  | api/recruiter/interviews/{interview}                              |
| **PUT**       | api/recruiter/interviews/{interview}/status                       |
| **GET or HEAD**  | api/recruiter/jobs                                                |
| **POST**      | api/recruiter/jobs                                                |
| **DELETE**    | api/recruiter/jobs/{job}                                          |
| **GET or HEAD**  | api/recruiter/jobs/{job}                                          |
| **PUT**       | api/recruiter/jobs/{job}                                          |
| **GET or HEAD**  | api/recruiter/jobs/{job}/interviews                               |
| **POST**      | api/recruiter/logout                                              |
| **GET or HEAD**  | api/recruiter/questions                                           |
| **GET or HEAD**  | api/recruiter/questions/{question}                                |
| **GET or HEAD**  | api/recruiter/skills                                              |
| **GET or HEAD**  | api/recruiter/skills/{skill}                                      |
| **POST**      | api/register                                                      |
| **POST**      | oauth/authorize                                                   |
| **DELETE**    | oauth/authorize                                                   |
| **GET or HEAD**  | oauth/authorize                                                   |
| **POST**      | oauth/clients                                                     |
| **GET or HEAD**  | oauth/clients                                                     |
| **DELETE**    | oauth/clients/{client_id}                                         |
| **PUT**       | oauth/clients/{client_id}                                         |
| **GET or HEAD**  | oauth/personal-access-tokens                                      |
| **POST**      | oauth/personal-access-tokens                                      |
| **DELETE**    | oauth/personal-access-tokens/{token_id}                           |
| **GET or HEAD**  | oauth/scopes                                                      |
| **POST**      | oauth/token                                                       |
| **POST**      | oauth/token/refresh                                               |
| **GET or HEAD**  | oauth/tokens                                                      |
| **DELETE**    | oauth/tokens/{token_id}                                           |

## Security Vulnerabilities

If you discover a security vulnerability within HRBot, please send an e-mail to Sherif Tarek via [sherift1552@gmail.com](mailto:sherift1552@gmail.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
