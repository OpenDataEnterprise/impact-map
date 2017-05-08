
--
-- Oracle tables used to run the Editor examples.
--
-- For more information about how the client and server-sides interact, please
-- refer to the Editor documentation: http://editor.datatables.net/manual .
--
--

-- Procedure to try and reduce the verbosity of this file!
CREATE OR REPLACE PROCEDURE EditorDelObject(ObjName varchar2, ObjType varchar2)
IS
	v_counter number := 0;
BEGIN
	IF ObjType = 'TABLE' then
		select count(*) into v_counter from user_tables where table_name = upper(ObjName);
		IF v_counter > 0 then
			EXECUTE IMMEDIATE 'drop table ' || ObjName || ' cascade constraints';
		END IF;
	END IF;
	IF ObjType = 'SEQUENCE' then
		select count(*) into v_counter from user_sequences where sequence_name = upper(ObjName);
			IF v_counter > 0 then
				EXECUTE IMMEDIATE 'DROP SEQUENCE ' || ObjName;
			END IF;
	END IF;
END;


BEGIN
	EditorDelObject('todo', 'TABLE');
	EditorDelObject('todo_seq', 'SEQUENCE');
END;

CREATE TABLE EDITOR.todo
(
    id INT PRIMARY KEY NOT NULL,
    item VARCHAR(200),
    done NUMBER(1) DEFAULT 0 NOT NULL,
    priority NUMBER(10) DEFAULT 1 NOT NULL
);

CREATE SEQUENCE todo_seq;

CREATE OR REPLACE TRIGGER todo_on_insert
	BEFORE INSERT ON todo
	FOR EACH ROW
BEGIN
	SELECT todo_seq.nextval
	INTO :new.id
	FROM dual;
END;

INSERT INTO todo (item, done, priority) VALUES ( 'Send business plan to clients', 1, 1 );
INSERT INTO todo (item, done, priority) VALUES ( 'Web-site copy revisions',       0, 2 );
INSERT INTO todo (item, done, priority) VALUES ( 'Review client tracking',        0, 2 );
INSERT INTO todo (item, done, priority) VALUES ( 'E-mail catchup',                0, 3 );
INSERT INTO todo (item, done, priority) VALUES ( 'Complete worksheet',            0, 4 );
INSERT INTO todo (item, done, priority) VALUES ( 'Prep sales presentation',       0, 5 );



--
-- Users table examples
--
BEGIN
	EditorDelObject('users', 'TABLE');
	EditorDelObject('dept', 'TABLE');
	EditorDelObject('permission', 'TABLE');
	EditorDelObject('sites', 'TABLE');
	EditorDelObject('files', 'TABLE');
	EditorDelObject('user_dept', 'TABLE');
	EditorDelObject('user_permission', 'TABLE');
	EditorDelObject('users_files', 'TABLE');

	EditorDelObject('users_seq', 'SEQUENCE');
	EditorDelObject('dept_seq', 'SEQUENCE');
	EditorDelObject('permission_seq', 'SEQUENCE');
	EditorDelObject('sites_seq', 'SEQUENCE');
	EditorDelObject('files_seq', 'SEQUENCE');
END;



CREATE TABLE users (
	id INT PRIMARY KEY NOT NULL,
	title VARCHAR(10),
	first_name VARCHAR(100),
	last_name VARCHAR(100),
	phone VARCHAR(100),
	city VARCHAR(200),
	zip VARCHAR(100),
	updated_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	registered_date TIMESTAMP,
	active NUMBER(1) DEFAULT 0 NOT NULL,
	comments VARCHAR(2000),
	manager INT,
	site INT,
	image INT,
	shift_start VARCHAR(8),
	shift_end VARCHAR(8)
);

CREATE SEQUENCE users_seq;

CREATE OR REPLACE TRIGGER users_on_insert
	BEFORE INSERT ON users
	FOR EACH ROW
	BEGIN
		SELECT users_seq.nextval
		INTO :new.id
		FROM dual;
	END;



CREATE TABLE dept (
	id INT PRIMARY KEY NOT NULL,
	name VARCHAR(250)
);

CREATE SEQUENCE dept_seq;

CREATE OR REPLACE TRIGGER dept_on_insert
	BEFORE INSERT ON dept
	FOR EACH ROW
	BEGIN
		SELECT dept_seq.nextval
		INTO :new.id
		FROM dual;
	END;



CREATE TABLE permission (
	id INT PRIMARY KEY NOT NULL,
	name VARCHAR(250)
);

CREATE SEQUENCE permission_seq;

CREATE OR REPLACE TRIGGER permission_on_insert
	BEFORE INSERT ON permission
	FOR EACH ROW
	BEGIN
		SELECT permission_seq.nextval
		INTO :new.id
		FROM dual;
	END;



CREATE TABLE sites (
id INT PRIMARY KEY NOT NULL,
name VARCHAR(250)
);

CREATE SEQUENCE sites_seq;

CREATE OR REPLACE TRIGGER sites_on_insert
	BEFORE INSERT ON sites
	FOR EACH ROW
	BEGIN
		SELECT sites_seq.nextval
		INTO :new.id
		FROM dual;
	END;



CREATE TABLE files (
	id INT PRIMARY KEY NOT NULL,
	filename VARCHAR(1000),
	filesize int default 0,
	web_path VARCHAR(2000),
	system_path VARCHAR(2000)
);

CREATE SEQUENCE files_seq;

CREATE OR REPLACE TRIGGER files_on_insert
	BEFORE INSERT ON files
	FOR EACH ROW
	BEGIN
		SELECT files_seq.nextval
		INTO :new.id
		FROM dual;
	END;



CREATE TABLE user_dept (
	user_id int,
	dept_id int
);

CREATE TABLE user_permission (
	user_id int,
	permission_id int
);

CREATE TABLE users_files (
	user_id int NOT NULL,
	file_id int NOT NULL
);



