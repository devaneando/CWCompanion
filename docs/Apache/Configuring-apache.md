# Configuring Apache

After you have Apache installed in your machine, enable the required mods:

```bash
sudo a2enmod ssl rewrite
```

For a development environment, edit the `/etc/apache2/envvars` and change(or add) the lines below:

```bash
# Since there is no sane way to get the parsed apache2 config in scripts, some
# settings are defined via environment variables and then used in apache2ctl,
# /etc/init.d/apache2, /etc/logrotate.d/apache2, etc.
export APACHE_RUN_USER=your_user
export APACHE_RUN_GROUP=your_user
# Only /var/log/apache2 is handled by /etc/logrotate.d/apache2.
export APACHE_LOG_DIR=/var/log/apache2$SUFFIX
export CWC_HOME=/path/to/%kernel.project_dir%
```

Add the line below to your `/etc/hosts` file:

```bash
127.0.0.1    cwc.local www.cwc.local
```

Copy the configuration files to the `sites-available`folder and enable it:

```bash
sudo cp %kernel.project_dir%/Apache/apache.conf /etc/apache2/sites-available/cwc.conf
sudo service apache2 restart
```

Your are done!
