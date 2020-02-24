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

|  Functionality | Code  | State  | Issues |
|---|---|---|---|
| Login            | `login()`  | Working |
| Login as admin   | `login()`  | Working | 
| Logout            | `login()`  | Working | 
| Edit own profile | `edit_self()` | Needs work |   Emulate edit().
| Results display  | `index()`  | Working  |
| Results pagination  | `Paginator`  | Working  |
| Results sort  | `Paginator`  | Working  | Except for `id_str` and `duration`, which are computed properties. Need to figure out how to get Paginator to sort by these columns.
| Results delete  | `delete()`  | Working  |
| Results search  | `search()`  | Working  |
| Results - Listen to recording  | Link to URL  | Working  |
| Results search   | `search()`  | Working  |
| Results filter by date   | `index()`   | Working  |Fixed
| Results import   | `import()`  | Working  |
| Results export   | `export()`  | Working  | 
| Users display    | `index()`  | Working  |
| Users pagination  | `Paginator`  | Working  |
| Users sort  | `Paginator`  | Working  |
| Users filter     | `index()`   | Working  | Fixed.
| Users search     | `search()`  | Working  |
| Users delete        | `delete()`     | Working  |
| Users edit      | `edit()`    | Needs work | Have to get `$user->id` into the modal to prepopulate fields. |
| Users add        | `add()`     | Working...  | But need to get password strength validation working 

So, a few things to sort out there.


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

________________________________
# TODO 2020-02-18

## Local dev

- In "Edit User" modal, need to prepopulate inputs (except `password` and `confirm_password`).

- Debug User filtering by status: selecting 'Active' or 'Inactive' both submit to `filter()`, and render correctly, but selecting 'All' does not seem to do anything.  See Element `userfilterdropdown.ctp`.   Also, dropdown does not retain setting; need to set this in view function when returning the response.

- Cannot sort by `id_str` or `duration` as these are computed properties, not model fields; there should be a way of doing this with the Paginator class.

- Filtering by date range seems to be broken now!   Also, need to send the data back to the datepickers.

- Exporting seems to be broken now!   Just writing the header row.

- Need to implement user self-edit.

## Heroku deployed application

- Importing a CSV file seems to corrupt the database immediately.   It returns an unstyled page listing including the imported results, but the "Internal Server Error".   Deleting all results from the database with SQL directly fixes this, but further attempted imports fail similarly.

- 
