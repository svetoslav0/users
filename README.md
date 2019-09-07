# Users
#### Simple application where users can register, login, upload their profile picture and see everyone else.

***Features:***
-

- Register
- Login
- Upload and Change Profile Picture
- Edit Profile Data and Password
- Validations
    - Login, Register and Edit profile
    - Uploading a Profile Picture
    - Reaching Specific URL
- List All Users in a Table With Pagination

To make an account, a user should register in the application. 
All input fields - email, name, surname, password and confirm password, are required. 
When the user confirms his data, the fields are validated. 
The email should be valid and unique (creating of two accounts with same emails is forbidden). 
The password must be longer than 6 characters and must match the confirming password. 
The name and the surname cannot nothing but letters.
The password is encrypted before it is inserted in the database for security reasons.
If some of these fields is wrong, the validation algorithm will fail and error messages will appear explaining exactly what is wrong.

To login, a user must type his email and password. 
If some of them is wrong, an error message will appear that tells the user that his credentials are wrong.
After successful login the user enters in the dashboard.

Every user has a default profile picture, but everyone can change his at any moment.
To do that he/she should go to 'Upload Picture' page, choose a picture from his/her computer and click the 'Upload' button.
The uploaded file must follow some rules: the file must be a picture and must not be more than 1.8MB. 
Otherwise an error message will appear and the file will not be uploaded.

A user can also change the data that he/she type in the registration form.
To do that, he/she should navigate to 'Edit Profile' page, change his/her data and submit it.
If something is wrong - the email is not unique (unless it is the same), the name or the surname are containing characters that are different from letters, the an error message will appear again.

To change his/her password, the user must type his current (old) password and the new password (and of course to confirm it).
Just like every other input form - an error message will appear if something is wrong.

If user tries to enter some URL, another validation is done.
If he/she tries to reach some page that requires to be logged but he/she is not, then the user is redirected to the 'Login' page.
If user tries to reach a page that does not exist, a default 404 page will be displayed.

An application also provides opportunity to view all registered users with pagination.

***Used Technologies:***
-

- **PHP**
- **CodeIgniter**
- **Bootstrap**
- **HTML/CSS**