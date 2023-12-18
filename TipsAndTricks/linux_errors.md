## fsck exited with status code 4
```shell
fsck /dev/mapper/ubuntu--vg-ubuntu--lv

fsck -fy /dev/sda1 
```

## What are all these "Bug: soft lockup" messages about?
### Situation
In the system log (/var/log/messages or journalctl) a lot of the following messages are printed:
```shell
May 25 07:23:59 XXXXXXX kernel: [13445315.881356] BUG: soft lockup - CPU#16 stuck for 23s! [yyyyyyy:81602]
```
These are followed by various stack traces.  This document tries to explain what the soft lockup messages mean.

### Resolution
Under normal circumstances, these messages may go away if the load decreases.
This 'soft lockup' can happen if the kernel is busy, working on a huge amount of objects which need to be scanned, freed, or allocated, respectively.
The stack traces of those tasks can give a first idea about what the tasks were doing. However, to be able to examine the cause behind the messages, a kernel dump would be needed.

While these messages cannot be disabled entirely, in some situations, increasing the time before these
soft lockups are fired can relax the situation.`

To do so, increase the following sysctl parameter: kernel.watchdog_thresh

Default value for this parameter is 10 and to double the value might be a good start.

e.g.
```shell
server1:~ # echo 20 > /proc/sys/kernel/watchdog_thresh
```
or
```shell
server1:~ # echo "kernel.watchdog_thresh=20" > /etc/sysctl.d/99-watchdog_thresh.conf
server1:~ # sysctl -p  /etc/sysctl.d/99-watchdog_thresh.conf
```
For more information on how to configure and capture kernel dump please check: Configure crashkernel memory for kernel core dump analysis

### Cause
A 'soft lockup' is defined as a bug that causes the kernel to loop in kernel mode for more than 20 seconds without giving other tasks a chance to run.
The watchdog daemon will send an non-maskable interrupt (NMI) to all CPUs in the system who, in turn, print the stack traces of their currently running tasks.
 
