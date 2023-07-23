## Running Laravel Queue Worker as a Systemd Service
### Prerequisites
Before we begin, you’ll need to ensure that your server meets the following requirements:

A Linux-based operating system
PHP version 7.2 or higher
The Laravel framework installed and configured
The Systemd init system installed and configured

### Creating a Systemd Service
$ sudo nano /etc/systemd/system/laravel-worker.service

Add the following content to the file:

[Unit]
Description=Laravel Queue Worker
After=network.target

[Service]
User=www-data
Group=www-data
Restart=always
WorkingDirectory=/path/to/your/laravel
ExecStart=/usr/bin/php artisan queue:work --sleep=3 --tries=3

[Install]
WantedBy=multi-user.target


Let’s break down this file and what each section means:

Unit:
This section defines the service unit and provides a brief description of what it does. The After parameter specifies that the service should start after the network target has been reached.

Service:
This section specifies the details of how the service should be run. The User and Group parameters specify the user and group that the service should run under. The “Restart” parameter specifies that the service should be restarted if it stops or crashes. The “ExecStart” parameter specifies the command that should be run to start the queue worker. In this case, we’re using the php binary to run the queue:work command with the --sleep=3 and --tries=3 options. These options specify that the queue worker should sleep for 3 seconds between each job and should retry failed jobs up to 3 times before marking them as failed.

Install:
This section specifies the run levels at which the service should be enabled. The WantedBy parameter specifies that the service should be enabled in the multi-user target, which is the default target for most Linux distributions.
Save the file and exit the editor.


### Enabling the Service

First execute the following command to reload systemd daemon service. You need to run this command everytime, you make any changes in service file.

$ sudo systemctl daemon-reload
To ensure that the Laravel queue worker starts automatically when the server boots up, we can enable the service using the following command:

$ sudo systemctl enable laravel-worker

This command will create a symlink in the appropriate directory to start the service automatically on boot.


### Starting the Service
Now that we’ve created and activated the Systemd service file, we can start the service using the following command:

$ sudo systemctl start laravel-worker
This command will start the Laravel queue worker as a Systemd service. You can verify that the service is running correctly by checking its status:

$ sudo systemctl status laravel-worker
This command will display information about the service, including its current status and any recent log entries.


### Controlling the Service
Once the service is running, you can control it using the standard Systemd commands. Here are some common commands you can use to control the Laravel queue worker service:

- sudo systemctl stop laravel-worker: This command will stop the service.
- sudo systemctl restart laravel-worker: This command will restart the service.
- sudo systemctl disable laravel-worker: This command will disable the service from starting automatically on boot.
- sudo systemctl status laravel-worker: This command will display the status of the service, including whether it’s running or stopped, and any recent log entries.


### Conclusion
Running Laravel queue workers with Systemd is a great way to ensure that your background jobs are always running smoothly and efficiently in production environments. By creating a Systemd service file and enabling it on boot, you can automate the process of starting and stopping the queue worker, making it easy to manage and control.

In this article, we’ve covered the basic steps for creating a Systemd service file for the Laravel queue worker, starting the service, enabling it on boot, and controlling it using Systemd commands. With this knowledge, you can confidently manage and scale your Laravel applications with ease.
