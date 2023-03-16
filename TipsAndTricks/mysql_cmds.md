### root pwd
Libertis@123

### example database

## user login
example_user

## user pwd
P@ssw@rd4Example

###create superuser 
CREATE USER 'rootdev'@'%' IDENTIFIED WITH mysql_native_password BY 'RootdevP@ssw0rd';
GRANT ALL PRIVILEGES ON *.* TO 'rootdev'@'%' WITH GRANT OPTION; FLUSH PRIVILEGES; 