 Symfony 4 Sample api
 ========================
 - [Introduction](#introduction) 
 - [Installation](#installation) 
 - [Run unit tests](#run-unit-tests) 
 - [Run functional tests(written in behat, separate repo)](#run-functional-tests) 
 - [Sample requests in different formats](#sample-requests) 
 - [Swagger file for the api documentation](#swagger-file-for-the-api-documentation) 
 
 # Introduction
 This project is a bare-metal symfony 4 project. Api currently provide only to create a resource Job.
 Installation will show how to run the project via php built-in web server. Assumes there are no any other application using the 8000 port and you have php version > 7.1.0 
 
 # Installation
 Here we gonna clone/download 2 repositories, api and the behat tests and install its dependencies.
 - Note: api will run the in the **dev** mode and functional tests will run in the **test** mode 
  ```sh
 $ cd your-favorite-folder
 $ git clone git@github.com:ntwobike/mhapi.git api
 $ git clone git@github.com:ntwobike/mhapi-behat.git api-behat-tests
 
 $ # install dependencies for the api
 $ cd api
 $ composer install
 
 $ # open the .env file and the set
 $ # APP_ENV=dev 
 $ # DATABASE_URL 
 $ # create the database
 $ bin/console doctrine:database:create
 
 $ # run the migration
 $ bin/console doctrine:migrations:migrate
  
 $ # load the fitures
 $ bin/console  doctrine:fixtures:load
 
 $ # All good now, let's run the api
 $ bin/console server:start
 
 $ ##Lets set up different database for functional tests
 $ # open the .env file and the set
 $ # APP_ENV=test 
 $ # TEST_DATABASE_URL
 $ # create the database for tests
 $ bin/console doctrine:database:create
  
 $ # run the migration
 $ bin/console doctrine:migrations:migrate
   
 $ # load the fitures
 $ bin/console  doctrine:fixtures:load
 
 $ # install dependencies for the api-behat-tests
 $ cd api-behat-tests
 $ composer install
  
 $ # Done! 
 ``` 
 
 # Run unit tests
 ```sh
 $ cd api
 $ bin/phpunit
 ```
 
 # Run functional tests
 ```sh
 $ cd api-behat-tests
 $ # change base_url in behat.yml to api url: http://127.0.0.1:8000
 $ ./vendor/bin/behat
 ```
 
 # Sample requests
 
 - curl
 ```sh
  $ cd api
  $ curl -X POST "http://localhost:8000/api/jobs" -H "accept: application/json" -H "Content-Type: application/json" -d "{ \"title\": \"Paint it black\", \"description\": \"I see a red door and I want it painted black\", \"zipcode\": \"21521\", \"category_id\":804040, \"due_date\": \"2018-09-01T20:50:39\"}"
  ```
 - json
 ```json
 {
    "title": "Paint it black",
    "description": "I see a red door and I want it painted black",
    "zipcode": "21521",
    "category_id": 804040, 	
    "due_date": "2020-12-05T01:02:03+00:00"
 }
 ```
 
 # Swagger file for the api documentation
 ```json
 {
   "swagger": "2.0",
   "info": {
     "description": "MyHammer API",
     "version": "1.0.0",
     "title": "MyHammer API"
   },
   "host": "localhost:8000",
   "basePath": "/api",
   "tags": [
     {
       "name": "jobs",
       "description": "Operations about Job resource"
     }
   ],
   "schemes": [
     "http"
   ],
   "paths": {
     "/jobs": {
       "post": {
         "summary": "Add a new Job",
         "consumes": [
           "application/json"
         ],
         "produces": [
           "application/json"
         ],
         "parameters": [
           {
             "in": "body",
             "name": "body",
             "description": "Job object that needs to be create",
             "required": true,
             "schema": {
               "$ref": "#/definitions/Job"
             }
           }
         ],
         "responses": {
           "201": {
             "description": "Successfully created",
             "schema": {
               "$ref": "#/definitions/Job"
             },
             "examples": {
               "PaintItBlack": {
                 "title": "Paint it black",
                 "description": "I see a red door and I want it painted black",
                 "zipcode": "21521",
                 "category_id": 804040,
                 "due_date": "2018-09-01T20:50:39",
                 "created_by": 1
               }
             }
           },
           "400": {
             "description": "Bad request: wrong payload",
             "schema": {
               "$ref": "#/definitions/ErrorResponse"
             },
             "examples": {
               "TitleInvalid": {
                 "code": "400",
                 "message": "Validation Failed",
                 "errors": {
                   "children": {
                     "title": {
                       "errors": [
                         "Title cannot be empty"
                       ]
                     },
                     "description": [],
                     "due_date": [],
                     "category_id": [],
                     "zipcode": [],
                     "created_by": []
                   }
                 }
               }
             }
           }
         }
       }
     }
   },
   "definitions": {
     "Job": {
       "type": "object",
       "required": [
         "title",
         "description",
         "zipcode",
         "category_id",
         "due_date"
       ],
       "properties": {
         "title": {
           "type": "string",
           "minLength": 5,
           "maxLength": 50,
           "description": "Must be between 5 and 50 characters"
         },
         "description": {
           "type": "string",
           "description": "Description about the Job"
         },
         "zipcode": {
           "type": "string",
           "maxLength": 5,
           "minLength": 5,
           "description": "Valid German Zipcode"
         },
         "category_id": {
           "type": "integer",
           "format": "int64",
           "description": "Valid Category id"
         },
         "due_date": {
           "type": "string",
           "format": "date-time"
         }
       }
     },
     "ErrorResponse": {
       "type": "object",
       "properties": {
         "code": {
           "type": "string",
           "description": "Status code:400"
         },
         "message": {
           "type": "string",
           "description": "General description about the error"
         },
         "errors": {
           "$ref": "#/definitions/Error"
         }
       }
     },
     "Error": {
       "type": "object",
       "properties": {
         "children": {
           "$ref": "#/definitions/ErrorChildren"
         }
       }
     },
     "ErrorChildren": {
       "type": "object",
       "properties": {
         "property_name_1": {
           "$ref": "#/definitions/ErrorChild"
         },
         "property_name_2_without_error": {
           "type": "array",
           "items": {
             "type": "string"
           },
           "example": []
         }
       }
     },
     "ErrorChild": {
       "type": "object",
       "properties": {
         "errors": {
           "type": "array",
           "items": {
             "type": "string"
           }
         }
       }
     }
   }
 }
 ```