INSERT INTO users (title, first_name, last_name, phone, city, zip, registered_date, active, manager, site, shift_start, shift_end) VALUES ('Miss','Quynn',     'Contreras',    '1-971-977-4681', 'Slidell',               '81080',    '06-Apr-201218:53:00', '0', 1, 1, '08:00:00', '16:00:00');
INSERT INTO users (title, first_name, last_name, phone, city, zip, registered_date, active, manager, site, shift_start, shift_end) VALUES ('Mr',  'Kaitlin',   'Smith',        '1-436-523-6103', 'Orlando',               'U5G 7J3',  '20-Nov-2012 05:58:25', '1', 1, 2, '09:00:00', '17:00:00');
INSERT INTO users (title, first_name, last_name, phone, city, zip, registered_date, active, manager, site, shift_start, shift_end) VALUES ('Mrs', 'Cruz',      'Reynolds',     '1-776-102-6352', 'Lynn',                  'EJ89 9DQ', '31-Dec-2011 23:34:03', '0', 2, 3, '09:00:00', '17:00:00');
INSERT INTO users (title, first_name, last_name, phone, city, zip, registered_date, active, manager, site, shift_start, shift_end) VALUES ('Dr',  'Sophia',    'Morris',       '1-463-224-1405', 'Belleville',            'T1F 2X1',  '04-Aug-2012 02:55:53', '0', 3, 4, '08:00:00', '15:30:00');
INSERT INTO users (title, first_name, last_name, phone, city, zip, registered_date, active, manager, site, shift_start, shift_end) VALUES ('Miss','Kamal',     'Roberson',     '1-134-408-5227', 'Rehoboth Beach',        'V7I 6T5',  '23-Dec-2012 00:17:03', '1', 1, 5, '09:00:00', '17:00:00');
INSERT INTO users (title, first_name, last_name, phone, city, zip, registered_date, active, manager, site, shift_start, shift_end) VALUES ('Dr',  'Dustin',    'Rosa',         '1-875-919-3188', 'Jersey City',           'E4 8ZE',   '05-Oct-2012 22:18:59', '0', 1, 6, '09:00:00', '17:00:00');
INSERT INTO users (title, first_name, last_name, phone, city, zip, registered_date, active, manager, site, shift_start, shift_end) VALUES ('Dr',  'Xantha',    'George',       '1-106-884-4754', 'Billings',              'Y2I 6J7',  '25-Nov-2012 12:50:16', '0', 6, 1, '07:00:00', '15:00:00');
INSERT INTO users (title, first_name, last_name, phone, city, zip, registered_date, active, manager, site, shift_start, shift_end) VALUES ('Mrs', 'Bryar',     'Long',         '1-918-114-8083', 'San Bernardino',        '82983',    '14-May-2012 23:32:25', '0', 1, 2, '09:00:00', '17:00:00');
INSERT INTO users (title, first_name, last_name, phone, city, zip, registered_date, active, manager, site, shift_start, shift_end) VALUES ('Mrs', 'Kuame',     'Wynn',         '1-101-692-4039', 'Truth or Consequences', '21290',    '21-Jun-2011 16:27:07', '1', 2, 3, '06:00:00', '14:00:00');
INSERT INTO users (title, first_name, last_name, phone, city, zip, registered_date, active, manager, site, shift_start, shift_end) VALUES ('Ms',  'Indigo',    'Brennan',      '1-756-756-8161', 'Moline',                'NO8 3UY',  '19-Feb-2011 12:51:08', '1', 5, 4, '12:00:00', '00:00:00');
INSERT INTO users (title, first_name, last_name, phone, city, zip, registered_date, active, manager, site, shift_start, shift_end) VALUES ('Mrs', 'Avram',     'Allison',      '1-751-507-2640', 'Rancho Palos Verdes',   'I7Q 8H4',  '30-Dec-2012 17:02:10', '0', 1, 5, '09:00:00', '17:00:00');
INSERT INTO users (title, first_name, last_name, phone, city, zip, registered_date, active, manager, site, shift_start, shift_end) VALUES ('Mr',  'Martha',    'Burgess',      '1-971-722-1203', 'Toledo',                'Q5R 9HI',  '04-Feb-2011 17:25:55', '1', 1, 6, '12:00:00', '00:00:00');
INSERT INTO users (title, first_name, last_name, phone, city, zip, registered_date, active, manager, site, shift_start, shift_end) VALUES ('Miss','Lael',      'Kim',          '1-626-697-2194', 'Lake Charles',          '34209',    '24-Jul-2012 06:44:22', '1', 7, 1, '09:00:00', '17:00:00');
INSERT INTO users (title, first_name, last_name, phone, city, zip, registered_date, active, manager, site, shift_start, shift_end) VALUES ('Dr',  'Lyle',      'Lewis',        '1-231-793-3520', 'Simi Valley',           'H9B 2H4',  '30-Aug-2012 03:28:54', '0', 1, 2, '00:00:00', '12:00:00');
INSERT INTO users (title, first_name, last_name, phone, city, zip, registered_date, active, manager, site, shift_start, shift_end) VALUES ('Miss','Veronica',  'Marks',        '1-750-981-6759', 'Glens Falls',           'E3C 5D1',  '14-Aug-2012 12:09:24', '1', 2, 3, '09:00:00', '17:00:00');
INSERT INTO users (title, first_name, last_name, phone, city, zip, registered_date, active, manager, site, shift_start, shift_end) VALUES ('Mrs', 'Wynne',     'Ruiz',         '1-983-744-5362', 'Branson',               'L9E 6E2',  '06-Nov-2012 01:04:07', '0', 1, 4, '12:00:00', '00:00:00');
INSERT INTO users (title, first_name, last_name, phone, city, zip, registered_date, active, manager, site, shift_start, shift_end) VALUES ('Ms',  'Jessica',   'Bryan',        '1-949-932-6772', 'Boulder City',          'F5P 6NU',  '01-Feb-2013 20:22:33', '0', 5, 5, '09:00:00', '17:00:00');
INSERT INTO users (title, first_name, last_name, phone, city, zip, registered_date, active, manager, site, shift_start, shift_end) VALUES ('Ms',  'Quinlan',   'Hyde',         '1-625-664-6072', 'Sheridan',              'Y8A 1LQ',  '25-Oct-2011 16:53:45', '1', 1, 6, '08:00:00', '15:00:00');
INSERT INTO users (title, first_name, last_name, phone, city, zip, registered_date, active, manager, site, shift_start, shift_end) VALUES ('Miss','Mona',      'Terry',        '1-443-179-7343', 'Juneau',                'G62 1OF',  '15-Jan-2012 09:26:59', '0', 1, 1, '08:30:00', '16:30:00');
INSERT INTO users (title, first_name, last_name, phone, city, zip, registered_date, active, manager, site, shift_start, shift_end) VALUES ('Mrs', 'Medge',     'Patterson',    '1-636-979-0497', 'Texarkana',             'I5U 6E0',  '20-Oct-2012 16:26:18', '1', 1, 2, '09:00:00', '17:00:00');
INSERT INTO users (title, first_name, last_name, phone, city, zip, registered_date, active, manager, site, shift_start, shift_end) VALUES ('Mrs', 'Perry',     'Gamble',       '1-440-976-9560', 'Arcadia',               '98923',    '06-Jun-2012 02:03:49', '1', 2, 3, '00:00:00', '12:00:00');
INSERT INTO users (title, first_name, last_name, phone, city, zip, registered_date, active, manager, site, shift_start, shift_end) VALUES ('Mrs', 'Pandora',   'Armstrong',    '1-197-431-4390', 'Glendora',              '34124',    '29-Aug-2011 01:45:06', '0', 7, 4, '21:00:00', '03:00:00');
INSERT INTO users (title, first_name, last_name, phone, city, zip, registered_date, active, manager, site, shift_start, shift_end) VALUES ('Mr',  'Pandora',   'Briggs',       '1-278-288-9221', 'Oneida',                'T9M 4H9',  '16-Jul-2012 08:44:41', '1', 4, 5, '09:00:00', '17:00:00');
INSERT INTO users (title, first_name, last_name, phone, city, zip, registered_date, active, manager, site, shift_start, shift_end) VALUES ('Mrs', 'Maris',     'Leblanc',      '1-936-114-2921', 'Cohoes',                'V1H 6Z7',  '04-May-2011 13:07:04', '1', 1, 6, '00:00:00', '12:00:00');
INSERT INTO users (title, first_name, last_name, phone, city, zip, registered_date, active, manager, site, shift_start, shift_end) VALUES ('Mrs', 'Ishmael',   'Crosby',       '1-307-243-2684', 'Midwest City',          'T6 8PS',   '02-Jul-2011 23:11:11', '0', 3, 1, '09:00:00', '17:00:00');
INSERT INTO users (title, first_name, last_name, phone, city, zip, registered_date, active, manager, site, shift_start, shift_end) VALUES ('Miss','Quintessa', 'Pickett',      '1-801-122-7471', 'North Tonawanda',       '09166',    '05-Feb-2013 10:33:22', '1', 1, 2, '12:00:00', '00:00:00');
INSERT INTO users (title, first_name, last_name, phone, city, zip, registered_date, active, manager, site, shift_start, shift_end) VALUES ('Miss','Ifeoma',    'Mays',         '1-103-883-0962', 'Parkersburg',           '87377',    '22-Aug-2011 12:19:09', '0', 1, 3, '09:00:00', '17:00:00');
INSERT INTO users (title, first_name, last_name, phone, city, zip, registered_date, active, manager, site, shift_start, shift_end) VALUES ('Mrs', 'Basia',     'Harrell',      '1-528-238-4178', 'Cody',                  'LJ54 1IU', '07-May-2012 14:42:55', '1', 1, 4, '09:00:00', '17:00:00');
INSERT INTO users (title, first_name, last_name, phone, city, zip, registered_date, active, manager, site, shift_start, shift_end) VALUES ('Mrs', 'Hamilton',  'Blackburn',    '1-676-857-1423', 'Delta Junction',        'X5 9HE',   '19-May-2011 07:39:48', '0', 6, 5, '10:00:00', '18:00:00');
INSERT INTO users (title, first_name, last_name, phone, city, zip, registered_date, active, manager, site, shift_start, shift_end) VALUES ('Ms',  'Dexter',    'Burton',       '1-275-332-8186', 'Gainesville',           '65914',    '01-Feb-2013 16:21:20', '1', 5, 6, '21:00:00', '03:00:00');
INSERT INTO users (title, first_name, last_name, phone, city, zip, registered_date, active, manager, site, shift_start, shift_end) VALUES ('Mrs', 'Quinn',     'Mccall',       '1-808-916-4497', 'Fallon',                'X4 8UB',   '24-Mar-2012 19:31:51', '0', 1, 1, '09:00:00', '17:00:00');
INSERT INTO users (title, first_name, last_name, phone, city, zip, registered_date, active, manager, site, shift_start, shift_end) VALUES ('Mr',  'Alexa',     'Wilder',       '1-727-307-1997', 'Johnson City',          '16765',    '14-Oct-2011 08:21:14', '0', 3, 2, '09:00:00', '17:00:00');
INSERT INTO users (title, first_name, last_name, phone, city, zip, registered_date, active, manager, site, shift_start, shift_end) VALUES ('Ms',  'Rhonda',    'Harrell',      '1-934-906-6474', 'Minnetonka',            'I2R 1H2',  '15-Nov-2011 00:08:02', '1', 1, 3, '12:00:00', '00:00:00');
INSERT INTO users (title, first_name, last_name, phone, city, zip, registered_date, active, manager, site, shift_start, shift_end) VALUES ('Mrs', 'Jocelyn',   'England',      '1-826-860-7773', 'Chico',                 '71102',    '31-May-2012 18:01:43', '1', 1, 4, '09:00:00', '17:00:00');
INSERT INTO users (title, first_name, last_name, phone, city, zip, registered_date, active, manager, site, shift_start, shift_end) VALUES ('Dr',  'Vincent',   'Banks',        '1-225-418-0941', 'Palo Alto',             '03281',    '07-Aug-2011 07:22:43', '0', 1, 5, '18:00:00', '02:00:00');
INSERT INTO users (title, first_name, last_name, phone, city, zip, registered_date, active, manager, site, shift_start, shift_end) VALUES ('Mrs', 'Stewart',   'Chan',         '1-781-793-2340', 'Grand Forks',           'L1U 3ED',  '01-Nov-2012 23:14:44', '1', 6, 6, '08:00:00', '16:00:00');

