Survey Interfaces
================

## Public Survey (http://www.opendataimpactmap.org/survey)
- The layout of the public survey interface is implemented at `/templates/survey/tp_survey.php`
- http://www.opendataimpactmap.org/survey calls  `survey/start` function in index.php file using the Slim framework.

### /start/ function
1. It has following two queries: 
	1. retrieve max object id from the `org_surveys` table
	2. Insert a new object id with id as maxId + 1 into org_surveys table
	3. Pass the last inserted survey id to `survey/:surveyId/form` where surveyId is the passed surveyId
	
2. `:surveyId/form` function calls `survey/tp_survey.php` file

3. When a user submits the form, `survey/tp_survey.php` calls `survey/2du/:surveyId` function in index.php

4. All the insertion of data using MySQL queries is done in `2du/:surveyId ` function. It first prepare data based on the data passed from the form, and insert to each table one by one. 

### /2du/:surveyId Function
1. All the database operations for the input data provided by user in the form is done in this function.
2. Checks whether `org_hq_country_locode` is already registered in the `org_country_info` table. If so, get the `country_id` from the table. This table follows ISO2 standard from the World Bank. If not found here, that means the country code is not available from the list (so will be remain as `null`).
3. Checks org_locations_info table whether the location data (e.g., city and province) is already registered. If not, insert the location data into the table. 
4. Insert information into org_profiles table along with profile id as survey id of the form and location_id.
5. Insert into org_contact table all survey_contact related data along with profile id as survey id
5. Insert into data_applications table based on "applications" data.
6. Insert int org_data_use table.
	i. First, retrieve country information for each data_use case. If available, it links to the country_id.
	ii. The followings deal with data_type when some values are available or null. 
7. After all the DB operations, it redirects to `/survey/submitted/:surveyId/` function, then, calls `survey/:surveyId/thankyou` function.
8. All survey related information along with profile id is passed to `survey/tp_thankyou.php` from `/:surveyId/thankyou` function


## Internal Survey (http://www.opendataimpactmap.org/survey/start/internal/add/)
- The interface calls  `/:surveyId/form/internal/add/` function in index.php file using the Slim framework.
- The layout of the internal survey interface is implemented at `/templates/survey/tp_survey_less_req.php`
- The rest of the operations are same to the public one.


## Survey Edit
- `survey/edit/:profile_id` is called from `/survey/tp_thankyou.php` file or a pop-up menu from the map visualization.

### /edit/:profile_id function

1. It first retrieves org_name from org_profiles table using profile id
2. Calls `survey/tp_profile_edit_msg.php` file and passes `org_name` information.
3. `survey/tp_profile_edit_msg.php` file calls `survey/edit/:profileId/form` function from index.php file

### /edit/:profileId/form function 
1. Retrieve all information from org_profiles table based on profile id
2. Retrieve all information from org_data_sources based on profile id
3. Retrieve all information from org_locations_info based org_loc_id which is retrieved in the first query
4. Retrieve all information from org_country_info based on org_loc_id which is retrieved in the third query
5. Retrieve all information from data_app_info based on profile id
6. insert into org_surveys with new survey id for edited form
7. Sends all retrieved information to `survey/tp_profile_edit.php` file along with a new `profile_id`
8. In `survey/tp_profile_edit.php` file, it displays all information received from `/edit/:profileId/form` function 
9. After submission of the edited form, it calls `survey/2du/:surveyId` function and process all information as described above for `/2du/:surveyId` function.

