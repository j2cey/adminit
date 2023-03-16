### install npm on ubuntu
sudo apt install nodejs npm

### 
npm install --legacy-peer-deps
npm install --no-bin-links

### NPM self_signed_cert_in_chain
npm config set registry="http://registry.npmjs.org/"
npm config set strict-ssl false

### How to fix npm err code EINTEGRITY issue
# 👇 remove node_modules and package-lock.json
rm -rf node_modules package-lock.json

# 👇 Clear and verify npm cache
npm cache clean --force
npm cache verify
npm update

# 👇 now run npm install again
npm install