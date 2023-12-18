###
MySQL Failed! Error: SET PASSWORD has no significance for user ‘root’@’localhost’ as the authentication method used doesn’t store authentication data in the MySQL server. Please consider using ALTER USER
###
1.	Open the terminal application.
2.	Terminate the mysql_secure_installation from another terminal using the killall command:
	sudo killall -9 mysql_secure_installation
3.	Start the mysql client:
	sudo mysql
4.	Run the following SQL query:
	ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY 'SetRootPasswordHere';
	exit
5.	Then run the following command to secure it:
	sudo mysql_secure_installation
6.	When promoted for the password enter the SetRootPasswordHere (or whatever you set when you ran the above SQL query)
	That is all.

### Adjust wait_timeout MySQL
1. Open MySQL.

sudo service mysql start

 
2. Open the command window.

sudo mysql -u username -p

 
3. Change the timeout.

SET @@GLOBAL.interactive_timeout=31536000

 
4. Restart server.

sudo service mysql restart

 
The windows timeout default is 31536000. You can choose the time you prefer.  The way to follow the timeout is show global variables like 'wait_timeout'.