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

Generate a snapshot of the local database using `bake`:

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

Attempt to apply migrations in Heroku:

```
$ heroku ps:exec -a tr-portal
Establishing credentials... done
Connecting to web.1 on ⬢ tr-portal... 
~ $ bin/cake migrations migrate
using migration paths

 - /app/config/Migrations
using seed paths

 - /app/config/Seeds
Exception: There was a problem connecting to the database: SQLSTATE[HY000] [2002] No such file or directory in [/app/vendor/robmorgan/phinx/src/Phinx/Db/Adapter/PdoAdapter.php, line 82]
2020-02-08 05:21:41 Error: [InvalidArgumentException] There was a problem connecting to the database: SQLSTATE[HY000] [2002] No such file or directory in /app/vendor/robmorgan/phinx/src/Phinx/Db/Adapter/PdoAdapter.php on line 82
Stack Trace:
#0 /app/vendor/robmorgan/phinx/src/Phinx/Db/Adapter/MysqlAdapter.php(116): Phinx\Db\Adapter\PdoAdapter->createPdoConnection('mysql:host=loca...', 'my_app', 'secret', Array)
#1 /app/vendor/robmorgan/phinx/src/Phinx/Db/Adapter/PdoAdapter.php(148): Phinx\Db\Adapter\MysqlAdapter->connect()
#2 /app/vendor/robmorgan/phinx/src/Phinx/Db/Adapter/AdapterWrapper.php(496): Phinx\Db\Adapter\PdoAdapter->getConnection()
#3 /app/vendor/cakephp/migrations/src/CakeAdapter.php(56): Phinx\Db\Adapter\AdapterWrapper->getConnection()
#4 /app/vendor/cakephp/migrations/src/Command/CommandTrait.php(77): Migrations\CakeAdapter->__construct(Object(Phinx\Db\Adapter\TimedOutputAdapter), Object(Cake\Database\Connection))
#5 /app/vendor/robmorgan/phinx/src/Phinx/Console/Command/Migrate.php(63): Migrations\Command\Migrate->bootstrap(Object(Symfony\Component\Console\Input\ArgvInput), Object(Symfony\Component\Console\Output\ConsoleOutput))
#6 /app/vendor/cakephp/migrations/src/Command/CommandTrait.php(34): Phinx\Console\Command\Migrate->execute(Object(Symfony\Component\Console\Input\ArgvInput), Object(Symfony\Component\Console\Output\ConsoleOutput))
#7 /app/vendor/cakephp/migrations/src/Command/Migrate.php(66): Migrations\Command\Migrate->parentExecute(Object(Symfony\Component\Console\Input\ArgvInput), Object(Symfony\Component\Console\Output\ConsoleOutput))
#8 /app/vendor/symfony/console/Command/Command.php(255): Migrations\Command\Migrate->execute(Object(Symfony\Component\Console\Input\ArgvInput), Object(Symfony\Component\Console\Output\ConsoleOutput))
#9 /app/vendor/symfony/console/Application.php(1011): Symfony\Component\Console\Command\Command->run(Object(Symfony\Component\Console\Input\ArgvInput), Object(Symfony\Component\Console\Output\ConsoleOutput))
#10 /app/vendor/symfony/console/Application.php(272): Symfony\Component\Console\Application->doRunCommand(Object(Migrations\Command\Migrate), Object(Symfony\Component\Console\Input\ArgvInput), Object(Symfony\Component\Console\Output\ConsoleOutput))
#11 /app/vendor/symfony/console/Application.php(148): Symfony\Component\Console\Application->doRun(Object(Symfony\Component\Console\Input\ArgvInput), Object(Symfony\Component\Console\Output\ConsoleOutput))
#12 /app/vendor/cakephp/migrations/src/Shell/MigrationsShell.php(108): Symfony\Component\Console\Application->run(Object(Symfony\Component\Console\Input\ArgvInput), Object(Symfony\Component\Console\Output\ConsoleOutput))
#13 /app/vendor/cakephp/cakephp/src/Console/Shell.php(531): Migrations\Shell\MigrationsShell->main('migrations', 'migrate')
#14 /app/vendor/cakephp/migrations/src/Shell/MigrationsShell.php(169): Cake\Console\Shell->runCommand(Array, true, Array)
#15 /app/vendor/cakephp/cakephp/src/Console/CommandRunner.php(385): Migrations\Shell\MigrationsShell->runCommand(Array, true)
#16 /app/vendor/cakephp/cakephp/src/Console/CommandRunner.php(162): Cake\Console\CommandRunner->runShell(Object(Migrations\Shell\MigrationsShell), Array)
#17 /app/bin/cake.php(12): Cake\Console\CommandRunner->run(Array)
#18 {main}

Caused by: [PDOException] SQLSTATE[HY000] [2002] No such file or directory in /app/vendor/robmorgan/phinx/src/Phinx/Db/Adapter/PdoAdapter.php on line 79
Stack Trace:
#0 /app/vendor/robmorgan/phinx/src/Phinx/Db/Adapter/PdoAdapter.php(79): PDO->__construct('mysql:host=loca...', 'my_app', 'secret', Array)
#1 /app/vendor/robmorgan/phinx/src/Phinx/Db/Adapter/MysqlAdapter.php(116): Phinx\Db\Adapter\PdoAdapter->createPdoConnection('mysql:host=loca...', 'my_app', 'secret', Array)
#2 /app/vendor/robmorgan/phinx/src/Phinx/Db/Adapter/PdoAdapter.php(148): Phinx\Db\Adapter\MysqlAdapter->connect()
#3 /app/vendor/robmorgan/phinx/src/Phinx/Db/Adapter/AdapterWrapper.php(496): Phinx\Db\Adapter\PdoAdapter->getConnection()
#4 /app/vendor/cakephp/migrations/src/CakeAdapter.php(56): Phinx\Db\Adapter\AdapterWrapper->getConnection()
#5 /app/vendor/cakephp/migrations/src/Command/CommandTrait.php(77): Migrations\CakeAdapter->__construct(Object(Phinx\Db\Adapter\TimedOutputAdapter), Object(Cake\Database\Connection))
#6 /app/vendor/robmorgan/phinx/src/Phinx/Console/Command/Migrate.php(63): Migrations\Command\Migrate->bootstrap(Object(Symfony\Component\Console\Input\ArgvInput), Object(Symfony\Component\Console\Output\ConsoleOutput))
#7 /app/vendor/cakephp/migrations/src/Command/CommandTrait.php(34): Phinx\Console\Command\Migrate->execute(Object(Symfony\Component\Console\Input\ArgvInput), Object(Symfony\Component\Console\Output\ConsoleOutput))
#8 /app/vendor/cakephp/migrations/src/Command/Migrate.php(66): Migrations\Command\Migrate->parentExecute(Object(Symfony\Component\Console\Input\ArgvInput), Object(Symfony\Component\Console\Output\ConsoleOutput))
#9 /app/vendor/symfony/console/Command/Command.php(255): Migrations\Command\Migrate->execute(Object(Symfony\Component\Console\Input\ArgvInput), Object(Symfony\Component\Console\Output\ConsoleOutput))
#10 /app/vendor/symfony/console/Application.php(1011): Symfony\Component\Console\Command\Command->run(Object(Symfony\Component\Console\Input\ArgvInput), Object(Symfony\Component\Console\Output\ConsoleOutput))
#11 /app/vendor/symfony/console/Application.php(272): Symfony\Component\Console\Application->doRunCommand(Object(Migrations\Command\Migrate), Object(Symfony\Component\Console\Input\ArgvInput), Object(Symfony\Component\Console\Output\ConsoleOutput))
#12 /app/vendor/symfony/console/Application.php(148): Symfony\Component\Console\Application->doRun(Object(Symfony\Component\Console\Input\ArgvInput), Object(Symfony\Component\Console\Output\ConsoleOutput))
#13 /app/vendor/cakephp/migrations/src/Shell/MigrationsShell.php(108): Symfony\Component\Console\Application->run(Object(Symfony\Component\Console\Input\ArgvInput), Object(Symfony\Component\Console\Output\ConsoleOutput))
#14 /app/vendor/cakephp/cakephp/src/Console/Shell.php(531): Migrations\Shell\MigrationsShell->main('migrations', 'migrate')
#15 /app/vendor/cakephp/migrations/src/Shell/MigrationsShell.php(169): Cake\Console\Shell->runCommand(Array, true, Array)
#16 /app/vendor/cakephp/cakephp/src/Console/CommandRunner.php(385): Migrations\Shell\MigrationsShell->runCommand(Array, true)
#17 /app/vendor/cakephp/cakephp/src/Console/CommandRunner.php(162): Cake\Console\CommandRunner->runShell(Object(Migrations\Shell\MigrationsShell), Array)
#18 /app/bin/cake.php(12): Cake\Console\CommandRunner->run(Array)
#19 {main}

```

Need to check
```
[PDOException] SQLSTATE[HY000] [2002] No such file or directory in /app/vendor/robmorgan/phinx/src/Phinx/Db/Adapter/PdoAdapter.php on line 79
```

Then check "Seeding" at https://book.cakephp.org/migrations/2/en/index.html.

_________________________________________________

### Todo: after implementing import and (mostly, except for tweaking date format) export:

conditional prev next paginator counter

import/export on deployed app?

add triggers to heroku database - 

user add, user edit, self edit

put top bar in grid container

test search & filtering - also in deployed app.

Writeup README.

Testing.

