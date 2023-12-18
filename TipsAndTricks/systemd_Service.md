# Passing Multiple Parameters to a systemd Service
## 1. Overview
systemd is the modern system and service manager in Linux that aims to replace the old SysVinit initialization process. It uses the systemctl command to manage the services. The service configurations are kept in text files called unit files.
In this tutorial, we’ll discuss how to pass multiple parameters to a service managed by systemd.

## 2. Example Script and Unit File
We’ll try to execute the following script, example.sh, using systemd:
```shell
#!/bin/bash

echo $1 $2 $3
```
This script just prints the three arguments passed to it using the echo command:
```shell
$ pwd
/home/alice
$ ./example.sh alice bob carol
alice bob carol
```
We’ll use the following unit file, example.service or its modified versions in our examples to execute example.sh as a system service:
```shell
[Unit]
Description = An example of executing a script as a system service

[Service]
Type = oneshot
User = alice
ExecStart = /home/alice/example.sh alice bob carol
StandardOutput = file:/tmp/service.log

[Install]
WantedBy = default.target
```
The unit file example.service is in the /etc/systemd/system directory. systemd uses this directory for loading unit files.
Unit files consist of several sections. [Unit], [Service], and [Install] in our example unit file show the beginning of three different sections. Each section consists of several directives. These directives are specified in a key-value format. For example, Type = oneshot in our unit file specifies the directive Type whose value is oneshot.
The directives of interest to us are ExecStart and StandardOutput. **ExecStart specifies the full path of a command that will be executed to start a service.**
Normally, the service output is directed to the journald component of systemd. We can check the output using the journalctl command. But, as there may be many services running and logging, the output of journalctl may be messy. So, we’ll use the StandardOutput directive to redirect the output of our script to the file /tmp/service.log.

## 3. Using the ExecStart Directive
As we’ve already mentioned, ExecStart specifies the full path of the command that starts the service. In addition to the command, we can specify the parameters that we want to pass to the command in the same ExecStart directive as if we run the command in a terminal. In our example, we’ll run the script /home/alice/example.sh and pass the parameters alice bob carol to it. So, the value of the ExecStart directive is /home/alice/example.sh alice bob carol.

Now, let’s start our service. First, we’ll load the service using systemctl daemon-reload:
```shell
$ cd /etc/systemd/system
$ systemctl daemon-reload
```
Now, we can enable and start the service:
```shell
$ systemctl enable example
Created symlink /etc/systemd/system/default.target.wants/example.service -> /etc/systemd/service/example.service
$ systemctl start example
```
We had no errors. Let’s check the content of the file /tmp/service.log using the cat command:
```shell
$ cat /tmp/service.log
alice bob carol
```
So, we’re successful in starting a system service and passing parameters it. What’s the problem with this approach? 
**The problem arises if we want to change the parameters passed to the script.** For example, we may want to get them from a user. We don’t want to change the unit file frequently, as modifying it needs root privileges.
**We must also, in general, call the systemctl daemon-reload command if we change a unit file. This, again, needs root privileges.**

We can also define the environment variables using the Environment directive. Then we can pass the defined variables to the script in the ExecStart directive:
```shell
[Unit]
Description = An example of executing a script as a system service with Environment directive

[Service]
Type = oneshot
User = alice
Environment = "PARAMETER1=alice" "PARAMETER2=bob" "PARAMETER3=carol"
ExecStart = /home/alice/example.sh $PARAMETER1 $PARAMETER2 $PARAMETER3
StandardOutput = file:/tmp/service.log

[Install]
WantedBy = default.target
```
But, this approach has the same limitations as passing the parameters directly in the ExecStart directive because we need to modify the unit file.

## 4. Using the EnvironmentFile Directive
We can use the EnvironmentFile directive for passing multiple parameters to a system service. It’s similar to the Environment directive, but it reads the environment variables from a text file.
We’ll use the following unit file, example_environment_file.service:
```shell
[Unit]
Description = An example of executing a script as a system service with EnvironmentFile directive

[Service]
Type = oneshot
User = alice
EnvironmentFile = /home/alice/env_file
ExecStart = /home/alice/example.sh $PARAMETER1 $PARAMETER2 $PARAMETER3
StandardOutput = file:/tmp/service.log

[Install]
WantedBy = default.target
```
The unit file is in the */etc/systemd/system* directory as before.

**The most basic difference between this unit file from the previous one is the EnvironmentFile directive. This directive specifies the path of a file which contains a list of variables. These variables are the ones that will be passed to the system service.**

We specified the file as /home/alice/env_file in the unit file. Let’s check the content of this file using cat:
```shell
$ cat /home/alice/env_file
PARAMETER1=alice
PARAMETER2=bob
PARAMETER3=carol
```
The file contains the names of the variables and their corresponding values. For example, PARAMETER1 is the name of the variable, and alice is the value of the variable.

We passed these parameters to the script in the *ExecStart* directive as */home/alice/example.sh $PARAMETER1 $PARAMETER2 $PARAMETER3*.

