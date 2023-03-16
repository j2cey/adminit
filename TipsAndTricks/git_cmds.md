### Server certificate verification failed. CAfile: /etc/ssl/certs/ca-certificates.crt CRLfile: none
git config --global http.sslverify "false"

git reset --hard HEAD && git pull

### How do I 'overwrite', rather than 'merge', a branch on another branch in Git?
git checkout old
git merge new
git checkout --theirs .
git add .
git commit