# BINFO twitter internships

this project is a Twitter-like chat application that provides a communication channel associated with BINFO internships.

## Description

In this project, I implemented all the required functionalities and one bouns (filter messages by dates).

Admins can:
1. manage all users (students, supervisors and new admins): can create, modify and disable/enable
2. manage internships: can create, modify and delete
3. read and send messages in every internship channel page

Users can:
1. enroll/unenroll from specific internship (up to 1). while enrolled, can view and write new messages (messages can be view only by students and supervisors who dedicated to this specific internship) and admin.
2. View all internships details 

Supervisors can:
1. View all internships details 
2. view and write messages from his internship (assign by the admin)

*all messages can be filtered by dates - Bonus part

## Run

1. Unzip the file
2. Import the SQL dump webprog.sql to MySQL DB
3. run docker-compose up
4. Navigate to http://localhost/twitter-final-project/project/

how to log in:
the DB includes 3 built-in users registered.
1. admin user (username: "vm" password: "vm)
2. student user (username: "student1" password: "student1")
3. lecturer user (username: "lecturer1" password: "lecturer1")
