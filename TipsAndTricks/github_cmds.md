### github: server certificate verification failed

# 1.
sudo apt-get install --reinstall ca-certificates
sudo mkdir /usr/local/share/ca-certificates/cacert.org
sudo wget -P /usr/local/share/ca-certificates/cacert.org http://www.cacert.org/certs/root.crt http://www.cacert.org/certs/class3.crt
sudo update-ca-certificates
# -->
Make sure your git does reference those CA:
git config --global http.sslCAinfo /etc/ssl/certs/ca-certificates.crt


### github:copie


git clone https://github.com/repertory/content-source-control-git.git .


### How do I push a new local branch to a remote Git repository and track it too?


Simply put, to create a new local branch, do:

git branch <branch-name>

To push it to the remote repository, do:

git push -u origin <branch-name>


### display branch

git branch

### switch between another branch
git checkout <other branch>