INSERT INTO dept (name) VALUES ( 'IT' );
INSERT INTO dept (name) VALUES ( 'Sales' );
INSERT INTO dept (name) VALUES ( 'Pre-Sales' );
INSERT INTO dept (name) VALUES ( 'Marketing' );
INSERT INTO dept (name) VALUES ( 'Senior Management' );
INSERT INTO dept (name) VALUES ( 'Accounts' );
INSERT INTO dept (name) VALUES ( 'Support' );

INSERT INTO permission (name) VALUES ( 'Printer' );
INSERT INTO permission (name) VALUES ( 'Servers' );
INSERT INTO permission (name) VALUES ( 'Desktop' );
INSERT INTO permission (name) VALUES ( 'VMs' );
INSERT INTO permission (name) VALUES ( 'Web-site' );
INSERT INTO permission (name) VALUES ( 'Accounts' );

INSERT INTO user_dept (user_id, dept_id) VALUES ( 1,  1 );
INSERT INTO user_dept (user_id, dept_id) VALUES ( 2,  4 );
INSERT INTO user_dept (user_id, dept_id) VALUES ( 3,  7 );
INSERT INTO user_dept (user_id, dept_id) VALUES ( 4,  3 );
INSERT INTO user_dept (user_id, dept_id) VALUES ( 5,  2 );
INSERT INTO user_dept (user_id, dept_id) VALUES ( 6,  6 );
INSERT INTO user_dept (user_id, dept_id) VALUES ( 7,  2 );
INSERT INTO user_dept (user_id, dept_id) VALUES ( 8,  1 );
INSERT INTO user_dept (user_id, dept_id) VALUES ( 9,  2 );
INSERT INTO user_dept (user_id, dept_id) VALUES ( 10, 3 );
INSERT INTO user_dept (user_id, dept_id) VALUES ( 11, 4 );
INSERT INTO user_dept (user_id, dept_id) VALUES ( 12, 5 );
INSERT INTO user_dept (user_id, dept_id) VALUES ( 13, 6 );
INSERT INTO user_dept (user_id, dept_id) VALUES ( 14, 4 );
INSERT INTO user_dept (user_id, dept_id) VALUES ( 15, 3 );
INSERT INTO user_dept (user_id, dept_id) VALUES ( 16, 6 );
INSERT INTO user_dept (user_id, dept_id) VALUES ( 17, 3 );
INSERT INTO user_dept (user_id, dept_id) VALUES ( 18, 7 );
INSERT INTO user_dept (user_id, dept_id) VALUES ( 19, 7 );
INSERT INTO user_dept (user_id, dept_id) VALUES ( 20, 1 );
INSERT INTO user_dept (user_id, dept_id) VALUES ( 21, 2 );
INSERT INTO user_dept (user_id, dept_id) VALUES ( 22, 6 );
INSERT INTO user_dept (user_id, dept_id) VALUES ( 23, 3 );
INSERT INTO user_dept (user_id, dept_id) VALUES ( 24, 4 );
INSERT INTO user_dept (user_id, dept_id) VALUES ( 25, 5 );
INSERT INTO user_dept (user_id, dept_id) VALUES ( 26, 6 );
INSERT INTO user_dept (user_id, dept_id) VALUES ( 27, 7 );
INSERT INTO user_dept (user_id, dept_id) VALUES ( 28, 2 );
INSERT INTO user_dept (user_id, dept_id) VALUES ( 29, 3 );
INSERT INTO user_dept (user_id, dept_id) VALUES ( 30, 1 );
INSERT INTO user_dept (user_id, dept_id) VALUES ( 31, 3 );
INSERT INTO user_dept (user_id, dept_id) VALUES ( 32, 4 );
INSERT INTO user_dept (user_id, dept_id) VALUES ( 33, 6 );
INSERT INTO user_dept (user_id, dept_id) VALUES ( 34, 7 );
INSERT INTO user_dept (user_id, dept_id) VALUES ( 35, 2 );
INSERT INTO user_dept (user_id, dept_id) VALUES ( 36, 3 );

