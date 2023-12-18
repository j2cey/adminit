## How to truncate file on Linux
```shell
$ truncate -s 0 file.txt
```
## How to install PHP GD in Ubuntu
sudo apt-get install php8.2-gd

## See all running services on a Linux system with systemd. 
It provides details like name, load, sub-state, and description. 
Systemd is a system and service manager in Linux that launches services.
```shell
systemctl --type=service --state=running
```
