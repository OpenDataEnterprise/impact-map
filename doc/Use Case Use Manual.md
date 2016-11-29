This manual explains how users can update use cases.

The current solution allows you to input data in one place and update all relevant containers in the website.
Since it does not store anything in Webflow, it can hold much more use cases than using Webflow.
(Webflow will become very slow after you input around 50 use cases in the Use Cases page.)

#The spreadsheet
To add, delete, and edit use cases, go to: https://docs.google.com/a/odenterprise.org/spreadsheets/d/1fl3CEvr152Z6g3q52C7KrgqVNKWBmxQS_sA8NNolfIE/edit?usp=sharing

#Edit the spreadsheet

######Each row contains one use case.

####For the sorting and filtering of use cases to work, there are formatting requirements for three fields - Sector/Region/Machine Readable(Yes/No/NA):
Sector fields: 
The sector name must match one from the drop-down list.

Region fields: 
The region name must match one from the drop-down list.

Machine Readable(Yes/No/NA) fields: 
The "Y" in "Yes" must be capitalized.

####How to input text into Long Description fields:
- Put one line break tag at the very beginning:
```
<br>
```
- Put two line break tags to separate two paragraphs:
```
<br><br>
```
- To add an URL to a key phrase:
First, surround the key phrase with the URL tag:
```
<a target="_blank" href="">YOUR_URL_KEY_PHRASE</a>
```
Second, insert the URL into the href quotation mark:
```
<a target="_blank" href="the_URL_For_Your_Key_Phrase">YOUR_URL_KEY_PHRASE</a>
```
- Here is a sample long description text that you would input:

What you input in the Long Description field:
```
<br>According to Ukrainian 2020 strategy, eGovernment and the increase of
eServices is a priority for Ukraine’s government and president. However,
most basic eServices require both robust infrastructure and a large legal
base to deliver solutions. Through the use of open API and hackathons
though, quick and robust eServices may be developed with minimum resources.
Social Boost was started in this vein.<br><br>Social Boost has identified
open government data and ICT applications to be key instruments to their
organization. In 2014 SocialBoost developed and launched together with Ukrainian
government the <a target="_blank" href="http://data.gov.ua/">National Open Data
Portal</a> and <a target="_blank" href="http://ogp.gov.ua/">Open Government Partnership
Portal</a>. Recognizing the value and potential of open government data, SocialBoost
co-authored the <a target="_blank" href="http://w1.c1.rada.gov.ua/pls/zweb2/webproc4_1?pf3511=54100">
Open Data Law of Ukraine</a>. Crowdsourced projects that have resulted from Social Boost’s
hackathons and use of open government data include: <a target="_blank"
href="http://edumeter.com.ua/school#Region:undefined;District:undefined;City:undefined;Search:;Bags:">
edumeter.com.ua</a> - a website that utilized machine-readable education data to 
rate educational insitutions, <a target="_blank" href="http://citytransport.com.ua/">citytransport.com.ua</a>,
and <a target="_blank" href="http://zloch.in.ua/">zloch.in.ua</a>.<br><br>Additionally,
Social Boost is responsible for many of the hackathons held in Ukraine over the recent years,
including the Social Entrepreneurship Hackathon. Themes of the hackathons have included human
trafficking, human security issues and other socially impactful topics. 
```
What displays on the website:

<br>According to Ukrainian 2020 strategy, eGovernment and the increase of eServices is a priority for Ukraine’s government and president. However, most basic eServices require both robust infrastructure and a large legal base to deliver solutions. Through the use of open API and hackathons though, quick and robust eServices may be developed with minimum resources. Social Boost was started in this vein.<br><br>Social Boost has identified open government data and ICT applications to be key instruments to their organization. In 2014 SocialBoost developed and launched together with Ukrainian government the <a target="_blank" href="http://data.gov.ua/">National Open Data Portal</a> and <a target="_blank" href="http://ogp.gov.ua/">Open Government Partnership Portal</a>. Recognizing the value and potential of open government data, SocialBoost co-authored the <a target="_blank" href="http://w1.c1.rada.gov.ua/pls/zweb2/webproc4_1?pf3511=54100">Open Data Law of Ukraine</a>. Crowdsourced projects that have resulted from Social Boost’s hackathons and use of open government data include: <a target="_blank" href="http://edumeter.com.ua/school#Region:undefined;District:undefined;City:undefined;Search:;Bags:">edumeter.com.ua</a> - a website that utilized machine-readable education data to rate educational insitutions, <a target="_blank" href="http://citytransport.com.ua/">citytransport.com.ua</a>, and <a target="_blank" href="http://zloch.in.ua/">zloch.in.ua</a>.<br><br>Additionally, Social Boost is responsible for many of the hackathons held in Ukraine over the recent years, including the Social Entrepreneurship Hackathon. Themes of the hackathons have included human trafficking, human security issues and other socially impactful topics.

####How to link the image with the use case:
Copy and paste the full image file name with the file suffix into the Image File Name fields.

Examples of full image file name:
```
Image_File_Name.jpg
or
Image_File_Name.png
...
```

####For all other fields, there is no formatting requirement.

#Sort the spreadsheet

Before exporting the CSV file, sort the entire sheet alphabetically according to use case name.

#Export and upload the sheet
1. In Google Spreadsheet, go to file - download as, then download as CSV file. 
2. Remane the CSV file as "UseCaseData.csv".
3. Copy the CSV file into "impact-map/html/js-custom/usecase" folder.

#Adding images
Copy the corresponding image files into the folder "impact-map/html/UseCaseImage". The image file name matches the name you just copied into the Image File Name field in the spreasheet.

#Git push to server
Finally, use the same git commands that you use for updateing the website files, to push and pull all updated use case files.
