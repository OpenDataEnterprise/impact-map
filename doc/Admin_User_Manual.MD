Existing Admin Interface
-------------------------
### ADD NEW use cases

Internal
-------------
The Center identifies new use cases through research, in the news, or receives a list of use cases from a Regional Supporter

Candidate use cases and any additional information provided are added to the spreadsheet of candidates, including the source of the suggestion. The spreadsheet is currently named *Inventory. 

A researcher conducts additional searches for information on publicly available websites, adds this information to the spreadsheet, applies a rating (1-5). The rating describes two things: confidence in the use of open data, and completeness of information.

Ratings are as follows:
-------------------------------
	5 = uses open government data, data types identified
	4 = uses open government data, but no specific data types identified
    3 = cannot determine whether government data is used, but given context use is likely
    2 = cannot rule out use of government data, but given context use is unlikely
    1 = use case is ineligible, and does not satisfy the criteria
A reviewer vets the use cases, checks language, spelling, selection of categories, and rating.

The reviewer marks the entries as follows:
-----------------------------------------------
	4 or 5 are labeled as Y = vetted
	2 or 3 are labeled as I = incomplete
    1 is labeled as N = not eligible

Use cases marked as Y are added to the database. This is done by filling out an internal survey for each organization. Organizations added to the admin tool this way are marked as ‘Hold’ in the ‘org_profile_status’ field

External
------------
A Survey entry is submitted via the Center’s website.
Surveys are marked as ‘survey’ in the field ‘org_profile_status’ in the database

Every week, the reviewer logs into the admin tool. Sort by ‘org_profile_status’. Entries marked as ‘survey’ in this field.  

Note
---------
All surveys (internal and external) have new fields added to them:
------------------------------------------------------------------------
1. Location information: country code, region, region code, country income level, latitude, longitude
2. Time stamps
3. Ratings/confidence level (1-5)

### Notes 
1. Profile status (ie. Hold, publish, dnd = do not display)
2. Entry source (ie. Regional Supporter, CODE research, etc)
3. Type of entry (ie. research or submitted survey)


EDIT EXISTING use cases
--------------------------------

Internal
--------------
Reviewer logs into admin tool to make changes. 

If the change is to one of the organizational information or application fields, the reviewer searches for the organization, selects the appropriate filter, and edits the information directly in the box, paying attention not to make any typos and referring the the existing categories. 

If the change is to the data type field, the reviewer needs to create a new survey for the organization. The reviewer then changes the ‘org_profile_status’ field in the old survey to ‘dnd’, and marks the new survey as ‘publish’. 

If the change is to any geographical field, the reviewer needs to select all relevant fields:

If the change is to a city: the latitude and longitude fields

If the change is to a country: the latitude, longitude, country code, region, region code, country income level fields all need to be edited as well. 
Latitude and longitude can be searched for any location at the bottom the admin interface’s homepage

External
------------
1. Organization edits a profile on the website.

2. New survey is created in the database. It is marked as ‘edit’ in the ‘org_profile_status’ field and given a new ‘profile_id’
3. The reviewer receives an email notifying her that someone has edited an entry. 
4. The reviewer logs reviews the changes.
5. Logs into admin interface
6. Searches for the organization by its name
7. Opens up the survey pages for both the original and the edited entry
Edits the new entry if needed
8. Changes the ‘org_profile_status’ field from ‘survey-edit’ to:
    a. In the old entry: ‘dnd’
    b. In the new, edited, vetted entry: ‘publish’

PUBLISH new entries and edits.
---------------------------------
Use cases are published on the website weekly.

The process for this is:

1. In the admin interface, search for ‘Hold’ 
2. Sort by ‘org_profile_status’. Change organizations marked as ‘Hold’ in this field to ‘publish’
3. Click on ‘Check duplicates’ button. If there are any duplicate entries, review these by clicking on each survey to compare them, and select which entry to unpublish by changing the ‘org_profile_status’ field to ‘dnd’ 
4. Run the script in terminal to development website
5. Check development website on odetest.odenterprise.org/map/viz
6. If there are problems, address these. If no problems, run the script to the production website. 
7. Check the production website.

MAINTENANCE of old entries:
-------------------------------
1. Sort entries by date last edited/date added to the database
2. For each organization, researcher then
3. Vets information
4. Edits fields as appropriate
5. Changes ‘org_profile_status’ field if necessary
---------------------------------

Requirements for new admin interface:
---------
1)The new admin interface should have the following columns - with user friendly names:
-----
Type of data used:

Contact information

Date that a survey was last edited/submitted

Confidence Level 

Machine-readability

2)An interface needed to change the data use and country source column values.
----

3)The Longitude/latitude, region, region code, etc details needs to be automatically changed when a country is added/edited for a particular record.
--

4)As the research is done and data is collected outside the admin interface so every time a new survey has to filled to add the record. So there is need to have the option for research/edits/additions in the admin interface itself in a user-friendly way, or by uploading data from research to the database every two weeks in a less time consuming way than survey entries
-

5)To make the fields as "drop-down" so that manual editing in the interface can be avoided which can cause human errors.
----

6)An interface required for changing the “profile_status” which is one of the major task for the admin user. 
--

7)As currently the search box searches for every field when typed something, so the search box needs to be modified to search on a specific field.
----

8)To ease the comparison between edited and old entries while editing, so requirement of specific way of comparing the two in the interface.
---




