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