# How to Use Supervisord for Your Laravel Application
Hello friends. Today, I want to talk about how to use Supervisord for Laravel apps. This is good for managing long-running processes like queues.

## What is Supervisord?
Supervisord is a utility for Linux systems. It watches over your long-running programs, making sure they keep working. If a program stops, Supervisord starts it again.

## Why Use It?
When you have tasks that need to run forever, like Laravel queues, it’s good to have Supervisord. It's better than just running a command in the background.

## Use Cases

### 1. Laravel Queues
   You have many emails to send. Without a queue, the user has to wait. With a queue, the task goes in the background.

Your Laravel command:
````linux
php artisan queue:work
````
Use Supervisord to keep it running.

### 2. Websockets
   You want real-time data in your app. Websockets are good but need to run all the time.

Your command might be:

````linux
php artisan websockets:serve
````

Supervisord can handle this too.

### 3. Custom Scripts
   You made a script to clean the database every hour. Instead of a cron job, you can use Supervisord.

Your custom script:
````linux
php artisan clean:database
````

## Let’s Install Supervisord
First, you need to install it:
````linux
sudo apt-get update
sudo apt-get install supervisor
````

## Configuring Supervisor for Laravel
Create a new config file:
````linux
sudo nano /etc/supervisor/conf.d/laravel-worker.conf
````
Put this code inside:
````linux
[program:laravel-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /path-to-your-laravel-app/artisan queue:work
autostart=true
autorestart=true
user=your-user
numprocs=1
redirect_stderr=true
stdout_logfile=/var/log/laravel-worker.log
````
Update the /path-to-your-laravel-app/ and your-user with your own info.

## Load and Start
Run these commands:
````linux
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start laravel-worker:*
````
That’s it. Now Supervisord will manage your Laravel queues.

## Using Supervisord with Docker
When working with Docker, it’s common to put all the settings close to your project. This way, when someone else needs to run your app, everything is ready. For Supervisord, you can do this by creating a specific configuration file inside your project. You place this file in a folder like .docker/web/, so it's easy to find and understand it's for the web service in Docker.

This method is good because:

1. Easy to Share: The config is in your codebase, so anyone who gets your code gets the config too.
2. Version Control: By keeping it in the project, you can track changes in git.
3. Isolation: Each project can have its own Supervisord settings without affecting others.
Now, let’s see the actual steps.

Create an example file at .docker/web/my-supervisor.conf and map in your docker-compose file:
````linux
version: '3'
services:
    web:
        image: your-image
        volumes:
            - .:/var/www/html 
            - ./.docker/web/my-supervisor.conf:/etc/supervisor/conf.d/my-supervisor.conf
````

With this setup, the my-supervisor.conf from your project will replace the one in Docker. Now Supervisord in Docker will use your settings to manage the Laravel queues.

Remember to rebuild your Docker containers after updating docker-compose.yml:

## Final Thoughts
Managing long-running processes can be a headache, but with Supervisord and Docker, we can make our lives much easier. By embedding Supervisord settings directly in our project folder, we not only make our setup more organized but also portable and easy to manage.

So, if you’ve been struggling with keeping your Laravel queues or other tasks running smoothly, give this approach a try. It brings peace of mind, knowing that everything is well-managed and will keep running as expected.

Thanks for taking the time to read this. I hope you find it helpful in your work. Cheers!
