# Quiz Wiz Project
Welcome to the Quiz Wiz project guide documentation. This project is designed to run using Docker and consists of two containers: one for PHP and another for PostgreSQL. Below are the steps to set up and run the Quiz Wiz project on your local machine.  

### Prerequisites
Before you begin, make sure you have the following software installed:
- Docker
- Postgres & PgAdmin (to manage the PostgreSQL database)

### Clone the Repository
1. Clone this repository to your local machine using Git:  
```git clone https://github.com/hamsiHftm/IN241_QuizWiz.git```
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
        Port: 5435
        Maintenance Database: quizWiz
        Username: quizWiz
        Password: 12345
```
4. Once the server is registered, execute the SQL queries from ```tables_create.sql``` using PgAdmin to create the necessary database tables.

    **Note:** You only need to run these queries the first time you set up the project or if you delete the tables from the database.

### Access the Application
With the containers up and the tables created, you can access the Quiz Wiz application in your web browser at http://localhost:8000.

### Create our own data

To explore the application's functionality, you can create your own data by registering new users and playing quizzes from different user accounts. Here's how you can get started:

1. **Registration:** Navigate to the registration page on the Quiz Wiz application by visiting http://localhost:8000/RegisterPage.php. You can register new users with different usernames and personal information.

2. **Login:** After registering, you can log in with the newly created user accounts by visiting http://localhost:8000/LoginPage.php. Use the credentials you provided during registration to log in.

3. **Quiz Gameplay:** Once logged in, you can start playing quizzes with your user account. Explore the quiz questions and answer them in real-time.

By creating your own data and logging in with different user accounts, you can experience the full range of features and functionality that the Quiz Wiz application offers. Enjoy your experience!

### Example Data and Login Information

You can quickly populate the application with example data by executing the `data_create.sql` script provided with the project. This script will insert sample data into the database, including users and quiz-related information.

To do this, follow these steps:

1. **Run the SQL Script:** Execute the `data_create.sql` script using a database management tool or command-line interface to populate the database with example data.

2. **Password Setup:** After running the script, you can log in using the example user accounts created by the script. However, you'll need to set a password for each user initially. To do this, visit the "Forget Password" page at http://localhost:8000/ForgetPasswordPage.php. Follow the instructions to reset your password.

3. **Login:** Once you've set your password, log in using your username and the newly set password at http://localhost:8000/LoginPage.php.

4. **Quiz Gameplay:** After successfully logging in, you can start playing quizzes with the example user accounts. Explore the quiz questions and answer them in real-time.

Using the `data_create.sql` script allows you to quickly set up the application with sample data for testing and exploration.


## Directory Structure

- **Dockerfile:** Configuration file for building a Docker container for the QuizWiz application.
- **README.md:** This documentation file.
- **docker-compose.yml:** Docker Compose configuration for managing the application's containers.
- **resources:** Directory for storing various resources.
   - **sql_scripts:** Contains SQL scripts for creating database tables (`tables_create.sql` & `data_create.sql`).
- **src:** The main source code directory.
   - **app:** Contains the core application code.
      - **components:** Reusable components used in the application's pages.
      - **controllers:** PHP controllers that handle application logic. (`APIController.php` & `AuthController.php` & `DBController.php`).
      - **models:** PHP models representing various entities, including database entities, API entities, and other properties used for functionality within the application. These models encapsulate data and behavior related to different parts of the application.
     - **pages:** PHP files responsible for rendering different web pages within the QuizWiz application. These PHP files serve as both the rendering templates for specific pages and determine the navigation URLs for the application since navigation is not implemented in this version.
       - **AboutUsPage.php:** Page displaying information about the QuizWiz project.
       - **ChangePasswordProfilePage.php:** PHP script responsible for handling user password changes. Upon successful completion of the password change operation, this script redirects the user to the profile page.
       - **ErrorPage.php:** Page for displaying user friendly error messages.
       - **ForgetPasswordPage.php:** Page for handling password recovery.
       - **HomePage.php:** The main landing page of the application.
       - **ImpressumPage.php:** Page containing legal information or impressum.
       - **LogOutPage.php:** PHP script responsible for handling user logout. Upon successful logout, this script redirects the user to the home page.
       - **LoginPage.php:** Page for user login.
       - **ProfilePage.php:** User profile page.
       - **QuizQuestionPage.php:** PHP script responsible for dynamically displaying quiz questions during gameplay. It facilitates the presentation of quiz questions in real-time or on a per-question basis during the quiz playing mode.
       - **QuizStartPage.php:** Page for starting a quiz.
       - **RegisterPage.php:** Page for user registration.
       - **SaveUserInfoProfilePage.php:** PHP script responsible for saving user profile information and redirecting the user to their profile page upon successful completion.
       - **ScorePage.php:** Page for displaying quiz score after a quiz finished.
     - **services:** PHP classes providing various services (For this version: API interaction, database access).
   - **assets:** Static assets used in the application.
      - **bootstrap:** Bootstrap CSS and JavaScript files.
      - **css:** Custom CSS styles for different parts of the website.
      - **img:** Image files used in the application.
- **config.php:** Global configuration file for the QuizWiz application. (Database & API Configs)
- **index.php:** The entry point of the QuizWiz application.

### Additional Information
For more detailed instructions and further information, please consult the project documentation. This project is licensed under the MIT License.  

Please remember that this guide is a simplified version. Refer to the original project documentation for comprehensive instructions and troubleshooting tips.

Reference: Original Documentation Link


