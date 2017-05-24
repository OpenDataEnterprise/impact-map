# Database Admin Tool User Manual

The Database Admin Tool is an online tool that is a one-stop solution for all the database management needs of The Center for Open Data Enterprise. The overarching goal of this tool is to have a system to manage the research process and have a sustainable solution for managing the database. The purpose of this tool is to provide easy-to-use interfaces to (1) ensure data quality (2) simplify data management processes for research and (3) provide basic analyses and visualization of the database entries giving us an overview of the entire database.

URL : http://test.opendataimpactmap.org/survey/templates/dbadmin/

### Login Page
- User can login into the database admin tool using valid credentials.
- The header contains the navigation to the various parts of the tool (Visualization page, Management page and Setting page).
- You can logout of the tool using the logout button on the extreme right.


### Visualization Page
- **Number of complete entries** - This is a ticker counting from 0 to the total number of published entries on the map.
- **Month by Month Entries into the database** - This is a line graph with date on x axis in YYYY-MM format and count on y axis. The red line indicates the number of records that were stored in the database for that particular month of the year. Hovering over a month would show a popup with value and count of the entries.
- **Research vs Survey Entries** - This a pie graph showing the distribution of research and survey entries in the database. Hovering over a pie would show a popup with value, count and percentage of the entries.
- **Status of records** - This is a bar graph that shows the distribution of status of records in the database. “dnd” indicates do not display, “publish” are the entries that are currently published on the Open Data Impact Map, “submitted” are the entries that are currently submitted and yet to be reviewed and “edit” are those entries that are being edited. Hovering on each bar would show the count of entries for that status.


### Management Page    

This ‘Management’ page is used to perform all the database operations.

- **Navigation** - You can navigate the table using a mouse or with a keyboard. Use the scrollbar to navigate between the columns and rows. You can also use the left and right arrow keys to navigate between the columns and up and down keys to navigate between the rows. Use Pageup and Pagedown keys to navigate between the pages
- **Inline Editing** - You can edit the data in-line by clicking on a cell or by navigating to it and pressing the Enter Key. Navigate within the cell using the arrow keys and press enter to submit changes. To undo changes before saving, press the Escape key.
- **Search** - To search the entire database, enter text in the search box on the right. The search box is not case sensitive.
- **Sort** - To sort a column, click on any column header to sort in ascending order (blanks first). Click again to sort in descending order. Default sorting is by Profile_ID
- **Filters** - To filter a column, click on the drop-down box in the footer of any of the columns. Column is filtered for that value only.
- **Delete** - To delete an organization, select a row or multiple rows (click checkbox in the first column) and click on “Delete” button. The organization is deleted from the database.
- **Select Fields** - To hide or unhide columns, click on “Select Fields” button and click on the column buttons to hide or unhide them. Buttons that appear to be pressed are the visible columns and those that appear to be not pressed are hidden columns.
- **Find Duplicates** - Click on “Find Duplicates” button to shows duplicate entries in the database for an organization. Use the filter in the “Status” column to go through entries that are published, dnd, edit or submitted.
- **Edit Survey** - The Edit Survey for an organization can primarily be used to edit the location fields for a particular organization. These fields include HQ City, HQ Province and HQ Country. The fields Latitude, Longitude, WB and UN codes are all updated automatically through the internal survey. To edit the location fields, select a row or multiple rows (click checkbox in the first column) and click on “Edit Survey” button. This will take you to the internal survey page of that organization. Make changes in the location field and click on Submit button. You can also use this for performing other additions such as adding a data use for the organization
- **Add Survey** - This button works in the same manner as the survey edit button. The only difference is that it opens blank internal survey page without any required fields.
- **Data Use** - You can use the search box at the bottom of the “Data Type used” column to filter data use. To edit the Organization Data Use fields namely, Data type used, Data type used - other, Data source - level, Country and - Machine-readability, select a row or multiple rows (Click checkbox in the first column) and click on “Edit Data Use” button. Data use page opens for that particular organization showing all the data use rows. Change any of the fields and click “Save Changes” button. Since there is a one to many relationship between the Data Use and an organization, we are using the Edit Survey page to add the data use.
- **Migrate to Dev** - This button will migrate all the edited entries from the database to the testing server. It will also open the map page on the testing server (To be implemented)
- **Migrate to Prod** - This button will migrate all the edited entries from the database to the production server. It will also open the map page on the production server (To be implemented)
- **Download Excel** - You can download the filtered data and columns visible on the screen in excel format using this button

PS: If selecting multiple rows does only opens one tab, then enable the allow pop ups button

### Settings Page

- **Register User** - This page is used to register a new user. Click on Register User. Enter Username, E-mail, Password, Retype Password, Name and click Register. User is added to the database. Use Login page to login with newly created user.
- **Change Password** - To change password, enter Password, Retype it in the text boxes and press Submit.