INSERT INTO user_permission (user_id, permission_id) VALUES ( 1,  1 );
INSERT INTO user_permission (user_id, permission_id) VALUES ( 1,  3 );
INSERT INTO user_permission (user_id, permission_id) VALUES ( 1,  4 );
INSERT INTO user_permission (user_id, permission_id) VALUES ( 2,  4 );
INSERT INTO user_permission (user_id, permission_id) VALUES ( 2,  1 );
INSERT INTO user_permission (user_id, permission_id) VALUES ( 4,  3 );
INSERT INTO user_permission (user_id, permission_id) VALUES ( 4,  4 );
INSERT INTO user_permission (user_id, permission_id) VALUES ( 4,  5 );
INSERT INTO user_permission (user_id, permission_id) VALUES ( 4,  6 );
INSERT INTO user_permission (user_id, permission_id) VALUES ( 5,  2 );
INSERT INTO user_permission (user_id, permission_id) VALUES ( 6,  6 );
INSERT INTO user_permission (user_id, permission_id) VALUES ( 7,  2 );
INSERT INTO user_permission (user_id, permission_id) VALUES ( 8,  1 );
INSERT INTO user_permission (user_id, permission_id) VALUES ( 9,  2 );
INSERT INTO user_permission (user_id, permission_id) VALUES ( 10, 3 );
INSERT INTO user_permission (user_id, permission_id) VALUES ( 10, 2 );
INSERT INTO user_permission (user_id, permission_id) VALUES ( 10, 1 );
INSERT INTO user_permission (user_id, permission_id) VALUES ( 11, 4 );
INSERT INTO user_permission (user_id, permission_id) VALUES ( 11, 6 );
INSERT INTO user_permission (user_id, permission_id) VALUES ( 12, 5 );
INSERT INTO user_permission (user_id, permission_id) VALUES ( 12, 1 );
INSERT INTO user_permission (user_id, permission_id) VALUES ( 12, 2 );
INSERT INTO user_permission (user_id, permission_id) VALUES ( 13, 1 );
INSERT INTO user_permission (user_id, permission_id) VALUES ( 13, 2 );
INSERT INTO user_permission (user_id, permission_id) VALUES ( 13, 3 );
INSERT INTO user_permission (user_id, permission_id) VALUES ( 13, 6 );
INSERT INTO user_permission (user_id, permission_id) VALUES ( 18, 3 );
INSERT INTO user_permission (user_id, permission_id) VALUES ( 18, 2 );
INSERT INTO user_permission (user_id, permission_id) VALUES ( 18, 1 );
INSERT INTO user_permission (user_id, permission_id) VALUES ( 20, 1 );
INSERT INTO user_permission (user_id, permission_id) VALUES ( 20, 2 );
INSERT INTO user_permission (user_id, permission_id) VALUES ( 20, 3 );
INSERT INTO user_permission (user_id, permission_id) VALUES ( 21, 2 );
INSERT INTO user_permission (user_id, permission_id) VALUES ( 21, 4 );
INSERT INTO user_permission (user_id, permission_id) VALUES ( 22, 6 );
INSERT INTO user_permission (user_id, permission_id) VALUES ( 22, 3 );
INSERT INTO user_permission (user_id, permission_id) VALUES ( 22, 2 );
INSERT INTO user_permission (user_id, permission_id) VALUES ( 30, 1 );
INSERT INTO user_permission (user_id, permission_id) VALUES ( 30, 5 );
INSERT INTO user_permission (user_id, permission_id) VALUES ( 30, 3 );
INSERT INTO user_permission (user_id, permission_id) VALUES ( 31, 3 );
INSERT INTO user_permission (user_id, permission_id) VALUES ( 32, 4 );
INSERT INTO user_permission (user_id, permission_id) VALUES ( 33, 6 );
INSERT INTO user_permission (user_id, permission_id) VALUES ( 34, 1 );
INSERT INTO user_permission (user_id, permission_id) VALUES ( 34, 2 );
INSERT INTO user_permission (user_id, permission_id) VALUES ( 34, 3 );
INSERT INTO user_permission (user_id, permission_id) VALUES ( 35, 2 );
INSERT INTO user_permission (user_id, permission_id) VALUES ( 36, 3 );

