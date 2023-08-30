# Quiz Wiz Project
Welcome to the Quiz Wiz project setup guide. This project is designed to run using Docker and consists of two containers: one for PHP and another for PostgreSQL. Below are the steps to set up and run the Quiz Wiz project on your local machine.  

### Prerequisites
Before you begin, make sure you have the following software installed:
- Docker
- PgAdmin (to manage the PostgreSQL database)

### Clone the Repository
1. Clone this repository to your local machine using Git:  
```git clone <repository_url>```
2. Navigate to the project directory:  
```cd Quiz-Wiz-Project```

### Start the Project
1. Ensure that Docker is installed and running on your machine. 
2. In the project directory, you will find the docker-compose.yml file. 
3. Start the project by running the following Docker Compose command:  
```docker-compose up -d```  
   This command will start the containers in detached mode (-d), allowing them to run in the background.

### Create Database Tables
1. After starting the project, you need to create the required database tables. The SQL queries for creating these tables can be found in the file ```resources/sql_scripts/tables_create.sql```.
2. Open PgAdmin to manage the PostgreSQL database.
3. Register a new server in PgAdmin with the following configurations:
```
        Name: quizwiz-db
        Hostname: localhost
        Port: 5432
        Maintenance Database: quizWiz
        Username: quizWiz
        Password: 12345
```
4. Once the server is registered, execute the SQL queries from ```tables_create.sql``` using PgAdmin to create the necessary database tables.

    **Note:** You only need to run these queries the first time you set up the project or if you delete the tables from the database.

### Access the Application
With the containers up and the tables created, you can access the Quiz Wiz application in your web browser at http://localhost:8000.

### TODO -> Example data create and login informations 


### Additional Information
For more detailed instructions and further information, please consult the project documentation. This project is licensed under the MIT License.  

Please remember that this guide is a simplified version. Refer to the original project documentation for comprehensive instructions and troubleshooting tips.

Reference: Original Documentation Link


