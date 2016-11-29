# Overview of the solution

Each use case contains text data and an image. The current implementation uses scripts written in jQuery to parse use case data from a CSV file and load images in a folder that are stored on server. Then the scripts will fill the containers on Use Cases page (1 page), all sector (13 pages) and region (7 pages) pages, with the data (text) and images.

The CSV spreadsheet and the folder of images serve as the 'database' for all use cases. To edit/add new use cases to the spreadsheet, go to: https://docs.google.com/a/odenterprise.org/spreadsheets/d/1fl3CEvr152Z6g3q52C7KrgqVNKWBmxQS_sA8NNolfIE/edit?usp=sharing. Refer to the Use Case User Manual regarding how to update the spreadsheet. (Link to manual: https://github.com/OpenDataEnterprise/impact-map/blob/master/doc/Use%20Case%20Use%20Manual.md)

# Explanation of folders and files

### Folder - html/UseCaseImage

This folder stores all the use case images that will be loaded by the scripts to fill in the containers.

### Folder - html/js-custom/usecase

This folder stores all the JS scripts for parsing data, loading images, and creating and filling the use case containers. It also contains the CSV file that stores all use case text data.

###### Folder - html/js-custom/usecase/region

This folder stores all the scripts (7 scripts) for parsing data and creating use cases on all 7 region pages.

###### Folder - html/js-custom/usecase/sector

This folder stores all the scripts (13 scripts) for parsing data and creating use cases on all 13 sector pages.

###### File - html/js-custom/usecase/jquery.csv.min.js

This is a jQuery liibrary used for parsing CSV data.

###### File - html/js-custom/usecase/usecase.js

This is the script for parsing data and creating use cases on the Use Cases page.

###### File - html/js-custom/usecase/UseCaseData.csv

This is the CSV file containing all the use case text data. Refer to the Use Case User Manual to learn about how to update this file. (Link to manual: https://github.com/OpenDataEnterprise/impact-map/blob/master/doc/Use%20Case%20Use%20Manual.md)
