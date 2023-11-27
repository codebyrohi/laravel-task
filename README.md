Practical task :
CRUD operation -> Create a CRUD operation module with 2 method's
1.Post method -> whatever values will be submitted should show on same page.
2.AJAX method -> whatever values will be submitted using AJAX should show on same page.
3.File upload - upload file which contain some demo record, once upload all the record should show in a table(datatable preferable).

Before you begin, ensure that you have the following installed:
php >= 7.3
Composer
laravel = 8.75

Steps to follow for the setup of project
1) git clone https://github.com/your-username/laravel-crud-module.git

2) cd laravel-crud-module

3) php artisan key:generate

4) php artisan migrate

5) in case it failed to load the page due to cache , i have created one route to clear cache 
execute  the below url
http://localhost/users-management-system/clear_cache

