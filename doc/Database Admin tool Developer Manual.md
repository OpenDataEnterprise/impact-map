# Database Admin Tool Developer Manual

This document explains how we can make changes to every feature of the tool and explains the important pieces of code in particular files. The tool is built using PHP, Javascript and MySQL

### Making changes to the Login Page
The login functionality is built using the "PHP Secure, Advanced Login System" which can be found here - http://subinsb.com/php-logsys

**sql/mysql.sql**
- This file has all the SQL queries we need to run to implement thw login functionality on a new database.
- It creates the tables in the database required for the login functionality.

**config.php**
-  This file is used to set the configurations for the login page such as basic login or two step login, to specify the web page for successful login, pages that require login to be accessed and other relavant features.
- This file is included in the each of the web page of the tool

**login.php**
- This file contains the php code to validate user logins.
- We are using PHP session variables and checking the $_SESSION['login_true'] variable in each php file to check if user is logged in.
- The rest of the file contains the HTL code to build the page.

### Visualization Page

The visualizations are built using D3Plus.

**home.php**
- This page contains the html elemennts to be displayed on the visualization page.

**viz/getHomeStat.php**
- This file contains the code for the ticker of the number of entries. 
- The total number of entries are obtained from the "viz/total.php" and then displayed using this file.
- This file is inculded in home.php page.

**viz/pie1.php**
- This file is used to get the data for the following visualizations - 
    - Month by Month Entries into the database
    - Research vs Survey Entries 
    - Status of records
- The file contains SQL queries to get the data from the MySQL database and convert it into JSON format.

### Management Page    

This page is built using DataTables Editor. Detailed documentation about it can be found here - https://editor.datatables.net/

**Datatables-editor\examples\php\staff.php**

- This file is used to get the data to be displayed in the datatable editor created in the simple.html page
- It also contains joins betweens different tables and validations on each field of the database
- If you need to make a field drop down, add or remove validations or add new fields, you need to start from this file to get the data first.

**Datatables-editor\examples\inline-editing\simple.html**

- This file is used to create the instance of the datatables editor.
- We use the editor variable to create an instance of the editor table (to include editor functionality) and specify the fields to be displayed.
- We then create the table variable to create an instance of the datatable (to include datatable functionalities). 
- We use this declaration to specify the column widths, column visibilty, the buttons and thier working and to create the filters in the footer for each column

**Datatables-editor\examples\php\dependant\datause.php**

- Clicking the "Edit Data Use' button, generates a page with multiple datause for a particular organization.
- This file is used to get the multiple datauses for a particular organization and build the front end and to provide the editing capability.
- The file is created in PHP and has HTML elements echoed in the 'echo' keyword.
