# Test Results Portal

## Overview

The specification describes a Web Portal for viewing call test results.

A user will have the ability to login to the portal and find the results they need using standard features like search, sort and filters. Also, users will have the ability to import new results through the portal and also export test results that already exist.

There is an admin user role which can manage user accounts, creating/editing/deleting them as they see fit.

## Tech Stack

The following were used in development:

- XAMPP for Linux 7.2.26-0 (PHP 7.2.26, Apache/2.4.41 (Unix), MariaDB 10.4.11)
- CakePHP 3.8.8 - For the server code.
- Bootstrap 4.4 - For front end UI

## Database

- Name:     `trdb` in development, 
- Tables:   `users`, `results`

### Users Table

- Name:     `users`

### Results Table

- Name:     `results`

## Views (excluding modals)

### Unauthenticated

- Users::login() - Login view

### Authenticated - use Portal Template

- Results::index() - Results listing​ page
- Users::view() - User account page

### Authenticated + Admin

- Users::index() - Users listing page

# Heroku setup

- Clone this repo and push to Github
- Create new app from Heroku dashboard
    - name "tr-portal" (or whatever)
    - region Europe
- Click "Find more add-ons" and select "ClearDB MySQL"
- Click "Install ClearDB MySQL"
- Choose "tr-portal" as the app to provision
- Click "Provision add-on"
- Click "ClearDB MySQL"
- Copy the name and click it
- Go to the "System Information" tab and copy the username and password
- Go back to Settings => "Reveal Config Vars".   
    You will find the DSN set as CLEARDB_DATABASE_URL.
    This is the DSN needed to connect to the database.
    Create a new config var called DATABASE_URL, with the same value
        (as you will set `'url' => env('DATABASE_URL', null),` in `config/app.php`).
- Now set the username and password as config vars too:
    ```
    23:11: trportal $ heroku config:set USERNAME=unxxxxxxxx -a tr-portal
    Setting USERNAME and restarting ⬢ tr-portal... done, v5
    USERNAME: unxxxxxxxx
    ======================================================================================================================
    23:41: trportal $ heroku config:set PASSWORD=pwxxxxx -a tr-portal
    Setting PASSWORD and restarting ⬢ tr-portal... done, v6
    PASSWORD: pwxxxxx
    ```
    (or do it in the Heroku dashboard)
- Back in the dashboard, click the "Deploy" tab and go to "Deployment method".
- Click "Github", enter the Github repo name and click "Search"
- Your repo name should be displayed: click "Connect".
- Click "Enable Automatic Deploys".   You should see "Automatic deploys from  master are enabled".
- In `config/app.php` inside `Datasources' => ['default']` set the following:
    ```
    'username' => env('USERNAME', null),
    'password' => env('PASSWORD', null),
    'database' => env('DATABASE', null),
    ```
You may need to remove `config/app.php` from the default `.gitignore`.

Result:

Successful build on Heroku (with the default Procfile).   App starts, my login page displayed, but login produces Internal Server error.

And back on my localhost, the `env()` function does not seem to be getting the environment variables `USERNAME`, `PASSWORD` and `DATABASE` from the shell, though they are set in the shell.   

I check with `debug(env('USERNAME', null));` etc. in the `login()` method.

I have restarted the server to no avail.   

It picks up `root` correctly as the username, but not from the shell, as I changed it to `fred` and the `debug()` call still returned `root`.   So must investigate if it creates a subshell or what?   What environment is the application getting its environment variables from?

___________ 
To Do 2020-02-08:

- Fix above documented `env()` issues etc.

- Login bug: the first login fails, the second try works.  Check authorisation works correctly for non-admins (i.e. no access to Users except self).

- Implement password strength conditions and validation for user creation and update.

- Fix permissions issue for file creation in `ResultsController`'s `export()` method.

- Fix CSRF issue with file import.

- Fix user creation and update.

- Implement Search for users and results.

- Fix styling of Login page and check all styling.

- Check fixing login functionality obviates inappropriate Auth Flash messages.

- Check if some code can move from Controllers into models.

- Check code is reasonably DRY.

- Migrate and seed database.

- Testing.   CI/ CT using Travis?


## Notes

You must ensure:
- PHP is installed with the `mbstring` and `intl` extensions.
- The `tmp` and `logs` directories are writeable both by the web server and the
command line user.

## Database migration and seeding

```
$ bin/cake bake migration_snapshot -v Initial

Creating file /opt/lampp/htdocs/trportal/config/Migrations/20200208040050_Initial.php
Wrote `/opt/lampp/htdocs/trportal/config/Migrations/20200208040050_Initial.php`
Marking the migration 20200208040050_Initial as migrated...
using migration paths 
 - /opt/lampp/htdocs/trportal/config/Migrations
using seed paths 
 - /opt/lampp/htdocs/trportal/config/Seeds
Migration `20200208040050` successfully marked migrated !
Creating a dump of the new database state...
using migration paths 
 - /opt/lampp/htdocs/trportal/config/Migrations
using seed paths 
 - /opt/lampp/htdocs/trportal/config/Seeds
Writing dump file `/opt/lampp/htdocs/trportal/config/Migrations/schema-dump-default.lock`...
Dump file `/opt/lampp/htdocs/trportal/config/Migrations/schema-dump-default.lock` was successfully written
```


 