Now, it’s time to try the new service. We’ll follow the same procedure as before:
```shell
$ rm –f /tmp/service.log
$ cd /etc/systemd/system
$ systemctl daemon-reload
$ systemctl enable example_environment_file
Created symlink /etc/systemd/system/default.target.wants/example_environment_file.service -> /etc/systemd/service/example_environment_file.service
$ systemctl start example_environment_file
```
We didn’t get any errors. Let’s check the contents of the redirected log file:
```shell
$ cat /tmp/service.log
alice bob carol
```
So, we could pass the parameters in */home/alice/env_file* to the script using systemd.

Let’s change the content of this file with an editor like vi as follows and save it:
```shell
$ cat /home/alice/env_file
PARAMETER1=carol
PARAMETER2=alice
PARAMETER3=bob
```
We just changed the order of the values. Now, let’s run the service again and check the content of the log file:
```shell
$ rm –f /tmp/service.log
$ systemctl start example_environment_file
$ cat /tmp/service.log
carol alice bob
```
**So, we changed the parameters passed to the system service simply by editing the environment file. We didn’t have to load and restart the service, which requires root privileges.**

## 5. Using a Template Unit File
Using a template unit file for passing parameters to a service is another option. **A template unit file can be used for starting the same service with a different parameter.**

The template unit file has a name in the format *<service_name>@.service*. **However, while starting the service, we use the unit file name as <service_name>@<parameter>.service. Here, the <parameter> part in the name is the parameter passed to the service.**

There are identifiers in the template unit file which we can use for the parameter. For example, the %I identifier is one of them that corresponds to an un-escaped instance name.

### 5.1. Starting the Service With a Single Parameter
Let’s make the usage of template unit files clear by using the following file, example_template@.service:
```shell
[Unit]
Description = An example of executing a script as a system service using a template unit file

[Service]
Type = oneshot
User = alice
ExecStart = /home/alice/example.sh %I
StandardOutput = file:/tmp/service.log

[Install]
WantedBy = default.target
```
We’ll load the service and enable it in the same way as before:
```shell
$ rm –f /tmp/service.log
$ cd /etc/systemd/system
$ systemctl daemon-reload
$ systemctl enable example_template@
Created symlink /etc/systemd/system/default.target.wants/example_template@.service -> /etc/systemd/service/example_template@.service
```
Now, let’s start the service:
```shell
$ systemctl start example_template@alice
```
There were no errors in the output. We passed alice as the only parameter to the service. We specified it after the service name example_template@. systemd replaced the identifier %I in the template unit file with alice. Hence, it passed alice to our script, example.sh.

Let’s check the content of /tmp/service.log:
```shell
$ cat /tmp/example_service.log
alice
```
Although example.sh expects to take three arguments, we passed only one parameter to it, alice. So, example.sh just printed that parameter. Therefore, the content of service.log was as expected.

### 5.2. Starting the Service With Multiple Parameters
So, now the question is how to pass more than one parameter to a template unit file. We may try to enclose the multiple parameters within double quotes:
```shell
$ rm –f /tmp/service.log
$ systemctl start example_template@"alice bob carol"
Invalid unit name "example_template@alice bob carol" was escaped as "example_template@alice\x20bob\x20carol" (maybe you should use systemd-escape?)
```
We got an error. The error complained about the name of the unit file. But it also proposed a solution by using the systemd-escape command. This command is useful for escaping strings in systemd unit files.

Let’s try systemd-escape with our unit file:
```shell
$ systemd-escape --template example_template@.service "alice bob carol"
example_template@alice\x20bob\x20carol.service
```
The execution of systemd-escape created a unit file name *example_template@alice\x20bob\x20carol.service*. It replaced the spaces in alice bob carol with *0x20* resulting in *alice0x20bob0x20carol*. It also removed the double quotes surrounding the parameters in the unit file name. **The –template option specified the unit file.**

Now, let’s start the service using the unit file name produced by systemd-escape:
```shell
$ rm –f /tmp/service.log
$ systemctl start $(systemd-escape --template example_template@.service "alice bob carol")
```
We didn’t get any errors. We used command substitution for passing the output of systemd-escape to systemctl start. Let’s check the content of the log file:
```shell
$ cat /tmp/example_service.log
alice bob carol
```
Let’s try it once more by changing the order of the parameters:
```shell
$ systemctl start $(systemd-escape --template example_template@.service "carol alice bob")
$ cat /tmp/example_service.log
carol alice bob
```
So, we were successful in passing multiple parameters to a service using a template unit file.

## 6. Conclusion
In this article, we discussed four different methods for passing multiple parameters to a service managed by systemd.

First, we passed the parameters to the service in the *ExecStart* directive. This looks like passing parameters directly to the service in a terminal.

Secondly, we used the Environment directive. We simply listed the parameters as key-value pairs in the Environment directive.

Thirdly, we used the EnvironmentFile directive. This is similar to the Environment directive, but we list the environment variables in a file and pass that file to the directive.

Finally, we used template unit files. We saw that we can specify the parameters in the name of the unit file while starting the service.

The third and fourth methods don’t need the modification of unit files. So, they’re preferable in case of changing the parameters passed to the service.

Comments are closed on this article!
