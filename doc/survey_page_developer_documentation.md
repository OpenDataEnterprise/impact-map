Survey Interface
----------------------------
----------------------------
### (http://www.opendataenterprise.org/map/survey)


1. The layout of the interface is implemented at `/templates/survey/tp_survey.php`
2. http://www.opendataenterprise.org/index.html calls  `map/survey/start` function in index.php file using slim framework.

/start/ function
------------------------------------
	It has following two queries: 
		1. retrieve max object id from org-surveys table
		2. Insert new object id with id as maxId + 1 into org_surveys table
	
3. Pass last inserted survey id to `map/survey/:surveyId/form` where surveyId is the passed surveyId
	
3. `:surveyId/form` function calls `survey/tp_survey.php` file

4. User fills survey form and then submits it

5. After form submission, it calls `/map/survey/2du/:surveyId` function in index.php

6. All the insertion of data using mysql queries is done in `/map/survey/2du` function

/2du/:surveyId Function
------------------------------------
1. All processing of input data provided by user in the form is done in this function.
2. Retrieve `org_hq_country` name from `org_hq_country_locade` using wb_region
### Queries executed in this function:
	1. Retrieve country id from org_hq_country table based on org_hq_country name
	2. Insert into org_locations_info table all location based user data along with country id retrieve from previous query.
	3. Insert into org_profiles table along with profile id as survey id of the form and org_loc_id as last inserted object id from org_locations table in second query
	4. Insert into org_contact table all survey_contact related user data along with profile id as survey id
	5. Insert into data_app_info table with alll respective column information from user input.
	6. Creating two conditions for data_use_type based on user input
		a. one data_type:
			i. Retrieve country id from org_hq_country table based on org_hq_country name
			ii. insert into org_data_sources with data_type, profile id and country id
			
		b. More than one data_type 
			For each data_type:
				i. Retrieve country id from org_hq_country table based on org_hq_country name
				ii. insert into org_data_sources with data_type, profile id and country id
				
3. Calls `/map/survey/:surveyId/thankyou` function after successful execution of all queries 

4. All survey related information along with profile id is passed to `survey/tp_thankyou.php` from `/:surveyId/thankyou` function

Survey Edit
---------------------
---------------------
`/map/survey/edit/:surveyId` is called from `/survey/tp_thankyou.php` file

/edit/:profile_id function
---------------------------------
### Queries executed in this function:
	Retrieve org_name from org_profiles table using profile id
1. Calls `survey/tp_profile_edit_msg.php` file and passes `org_name` information.

2. `survey/tp_profile_edit_msg.php` file calls `/map/survey/edit/:profileId/form` function from index.php file

/edit/:profileId/form function
----------------------------------
### Queries executed in this function:
	1. Retrieve all information from org_profiles table based on profile id
	2. Retrieve all information from org_data_sources based on profile id
	3. Retrieve all information from org_locations_info based org_loc_id which is retrieved in the first query
	4. Retrieve all information from org_country_info based on org_loc_id which is retrieved in the third query
	5. Retrieve all information from data_app_info based on profile id
	6. insert into org_surveys with new survey id for edited form

1. Sends all retrieved information to `survey/tp_profile_edit.php` file along with new profile id

2. `survey/tp_profile_edit.php` file, it displays all information received from `/edit/:profileId/form` function 

3. After submission of edited form, it calls `/map/survey/2du/:surveyId` function and process all information as described above for `/2du/:surveyId` function.


	


