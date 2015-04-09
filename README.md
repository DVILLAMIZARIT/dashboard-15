# dashboard
My first project (and publication) : Dashboard "clef en main" which means you are supposed to be able to use it right after downloading it (in theory......)

Tested on localhost only (for now) and MySQL database

-> Confirm that you have MySQL 
-> update your env file according to your configuration ( user, password, database)
   -> do not forget to specify the database you want to connect with as the next step is to generate tables inside
-> run php artisan migrate (do not use seed parameters ! seeding is already planned within migration files)
   -> will generate tables and seed them with basics data
-> run php artisan serve
   -> get the port number
-> use the dashboard on localhost:[port number]/Dashboard
   -> have a try
