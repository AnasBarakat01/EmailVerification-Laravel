When user create an account in your website, you have to ensure that he own the email address he has entered, and he can access this email address.
We perform  that through sending an activation link to his email address.
He has to press this link to verify his account.

                                      First step : Design Signup page using HTML, CSS and JavaScript
![image](https://github.com/AnasBarakat01/EmailVerification-Laravel/assets/155667484/a8fee439-67f8-4646-9609-5e9227dd3ccf)

![image](https://github.com/AnasBarakat01/EmailVerification-Laravel/assets/155667484/2485dafd-39e8-4591-a0d2-5fd8cac3d83f)


•	Putting HTML elements beside each others through CSS.

•	I used CSS to design list of errors provided to user when entered data is invalid.

•	I used JavaScript to preview chosen image from user.

•	Prevent frequent submissions of the form through disabling the submit button after one click (JavaScript).

•	The “address” filed has two select elements connected to each other using JavaScript.



                                            Second step : edit “users” table using migration

Add the following columns to "users" table : 

a) verified : "0" -> meaning this account is not verified yet (default value).  "1" -> this account is verified.

b) activation_code.

c) activation_expiry : the activation_code is valid only for one day.