INSERT INTO sites (name) VALUES ( 'Edinburgh' );
INSERT INTO sites (name) VALUES ( 'London' );
INSERT INTO sites (name) VALUES ( 'Paris' );
INSERT INTO sites (name) VALUES ( 'New York' );
INSERT INTO sites (name) VALUES ( 'Singapore' );
INSERT INTO sites (name) VALUES ( 'Los Angeles' );


--
-- Reading list example table
--
BEGIN
	EditorDelObject('audiobooks', 'TABLE');
	EditorDelObject('audiobooks_seq', 'SEQUENCE');
END;


CREATE TABLE audiobooks (
	id INT PRIMARY KEY NOT NULL,
	title VARCHAR(1000),
	author VARCHAR(1000),
	duration INT DEFAULT 0,
	readingOrder INT DEFAULT 0
);

CREATE SEQUENCE audiobooks_seq;

CREATE OR REPLACE TRIGGER audiobooks_on_insert
	BEFORE INSERT ON audiobooks
	FOR EACH ROW
	BEGIN
		SELECT audiobooks_seq.nextval
		INTO :new.id
		FROM dual;
	END;

INSERT INTO audiobooks (title, author, duration, readingOrder) VALUES  ( 'The Final Empire: Mistborn', 'Brandon Sanderson', 1479, 1 );
INSERT INTO audiobooks (title, author, duration, readingOrder) VALUES  ( 'The Name of the Wind', 'Patrick Rothfuss', 983, 2 );
INSERT INTO audiobooks (title, author, duration, readingOrder) VALUES  ( 'The Blade Itself: The First Law', 'Joe Abercrombie', 1340, 3 );
INSERT INTO audiobooks (title, author, duration, readingOrder) VALUES  ( 'The Heroes', 'Joe Abercrombie', 1390, 4 );
INSERT INTO audiobooks (title, author, duration, readingOrder) VALUES  ( 'Assassin''s Apprentice: The Farseer Trilogy', 'Robin Hobb', 1043, 5 );
INSERT INTO audiobooks (title, author, duration, readingOrder) VALUES  ( 'The Eye of the World: Wheel of Time', 'Robert Jordan', 1802, 6 );
INSERT INTO audiobooks (title, author, duration, readingOrder) VALUES  ( 'The Wise Man''s Fear', 'Patrick Rothfuss', 1211, 7 );
INSERT INTO audiobooks (title, author, duration, readingOrder) VALUES  ( 'The Way of Kings: The Stormlight Archive', 'Brandon Sanderson', 2734, 8 );
INSERT INTO audiobooks (title, author, duration, readingOrder) VALUES  ( 'The Lean Startup', 'Eric Ries', 523, 9 );
INSERT INTO audiobooks (title, author, duration, readingOrder) VALUES  ( 'House of Suns', 'Alastair Reynolds', 1096, 10 );
INSERT INTO audiobooks (title, author, duration, readingOrder) VALUES  ( 'The Lies of Locke Lamora', 'Scott Lynch', 1323, 11 );
INSERT INTO audiobooks (title, author, duration, readingOrder) VALUES  ( 'Best Served Cold', 'Joe Abercrombie', 1592, 12 );
INSERT INTO audiobooks (title, author, duration, readingOrder) VALUES  ( 'Thinking, Fast and Slow', 'Daniel Kahneman', 1206, 13 );
INSERT INTO audiobooks (title, author, duration, readingOrder) VALUES  ( 'The Dark Tower I: The Gunslinger', 'Stephen King', 439, 14 );
INSERT INTO audiobooks (title, author, duration, readingOrder) VALUES  ( 'Theft of Swords: Riyria Revelations', 'Michael J. Sullivan', 1357, 15 );
INSERT INTO audiobooks (title, author, duration, readingOrder) VALUES  ( 'The Emperor''s Blades: Chronicle of the Unhewn Throne', 'Brian Staveley', 1126, 16 );
INSERT INTO audiobooks (title, author, duration, readingOrder) VALUES  ( 'The Magic of Recluce: Saga of Recluce', 'L. E. Modesitt Jr.', 1153, 17 );
INSERT INTO audiobooks (title, author, duration, readingOrder) VALUES  ( 'Red Country', 'Joe Abercrombie', 1196, 18 );
INSERT INTO audiobooks (title, author, duration, readingOrder) VALUES  ( 'Warbreaker', 'Brandon Sanderson', 1496, 19 );
INSERT INTO audiobooks (title, author, duration, readingOrder) VALUES  ( 'Magician', 'Raymond E. Feist', 2173, 20 );
INSERT INTO audiobooks (title, author, duration, readingOrder) VALUES  ( 'Blood Song', 'Anthony Ryan', 1385, 21 );
INSERT INTO audiobooks (title, author, duration, readingOrder) VALUES  ( 'Half a King', 'Joe Abercrombie', 565, 22 );
INSERT INTO audiobooks (title, author, duration, readingOrder) VALUES  ( 'Prince of Thorns: Broken Empire', 'Mark Lawrence', 537, 23 );
INSERT INTO audiobooks (title, author, duration, readingOrder) VALUES  ( 'The Immortal Prince: Tide Lords', 'Jennifer Fallon', 1164, 24 );
INSERT INTO audiobooks (title, author, duration, readingOrder) VALUES  ( 'Medalon: Demon Child', 'Jennifer Fallon', 1039, 25 );
INSERT INTO audiobooks (title, author, duration, readingOrder) VALUES  ( 'The Black Company: Chronicles of The Black Company', 'Glen Cook', 654, 26 );


--
-- Compound key examples
--
BEGIN
	EditorDelObject('users_visits', 'TABLE');
END;

CREATE TABLE users_visits (
    user_id INT NOT NULL,
    site_id INT NOT NULL,
    visit_date DATE DEFAULT NULL,
    CONSTRAINT users_visits_pkey PRIMARY KEY (user_id, visit_date)
);

