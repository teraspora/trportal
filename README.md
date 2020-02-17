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

|  Functionality | Code  | State  | To do   | Notes  |
|---|---|---|---|---|
| Results search  | `search()`  | Done  |   | Test in deployed app  |
| Results import  | `import()`  | Done  |   | Test in deployed app  |
| Results export  | `export()`  | Done  |   | Test in deployed app  |
| Results filter  | `index()`   | Done  |   | Test in deployed app  |
| Users filter    | `index()`   | Done  |   | Test in deployed app  |
| Users search    | `search()`  | Done  |   | Test in deployed app  |
| Users edit      | `edit()`    | To do |   | Test in deployed app  |
| Users add       | `add()`     | To do |   | Test in deployed app  |


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

### Todo: 2020-17-02

- Debug results date-range filter, now broken!

- user add, user edit, self edit

- Implement password strength conditions and validation for user creation and update.

- Login bug - sometimes: the first login fails, the second try works.  Check authorisation works correctly for non-admins (i.e. no access to Users except self).

- Check fixing login functionality obviates inappropriate Auth Flash messages.

- Check all styling.

- Fix date range filtering.

- Add triggers to Heroku/Cleardb database.

- Testing.   CI/ CT using Travis?

- Check if some code can move from Controllers into models.

- Check code is reasonably DRY.

- Writeup README.

