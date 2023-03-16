
### How to export a Vagrant virtual machine to transfer it

# 1. Copy the ssh key from ~/.vagrant.d/insecure_private_key and append it to the same file on the other machine. This is necessary to be able to log into the VM later.
# 2. Check the VM name: 
VBoxManage list vms

# 3. Package the vagrant VM: 
vagrant package --base vm-name --output /path/to/mybox.box

# 4. Copy the *.box file and the Vagrantfile to the other machine
# 5. add the box as new one
vagrant box add new-box-name mybox.box

# initialize the new box
vagrant init new-box-name

# 5. Run the VM: 
vagrant up

# Note: The VM will be restarted during this process. You'll loose anything ephemeral!



### How do I associate a Vagrant project directory with an existing VirtualBox VM?

# 1) In the directory where your Vagrantfile is located, run the command
VBoxManage list vms

# You will have something like this:
"virtualMachine" {xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx}

# 2) Go to the following path:
cd .vagrant/machines/default/virtualbox

# 3) Create a file called id with the ID of your VM xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx

# 4) Save the file and run vagrant up

