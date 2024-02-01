# Configure Supervisor

create a supervisor configuration file in /etc/supervisor/conf.d, (project-name-worker.conf)
````sh
sudo vim project-name-worker.conf
````
Then paste the below code:
````sh
[program:project-name-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/project-name.com/public_html/artisan queue:work --sleep=3 --tries=3
autostart=true
autorestart=true
user=ubuntu
numprocs=8
redirect_stderr=true
stdout_logfile=/var/www/project-name.com/public_html/storage/logs/worker.log
stopwaitsecs=3600
````
## Reload Supervisor
Once you have created your configuration file, you will need to tell Supervisor to reload its configuration:
````sh
sudo supervisorctl reread
sudo supervisorctl update
````

## Start the Laravel Queue
````sh
sudo supervisorctl start laravel-worker:*
````

