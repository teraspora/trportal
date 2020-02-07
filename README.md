# Test Results Portal

## Overview

The specification describes a Web Portal for viewing call test results.

A user will have the ability to login to the portal and find the results they need using standard features like search, sort and filters. Also, users will have the ability to import new results through the portal and also export test results that already exist.

There will be an admin user role which can manage user accounts, creating/editing/deleting them as they see fit.

## Tech Stack

The following were used in development:

- XAMPP for Linux 7.2.26-0 (PHP 7.2.26, Apache/2.4.41 (Unix), MariaDB 10.4.11)
- CakePHP 3.8.8 - For the server code.
- Bootstrap 4.4 - For front end UI

## Database

- Name:     `testresults`
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

## Notes

You must ensure:
- PHP is installed with the `mbstring` and `intl` extensions.
- The `tmp` and `logs` directories are writeable both by the web server and the
command line user.
 

