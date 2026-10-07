**Tasks for Today**



A CodeIgniter 4 task management app based on TS1, with public task/profile/about pages and authenticated task management.



**What is CodeIgniter?**



CodeIgniter is a PHP full-stack web framework that is light, fast, flexible and secure.

More information can be found at the \[official site](https://codeigniter.com).



This repository holds a composer-installable app starter.

It has been built from the

*\[development repository](https://github.com/codeigniter4/CodeIgniter4)*.



More information about the plans for version 4 can be found in *\[CodeIgniter 4](https://forum.codeigniter.com/forumdisplay.php?fid=28)* on the forums.



You can read the *\[user guide](https://codeigniter.com/user\_guide/)*

corresponding to the latest version of the framework.



**Installation \& updates**



composer create-project codeigniter4/appstarter then composer update whenever there is a new release of the framework.



When updating, check the release notes to see if there are any changes you might need to apply to your app folder. The affected files can be copied or merged from vendor/codeigniter4/framework/app.



**Setup**



**For localhost:** (For peeps who want to experiment with the system I built)

1\. Create a MySQL database and configure the default connection in *.env* *(database.default.\*)*.

2\. From this directory, run:



&#x09;**powershell**

&#x09;php spark migrate

&#x09;php spark db:seed DemoSeeder

&#x09;php spark serve



3\. Open the local URL printed by spark serve.



For users who want to test the web app it is already hosted at:


https://task-manager-omega.infinityfreeapp.com/



The demo login is demo / `TaskDemo123!`. Its password is stored as a password hash. The seed creates two sample tasks and can be run again without duplicating the demo user or tasks.



Welcome, All Tasks, Profile, and About are public. Creating, editing, archiving (the Delete action), and changing task status require a signed-in session. Archived tasks remain in the database and are excluded from both task views.



Run the focused app tests with *vendor/bin/phpunit tests/feature/TaskManagementTest.php*.



**Important Change with index.php**



index.php is no longer in the root of the project! It has been moved inside the \*public\* folder, for better security and separation of components.



This means that you should configure your web server to "point" to your project's \*public\* folder, and not to the project root. A better practice would be to configure a virtual host to point there. A poor practice would be to point your web server to the project root and expect to enter \*public/...\*, as the rest of your logic and the framework are exposed.



\*\*Please\*\* read the user guide for a better explanation of how CI4 works!



**Repository Management**



We use GitHub issues, in our main repository, to track \*\*BUGS\*\* and to track approved \*\*DEVELOPMENT\*\* work packages.

We use our \[forum](http://forum.codeigniter.com) to provide SUPPORT and to discuss FEATURE REQUESTS.



This repository is a "distribution" one, built by our release preparation script.Problems with it can be raised on our forum, or as issues in the main repository.



**Server Requirements**



PHP version 8.2 or higher is required, with the following extensions installed:



\- \[intl](http://php.net/manual/en/intl.requirements.php)

\- \[mbstring](http://php.net/manual/en/mbstring.installation.php)



> \[!WARNING]

> - The end of life date for PHP 7.4 was November 28, 2022.

> - The end of life date for PHP 8.0 was November 26, 2023.

> - The end of life date for PHP 8.1 was December 31, 2025.

> - If you are still using below PHP 8.2, you should upgrade immediately.

> - The end of life date for PHP 8.2 will be December 31, 2026.



Additionally, make sure that the following extensions are enabled in your PHP:



\- json (enabled by default - don't turn it off)

\- \[mysqlnd](http://php.net/manual/en/mysqlnd.install.php) if you plan to use MySQL

\- \[libcurl](http://php.net/manual/en/curl.requirements.php) if you plan to use the HTTP\\CURLRequest library

\#

