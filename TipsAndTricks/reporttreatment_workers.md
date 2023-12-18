sudo systemctl start adminit-downloadfiles-worker.service && \
sudo systemctl start adminit-downloadfiles-worker2.service && \
sudo systemctl start adminit-downloadfiles-worker3.service && \
sudo systemctl start adminit-downloadfiles-worker4.service && \
sudo systemctl start adminit-downloadfiles-worker5.service

sudo systemctl status adminit-downloadfiles-worker.service && \
sudo systemctl status adminit-downloadfiles-worker2.service && \
sudo systemctl status adminit-downloadfiles-worker3.service && \
sudo systemctl status adminit-downloadfiles-worker4.service && \
sudo systemctl status adminit-downloadfiles-worker5.service

sudo systemctl restart adminit-downloadfiles-worker.service && \
sudo systemctl restart adminit-downloadfiles-worker2.service && \
sudo systemctl restart adminit-downloadfiles-worker3.service && \
sudo systemctl restart adminit-downloadfiles-worker4.service && \
sudo systemctl restart adminit-downloadfiles-worker5.service



sudo systemctl start adminit-importlines-worker.service && \
sudo systemctl start adminit-importlines-worker2.service && \
sudo systemctl start adminit-importlines-worker3.service && \
sudo systemctl start adminit-importlines-worker4.service && \
sudo systemctl start adminit-importlines-worker5.service

sudo systemctl status adminit-importlines-worker.service && \
sudo systemctl status adminit-importlines-worker2.service && \
sudo systemctl status adminit-importlines-worker3.service && \
sudo systemctl status adminit-importlines-worker4.service && \
sudo systemctl status adminit-importlines-worker5.service

sudo systemctl restart adminit-importlines-worker.service && \
sudo systemctl restart adminit-importlines-worker2.service && \
sudo systemctl restart adminit-importlines-worker3.service && \
sudo systemctl restart adminit-importlines-worker4.service && \
sudo systemctl restart adminit-importlines-worker5.service



sudo systemctl start adminit-importvalues-worker.service && \
sudo systemctl start adminit-importvalues-worker2.service && \
sudo systemctl start adminit-importvalues-worker3.service && \
sudo systemctl start adminit-importvalues-worker4.service && \
sudo systemctl start adminit-importvalues-worker5.service

sudo systemctl status adminit-importvalues-worker.service && \
sudo systemctl status adminit-importvalues-worker2.service && \
sudo systemctl status adminit-importvalues-worker3.service && \
sudo systemctl status adminit-importvalues-worker4.service && \
sudo systemctl status adminit-importvalues-worker5.service

sudo systemctl restart adminit-importvalues-worker.service && \
sudo systemctl restart adminit-importvalues-worker2.service && \
sudo systemctl restart adminit-importvalues-worker3.service && \
sudo systemctl restart adminit-importvalues-worker4.service && \
sudo systemctl restart adminit-importvalues-worker5.service



sudo systemctl start adminit-formatvalues-worker.service && \
sudo systemctl start adminit-formatvalues-worker2.service && \
sudo systemctl start adminit-formatvalues-worker3.service && \
sudo systemctl start adminit-formatvalues-worker4.service && \
sudo systemctl start adminit-formatvalues-worker5.service

sudo systemctl status adminit-formatvalues-worker.service && \
sudo systemctl status adminit-formatvalues-worker2.service && \
sudo systemctl status adminit-formatvalues-worker3.service && \
sudo systemctl status adminit-formatvalues-worker4.service && \
sudo systemctl status adminit-formatvalues-worker5.service

sudo systemctl restart adminit-formatvalues-worker.service && \
sudo systemctl restart adminit-formatvalues-worker2.service && \
sudo systemctl restart adminit-formatvalues-worker3.service && \
sudo systemctl restart adminit-formatvalues-worker4.service && \
sudo systemctl restart adminit-formatvalues-worker5.service

sudo systemctl restart adminit-notifyfiles-worker.service && sudo systemctl restart adminit-notifyfiles-worker2.service && sudo systemctl restart adminit-notifyfiles-worker3.service

sudo systemctl start adminit-listeners-worker.service && \
sudo systemctl start adminit-listeners-worker2.service && \
sudo systemctl start adminit-listeners-worker3.service && \
sudo systemctl start adminit-listeners-worker4.service && \
sudo systemctl start adminit-listeners-worker5.service

sudo systemctl status adminit-listeners-worker.service && \
sudo systemctl status adminit-listeners-worker2.service && \
sudo systemctl status adminit-listeners-worker3.service && \
sudo systemctl status adminit-listeners-worker4.service && \
sudo systemctl status adminit-listeners-worker5.service

sudo systemctl restart adminit-listeners-worker.service && \
sudo systemctl restart adminit-listeners-worker2.service && \
sudo systemctl restart adminit-listeners-worker3.service && \
sudo systemctl restart adminit-listeners-worker4.service && \
sudo systemctl restart adminit-listeners-worker5.service


sudo systemctl restart adminit-downloadfiles-worker.target && \
sudo systemctl restart adminit-formatvalues-worker.target && \
sudo systemctl restart adminit-importlines-worker.target && \
sudo systemctl restart adminit-importvalues-worker.target && \
sudo systemctl restart adminit-listeners-worker.target && \
sudo systemctl restart adminit-notifyfiles-worker.target

