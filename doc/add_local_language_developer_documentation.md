# Add Language

Update languages by adding a new language
 
## Requirements

- [ ] gettext installed on server, development environment

## Create files

- [ ] Create directory for language files in `Locale` directory
```
cd odesurvey
mkdir -p html/map/survey/Locale/[language]/LC_MESSAGES
touch html/map/survey/Locale/[language]/LC_MESSAGES/messages.po
```
- [ ] Copy content from Hackpad (or other source) into `../[language]/LC_MESSAGES/messages.po`

## Generate messages.mo file
- [ ] Test format of messages.po is correct and generate the file (use `sudo` if necessary)
```
cd odesurvey/html/map/survey/Locale/de_DE/LC_MESSAGES
/usr/local/Cellar/gettext/0.19.4/bin/msgfmt messages.po
```
#### Example
```
[vagrant@odesurvey LC_MESSAGES]$ cd /var/www/html/map/survey/Locale/de_DE/LC_MESSAGES
[vagrant@odesurvey LC_MESSAGES]$ msgfmt messages.po 
messages.po:511: end-of-line within string
msgfmt: found 1 fatal error
[vagrant@odesurvey LC_MESSAGES]$ msgfmt messages.po 
msgfmt: error while opening "messages.mo" for writing: Permission denied
[vagrant@odesurvey LC_MESSAGES]$ sudo msgfmt messages.po 
[vagrant@odesurvey LC_MESSAGES]$ 
```

## Add language to PHP templates
- [ ] Add language entry to `$langs` array in PHP template files `html/map/survey/templates/survey/tp_survey.php` and `html/map/survey/templates/survey/tp_survey_gettext.php`
```
$langs = array('es_MX' => 'Español', 'fr_FR' => 'Français', 'de_DE' => 'German', 'ru_RU' => 'Russkiy');
```

## Commit to repo
- [ ] Commit to repo
- [ ] Push repo

## Upload to servers
- [ ] See update_website.md

## Restart Apache servers
- [ ] Login into target server
- [ ] Run the following commands
```
sudo service apache2 restart
```