INSERT INTO users_visits (user_id, site_id, visit_date) VALUES  ( 1, 1, '12-Aug-2016' );
INSERT INTO users_visits (user_id, site_id, visit_date) VALUES  ( 1, 4, '14-Aug-2016' );
INSERT INTO users_visits (user_id, site_id, visit_date) VALUES  ( 1, 7, '19-Aug-2016' );
INSERT INTO users_visits (user_id, site_id, visit_date) VALUES  ( 2, 3, '12-Jul-2016' );
INSERT INTO users_visits (user_id, site_id, visit_date) VALUES  ( 2, 2, '07-Jul-2016' );
INSERT INTO users_visits (user_id, site_id, visit_date) VALUES  ( 2, 6, '01-Jul-2016' );
INSERT INTO users_visits (user_id, site_id, visit_date) VALUES  ( 2, 1, '30-Jul-2016' );
INSERT INTO users_visits (user_id, site_id, visit_date) VALUES  ( 3, 1, '26-Jun-2016' );
INSERT INTO users_visits (user_id, site_id, visit_date) VALUES  ( 3, 2, '05-Dec-2016' );
INSERT INTO users_visits (user_id, site_id, visit_date) VALUES  ( 4, 3, '21-Nov-2016' );
INSERT INTO users_visits (user_id, site_id, visit_date) VALUES  ( 4, 4, '10-Oct-2016' );
INSERT INTO users_visits (user_id, site_id, visit_date) VALUES  ( 5, 5, '02-Aug-2016' );
INSERT INTO users_visits (user_id, site_id, visit_date) VALUES  ( 6, 6, '05-Aug-2016' );

COMMIT;
--
-- DataTables Ajax and server-side processing database (SQL Server)
--
BEGIN
	EditorDelObject('datatables_demo', 'TABLE');
	EditorDelObject('datatables_demo_seq', 'SEQUENCE');
END;

CREATE TABLE datatables_demo (
	id INT PRIMARY KEY NOT NULL,
	first_name VARCHAR(250),
	last_name  VARCHAR(250),
	position   VARCHAR(250),
	email      VARCHAR(250),
	office     VARCHAR(250),
	start_date DATE,
	age        INT,
	salary     INT,
	seq        INT,
	extn       VARCHAR(8)
);

CREATE SEQUENCE datatables_demo_seq;

CREATE OR REPLACE TRIGGER datatables_demo_on_insert
	BEFORE INSERT ON datatables_demo
	FOR EACH ROW
	BEGIN
		SELECT datatables_demo_seq.nextval
		INTO :new.id
		FROM dual;
	END;
