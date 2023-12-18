## Linux – Systemd with multiple execStart
if Type=simple in your unit file, you can only specify one ExecStart, but you can add as many ExecStartPre, ExecStartPost, but none of this is suited for long running commands, because they are executed serially and everything one start is killed before starting the next one.
If Type=oneshot you can specify multiple ExecStart, they run serially not in parallel.
If what you want is to run multiple units in parallel, there a few things you can do:

### If they differ on 1 param
You can use template units, so you create a /etc/systemd/system/foo@.service. NOTE: (the @ is important).
```shell
[Unit]
Description=script description %I

[Service]
Type=simple
ExecStart=/script.py %i
Restart=on-failure

[Install]
WantedBy=multi-user.target
```
And then you exec:
```shell
$ systemctl start foo@parameter1.service foo@parameter2.service
```
or...

### Target dependencies
You can create multiple units that links to a single target:
```shell
#/etc/systemd/system/bar.target
[Unit]
Description=bar target
Requires=multi-user.target
After=multi-user.target
AllowIsolate=yes
```
And then you just modify you .service units to be WantedBy=bar.target like:
```shell
#/etc/systemd/system/foo@.service
[Unit]
Description=script description %I

[Service]
Type=simple
ExecStart=/script.py %i
Restart=on-failure

[Install]
WantedBy=bar.target
```
Then you just enable the foo services you want in parallel, and start the bar target like this:
```shell
$ systemctl daemon-reload
$ systemctl enable foo@param1.service
$ systemctl enable foo@param2.service
$ systemctl start bar.target
```
NOTE: that this works with any type of units not only template units.
