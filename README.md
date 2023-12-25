# ES2: CodeIgniter4 Version

A Twitter-like social media app written using CodeIginter4. 
Made as a final project for the web dev class at my university.

Unnecessarily complex because I like pain, and regular CRUD app is just plain boring.

Also see the vanilla PHP version [here](https://github.com/deirn/pbw1-final).


## Running Locally
I used Ubuntu [WSL](https://learn.microsoft.com/en-us/windows/wsl/install) to develop for this one. 
Using XAMPP? Too bad, you need to figure it yourself.

1. Setup the LAMP stack, I used [this tutorial](https://www.digitalocean.com/community/tutorials/how-to-install-linux-apache-mysql-php-lamp-stack-on-ubuntu-20-04).
2. Install Composer.
3. Check for enabled extensions.
   ```bash
   $ ls /etc/php/8.1/cli/conf.d/
   10-mysqlnd.ini   20-exif.ini      20-mysqli.ini      20-sqlite3.ini
   10-opcache.ini   20-ffi.ini       20-pdo_mysql.ini   20-sysvmsg.ini
   10-pdo.ini       20-fileinfo.ini  20-pdo_sqlite.ini  20-sysvsem.ini
   15-xml.ini       20-ftp.ini       20-phar.ini        20-sysvshm.ini
   20-bz2.ini       20-gd.ini        20-posix.ini       20-tokenizer.ini
   20-calendar.ini  20-gettext.ini   20-readline.ini    20-xmlreader.ini
   20-ctype.ini     20-iconv.ini     20-shmop.ini       20-xmlwriter.ini
   20-curl.ini      20-intl.ini      20-simplexml.ini   20-xsl.ini
   20-dom.ini       20-mbstring.ini  20-sockets.ini     20-zip.ini
   ```
4. Copy the `env` file to `.env` and modify it if needed.
5. Create an empty database named the same as in the `.env` file.
6. Run the migration
   ```bash
   composer install
   php spark migrate
   php spark db:seed AllSeeder
   ```
7. Serve
   ```
   php spark serve
   ```


## Optional Dependencies
To ease the pain for developing the client-side JavaScript you can install Node and get some autocomplete.
```
npm install
```


## Used Libraries
- [CodeIgniter4](https://codeigniter.com/)
- [Faker](https://fakerphp.github.io/)
- [Myth:Auth](https://github.com/lonnieezell/myth-auth)
- [Mpdf](https://mpdf.github.io/)
- [JQuery](https://jquery.com/)
- [Bootstrap](https://getbootstrap.com/)
- [Font Awesome](https://fontawesome.com/)