INSERT INTO datatables_demo ( first_name, last_name, age, position, salary, start_date, extn, email, office, seq ) VALUES ( 'Tiger', 'Nixon', 61, 'System Architect', 320800, '25-Apr-2011', 5421, 't.nixon@datatables.net', 'Edinburgh', 2 );
INSERT INTO datatables_demo ( first_name, last_name, age, position, salary, start_date, extn, email, office, seq ) VALUES ( 'Garrett', 'Winters', 63, 'Accountant', 170750, '25-Jul-2011', 8422, 'g.winters@datatables.net', 'Tokyo', 22 );
INSERT INTO datatables_demo ( first_name, last_name, age, position, salary, start_date, extn, email, office, seq ) VALUES ( 'Ashton', 'Cox', 66, 'Junior Technical Author', 86000, '12-Jan-2009', 1562, 'a.cox@datatables.net', 'San Francisco', 6 );
INSERT INTO datatables_demo ( first_name, last_name, age, position, salary, start_date, extn, email, office, seq ) VALUES ( 'Cedric', 'Kelly', 22, 'Senior Javascript Developer', 433060, '29-Mar-2012', 6224, 'c.kelly@datatables.net', 'Edinburgh', 41 );
INSERT INTO datatables_demo ( first_name, last_name, age, position, salary, start_date, extn, email, office, seq ) VALUES ( 'Airi', 'Satou', 33, 'Accountant', 162700, '28-Nov-2008', 5407, 'a.satou@datatables.net', 'Tokyo', 55 );
INSERT INTO datatables_demo ( first_name, last_name, age, position, salary, start_date, extn, email, office, seq ) VALUES ( 'Brielle', 'Williamson', 61, 'Integration Specialist', 372000, '02-Dec-2012', 4804, 'b.williamson@datatables.net', 'New York', 21 );
INSERT INTO datatables_demo ( first_name, last_name, age, position, salary, start_date, extn, email, office, seq ) VALUES ( 'Herrod', 'Chandler', 59, 'Sales Assistant', 137500, '06-Aug-2012', 9608, 'h.chandler@datatables.net', 'San Francisco', 46 );
INSERT INTO datatables_demo ( first_name, last_name, age, position, salary, start_date, extn, email, office, seq ) VALUES ( 'Rhona', 'Davidson', 55, 'Integration Specialist', 327900, '14-Oct-2010', 6200, 'r.davidson@datatables.net', 'Tokyo', 50 );
INSERT INTO datatables_demo ( first_name, last_name, age, position, salary, start_date, extn, email, office, seq ) VALUES ( 'Colleen', 'Hurst', 39, 'Javascript Developer', 205500, '15-Sep-2009', 2360, 'c.hurst@datatables.net', 'San Francisco', 26 );
INSERT INTO datatables_demo ( first_name, last_name, age, position, salary, start_date, extn, email, office, seq ) VALUES ( 'Sonya', 'Frost', 23, 'Software Engineer', 103600, '13-Dec-2008', 1667, 's.frost@datatables.net', 'Edinburgh', 18 );
INSERT INTO datatables_demo ( first_name, last_name, age, position, salary, start_date, extn, email, office, seq ) VALUES ( 'Jena', 'Gaines', 30, 'Office Manager', 90560, '19-Dec-2008', 3814, 'j.gaines@datatables.net', 'London', 13 );
INSERT INTO datatables_demo ( first_name, last_name, age, position, salary, start_date, extn, email, office, seq ) VALUES ( 'Quinn', 'Flynn', 22, 'Support Lead', 342000, '03-Mar-2013', 9497, 'q.flynn@datatables.net', 'Edinburgh', 23 );
INSERT INTO datatables_demo ( first_name, last_name, age, position, salary, start_date, extn, email, office, seq ) VALUES ( 'Charde', 'Marshall', 36, 'Regional Director', 470600, '16-Oct-2008', 6741, 'c.marshall@datatables.net', 'San Francisco', 14 );
INSERT INTO datatables_demo ( first_name, last_name, age, position, salary, start_date, extn, email, office, seq ) VALUES ( 'Haley', 'Kennedy', 43, 'Senior Marketing Designer', 313500, '18-Dec-2012', 3597, 'h.kennedy@datatables.net', 'London', 12 );
INSERT INTO datatables_demo ( first_name, last_name, age, position, salary, start_date, extn, email, office, seq ) VALUES ( 'Tatyana', 'Fitzpatrick', 19, 'Regional Director', 385750, '17-Mar-2010', 1965, 't.fitzpatrick@datatables.net', 'London', 54 );
INSERT INTO datatables_demo ( first_name, last_name, age, position, salary, start_date, extn, email, office, seq ) VALUES ( 'Michael', 'Silva', 66, 'Marketing Designer', 198500, '27-Nov-2012', 1581, 'm.silva@datatables.net', 'London', 37 );
INSERT INTO datatables_demo ( first_name, last_name, age, position, salary, start_date, extn, email, office, seq ) VALUES ( 'Paul', 'Byrd', 64, 'Chief Financial Officer (CFO)', 725000, '09-Jun-2010', 3059, 'p.byrd@datatables.net', 'New York', 32 );
INSERT INTO datatables_demo ( first_name, last_name, age, position, salary, start_date, extn, email, office, seq ) VALUES ( 'Gloria', 'Little', 59, 'Systems Administrator', 237500, '10-Apr-2009', 1721, 'g.little@datatables.net', 'New York', 35 );
INSERT INTO datatables_demo ( first_name, last_name, age, position, salary, start_date, extn, email, office, seq ) VALUES ( 'Bradley', 'Greer', 41, 'Software Engineer', 132000, '13-Oct-2012', 2558, 'b.greer@datatables.net', 'London', 48 );
INSERT INTO datatables_demo ( first_name, last_name, age, position, salary, start_date, extn, email, office, seq ) VALUES ( 'Dai', 'Rios', 35, 'Personnel Lead', 217500, '26-Sep-2012', 2290, 'd.rios@datatables.net', 'Edinburgh', 45 );
INSERT INTO datatables_demo ( first_name, last_name, age, position, salary, start_date, extn, email, office, seq ) VALUES ( 'Jenette', 'Caldwell', 30, 'Development Lead', 345000, '03-Sep-2011', 1937, 'j.caldwell@datatables.net', 'New York', 17 );
INSERT INTO datatables_demo ( first_name, last_name, age, position, salary, start_date, extn, email, office, seq ) VALUES ( 'Yuri', 'Berry', 40, 'Chief Marketing Officer (CMO)', 675000, '25-Jun-2009', 6154, 'y.berry@datatables.net', 'New York', 57 );
INSERT INTO datatables_demo ( first_name, last_name, age, position, salary, start_date, extn, email, office, seq ) VALUES ( 'Caesar', 'Vance', 21, 'Pre-Sales Support', 106450, '12-Dec-2011', 8330, 'c.vance@datatables.net', 'New York', 29 );
INSERT INTO datatables_demo ( first_name, last_name, age, position, salary, start_date, extn, email, office, seq ) VALUES ( 'Doris', 'Wilder', 23, 'Sales Assistant', 85600, '20-Sep-2010', 3023, 'd.wilder@datatables.net', 'Sidney', 56 );
INSERT INTO datatables_demo ( first_name, last_name, age, position, salary, start_date, extn, email, office, seq ) VALUES ( 'Angelica', 'Ramos', 47, 'Chief Executive Officer (CEO)', 1200000, '09-Oct-2009', 5797, 'a.ramos@datatables.net', 'London', 36 );
INSERT INTO datatables_demo ( first_name, last_name, age, position, salary, start_date, extn, email, office, seq ) VALUES ( 'Gavin', 'Joyce', 42, 'Developer', 92575, '22-Dec-2010', 8822, 'g.joyce@datatables.net', 'Edinburgh', 5 );
INSERT INTO datatables_demo ( first_name, last_name, age, position, salary, start_date, extn, email, office, seq ) VALUES ( 'Jennifer', 'Chang', 28, 'Regional Director', 357650, '14-Nov-2010', 9239, 'j.chang@datatables.net', 'Singapore', 51 );
INSERT INTO datatables_demo ( first_name, last_name, age, position, salary, start_date, extn, email, office, seq ) VALUES ( 'Brenden', 'Wagner', 28, 'Software Engineer', 206850, '07-Jun-2011', 1314, 'b.wagner@datatables.net', 'San Francisco', 20 );
INSERT INTO datatables_demo ( first_name, last_name, age, position, salary, start_date, extn, email, office, seq ) VALUES ( 'Fiona', 'Green', 48, 'Chief Operating Officer (COO)', 850000, '11-Mar-2010', 2947, 'f.green@datatables.net', 'San Francisco', 7 );
INSERT INTO datatables_demo ( first_name, last_name, age, position, salary, start_date, extn, email, office, seq ) VALUES ( 'Shou', 'Itou', 20, 'Regional Marketing', 163000, '14-Aug-2011', 8899, 's.itou@datatables.net', 'Tokyo', 1 );
INSERT INTO datatables_demo ( first_name, last_name, age, position, salary, start_date, extn, email, office, seq ) VALUES ( 'Michelle', 'House', 37, 'Integration Specialist', 95400, '02-Jun-2011', 2769, 'm.house@datatables.net', 'Sidney', 39 );
INSERT INTO datatables_demo ( first_name, last_name, age, position, salary, start_date, extn, email, office, seq ) VALUES ( 'Suki', 'Burks', 53, 'Developer', 114500, '22-Oct-2009', 6832, 's.burks@datatables.net', 'London', 40 );
INSERT INTO datatables_demo ( first_name, last_name, age, position, salary, start_date, extn, email, office, seq ) VALUES ( 'Prescott', 'Bartlett', 27, 'Technical Author', 145000, '07-May-2011', 3606, 'p.bartlett@datatables.net', 'London', 47 );
INSERT INTO datatables_demo ( first_name, last_name, age, position, salary, start_date, extn, email, office, seq ) VALUES ( 'Gavin', 'Cortez', 22, 'Team Leader', 235500, '26-Oct-2008', 2860, 'g.cortez@datatables.net', 'San Francisco', 52 );
INSERT INTO datatables_demo ( first_name, last_name, age, position, salary, start_date, extn, email, office, seq ) VALUES ( 'Martena', 'Mccray', 46, 'Post-Sales support', 324050, '09-Mar-2011', 8240, 'm.mccray@datatables.net', 'Edinburgh', 8 );
INSERT INTO datatables_demo ( first_name, last_name, age, position, salary, start_date, extn, email, office, seq ) VALUES ( 'Unity', 'Butler', 47, 'Marketing Designer', 85675, '09-Dec-2009', 5384, 'u.butler@datatables.net', 'San Francisco', 24 );
INSERT INTO datatables_demo ( first_name, last_name, age, position, salary, start_date, extn, email, office, seq ) VALUES ( 'Howard', 'Hatfield', 51, 'Office Manager', 164500, '16-Dec-2008', 7031, 'h.hatfield@datatables.net', 'San Francisco', 38 );
INSERT INTO datatables_demo ( first_name, last_name, age, position, salary, start_date, extn, email, office, seq ) VALUES ( 'Hope', 'Fuentes', 41, 'Secretary', 109850, '12-Feb-2010', 6318, 'h.fuentes@datatables.net', 'San Francisco', 53 );
INSERT INTO datatables_demo ( first_name, last_name, age, position, salary, start_date, extn, email, office, seq ) VALUES ( 'Vivian', 'Harrell', 62, 'Financial Controller', 452500, '14-Feb-2009', 9422, 'v.harrell@datatables.net', 'San Francisco', 30 );
INSERT INTO datatables_demo ( first_name, last_name, age, position, salary, start_date, extn, email, office, seq ) VALUES ( 'Timothy', 'Mooney', 37, 'Office Manager', 136200, '11-Dec-2008', 7580, 't.mooney@datatables.net', 'London', 28 );
INSERT INTO datatables_demo ( first_name, last_name, age, position, salary, start_date, extn, email, office, seq ) VALUES ( 'Jackson', 'Bradshaw', 65, 'Director', 645750, '26-Sep-2008', 1042, 'j.bradshaw@datatables.net', 'New York', 34 );
INSERT INTO datatables_demo ( first_name, last_name, age, position, salary, start_date, extn, email, office, seq ) VALUES ( 'Olivia', 'Liang', 64, 'Support Engineer', 234500, '03-Feb-2011', 2120, 'o.liang@datatables.net', 'Singapore', 4 );
INSERT INTO datatables_demo ( first_name, last_name, age, position, salary, start_date, extn, email, office, seq ) VALUES ( 'Bruno', 'Nash', 38, 'Software Engineer', 163500, '03-May-2011', 6222, 'b.nash@datatables.net', 'London', 3 );
INSERT INTO datatables_demo ( first_name, last_name, age, position, salary, start_date, extn, email, office, seq ) VALUES ( 'Sakura', 'Yamamoto', 37, 'Support Engineer', 139575, '19-Aug-2009', 9383, 's.yamamoto@datatables.net', 'Tokyo', 31 );
INSERT INTO datatables_demo ( first_name, last_name, age, position, salary, start_date, extn, email, office, seq ) VALUES ( 'Thor', 'Walton', 61, 'Developer', 98540, '11-Aug-2013', 8327, 't.walton@datatables.net', 'New York', 11 );
INSERT INTO datatables_demo ( first_name, last_name, age, position, salary, start_date, extn, email, office, seq ) VALUES ( 'Finn', 'Camacho', 47, 'Support Engineer', 87500, '07-Jul-2009', 2927, 'f.camacho@datatables.net', 'San Francisco', 10 );
INSERT INTO datatables_demo ( first_name, last_name, age, position, salary, start_date, extn, email, office, seq ) VALUES ( 'Serge', 'Baldwin', 64, 'Data Coordinator', 138575, '09-Apr-2012', 8352, 's.baldwin@datatables.net', 'Singapore', 44 );
INSERT INTO datatables_demo ( first_name, last_name, age, position, salary, start_date, extn, email, office, seq ) VALUES ( 'Zenaida', 'Frank', 63, 'Software Engineer', 125250, '04-Jan-2010', 7439, 'z.frank@datatables.net', 'New York', 42 );
INSERT INTO datatables_demo ( first_name, last_name, age, position, salary, start_date, extn, email, office, seq ) VALUES ( 'Zorita', 'Serrano', 56, 'Software Engineer', 115000, '01-Jun-2012', 4389, 'z.serrano@datatables.net', 'San Francisco', 27 );
INSERT INTO datatables_demo ( first_name, last_name, age, position, salary, start_date, extn, email, office, seq ) VALUES ( 'Jennifer', 'Acosta', 43, 'Junior Javascript Developer', 75650, '01-Feb-2013', 3431, 'j.acosta@datatables.net', 'Edinburgh', 49 );
INSERT INTO datatables_demo ( first_name, last_name, age, position, salary, start_date, extn, email, office, seq ) VALUES ( 'Cara', 'Stevens', 46, 'Sales Assistant', 145600, '06-Dec-2011', 3990, 'c.stevens@datatables.net', 'New York', 15 );
INSERT INTO datatables_demo ( first_name, last_name, age, position, salary, start_date, extn, email, office, seq ) VALUES ( 'Hermione', 'Butler', 47, 'Regional Director', 356250, '21-Mar-2011', 1016, 'h.butler@datatables.net', 'London', 9 );
INSERT INTO datatables_demo ( first_name, last_name, age, position, salary, start_date, extn, email, office, seq ) VALUES ( 'Lael', 'Greer', 21, 'Systems Administrator', 103500, '27-Feb-2009', 6733, 'l.greer@datatables.net', 'London', 25 );
INSERT INTO datatables_demo ( first_name, last_name, age, position, salary, start_date, extn, email, office, seq ) VALUES ( 'Jonas', 'Alexander', 30, 'Developer', 86500, '14-Jul-2010', 8196, 'j.alexander@datatables.net', 'San Francisco', 33 );
INSERT INTO datatables_demo ( first_name, last_name, age, position, salary, start_date, extn, email, office, seq ) VALUES ( 'Shad', 'Decker', 51, 'Regional Director', 183000, '13-Nov-2008', 6373, 's.decker@datatables.net', 'Edinburgh', 43 );
INSERT INTO datatables_demo ( first_name, last_name, age, position, salary, start_date, extn, email, office, seq ) VALUES ( 'Michael', 'Bruce', 29, 'Javascript Developer', 183000, '27-Jun-2011', 5384, 'm.bruce@datatables.net', 'Singapore', 16 );
INSERT INTO datatables_demo ( first_name, last_name, age, position, salary, start_date, extn, email, office, seq ) VALUES ( 'Donna', 'Snider', 27, 'Customer Support', 112000, '25-Jan-2011', 4226, 'd.snider@datatables.net', 'New York', 19 );

COMMIT;
