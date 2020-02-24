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

- `Users::login()` - Login view

### Authenticated

- `Results::index()` - Results listing​ page
- `Results::search()` - As `index()` but filtered
- `Results::filter()` - As `index()` but filtered
- `Users::view()` - User's own account page

### Authenticated + Admin

- `Users::index()` - Users listing page
- `Users::search()` - As `index()` but filtered
- `Users::filter()` - As `index()` but filtered

### Modal Views

- `Results::import()` - Import results as csv
- `Users::add()`      - Add new user (Admin only)
- `Users::edit()`     - Add a user's details (Admin only)


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

___________ 

## Notes

You must ensure:
- PHP is installed with the `mbstring` and `intl` extensions.
- The `tmp` and `logs` directories are writeable both by the web server and the
command line user.

## Database migration and seeding

* Generate a snapshot of the local database using phpMyAdmin.
* Fire up a Mysql shell locally and connect to the remote database with its DSN, username and password.
* Paste in the sql and hit `Enter`!
_________________________________________________

### Current state 2020-02-24

#### Deviations from specification

- For the name of the database table, `results` has been used rather than `data` (to conform with CakePHP Inflexion convention).
- Field names `job_processing_uid` and `test_type_uid` have been used rather than `job_processing_id` and `test_type_id` (to avoid assumptions Cake, or bake, may make about field names ending in `_id` being foreign keys.)
- The `status` column of the `Users` table has been implemented as `TINYINT(2)` (as it has 3 possible values, and `TINYINT(1)` is interpreted as a Boolean.)

#### Assumptions

- "Target environment: Chrome" is assumed to mean a modern versions of Chrome which supports ES2015 and CSS3 syntax.   The application was developed using Chromium 79 and tested on Chrome 79.   For older versions it may be necessary to introduce tools like Babel into the workflow.
- Link to call audio recording has been set to open in a new tab.   This is not stated in the spec but seems sensible as it's an external link.
- Filtering by date range, and search (for results) and filtering by status and search (for users) are independent of each other.   It was not entirely clear to me what was intended from the spec.
- The oldest year for filtering results has been set at 1990.
- `Search` submits only when `Enter` is pressed.   It could be changed to submit each time a character is typed, but this would result in more HTTP requests - although perhaps for smaller datasets results could be cached at the front end?

### Todo: 2020-02-24

- Fix and test password validation on login, edit user and add user.

- Login bug - sometimes: the first login fails, the second try works.  Check authorisation works correctly for non-admins (i.e. no access to Users except self).

- Check fixing login functionality obviates inappropriate Auth Flash messages.

- Check all styling.

- Check if some code can move from Controllers into models.

- Check code is reasonably DRY.

- Writeup README.

- Cannot sort by `id_str` or `duration` as these are computed properties, not model fields; there should be a way of doing this with the Paginator class.
