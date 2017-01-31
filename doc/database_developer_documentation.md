Relational Database 
============

The database for surveys is implemented as a relational database using MySQL. 
All the DB operations are implemented in `/survey/index.php` that uses the SLIM framework. The DB connection is implemented in `/survey/credentials.inc.php`, but the file is not under Git control due to the security issue. 

- If you want to implement a new DB operation for a particlar page, you need to find a function that is called for the page among the SLIM functions, and implement SQL queries accordingly. For example, when `/start/` function is called, we needed to find the max ID in the `org_profiles` table. In order to do that, the DB operation was implemented like this:

```
$app->get('/start/', function () use ($app) { 

	$id_query = "SELECT max(profile_id) as max FROM org_profiles";

...
```

Here, the function is following the SLIM framework's convention, and the query is a standard MySQL query. 


- The entire DB schema is as follows:

![Image of DB Schema](http://myeong.github.io/impactmap_db.png)