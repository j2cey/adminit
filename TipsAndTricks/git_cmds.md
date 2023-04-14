### Server certificate verification failed. CAfile: /etc/ssl/certs/ca-certificates.crt CRLfile: none
git config --global http.sslverify "false"

git reset --hard HEAD && git pull

### How do I 'overwrite', rather than 'merge', a branch on another branch in Git?
````git
git checkout old
git merge new
git checkout --theirs .
git add .
git commit
````

### How do I pull a missing file back into my branch?
git checkout . -f && git submodule update --checkout -f