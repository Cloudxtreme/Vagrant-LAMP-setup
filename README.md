Simple Vagrant LAMP setup
=========================

This is a simple server setup in Vagrant. At the moment there are three servers 
used, one as a webserver, a MySQL-server and a media-server. The files are mostly
meant as an example on how to use Vagrant and get started quickly.

After figuring out how awesome Vagrant is. I noticed it makes testing services 
and new configurations a breeze. This setup was used to try a Memcached service.

For the ones just getting started, read the "Getting started" section from
the Vagrant Docs first: http://docs.vagrantup.com/v2/getting-started/index.html

I. Webserver
------------

The webserver is prepared to run Apache with PHP. It'll automatically install a
VirtualHost and enable it. For the heck of it, Memcached is also installed on the
server and running as a daemon there.

To get things started, there are some simple PHP-scripts running. 
There is an autoloader enabled, so you can use namespaces.
There is also a Database-class, which runs normal queries and one which
can cache queries.
Finally there is also a Timer-class written, so you can time the responses.

The other classes can be ignored for now, since they were early attempts
of abstraction.

II. MySQL server
----------------

This is a simple MySQL server which will accept incoming requests from
the webserver. At the moment I've used a data-generator to create some
sample data. This will give you some data to try the setup with.

The data is automically imported, so all you have to do is just query it.

You can use the server with the credentials below:
- Server => 192.168.5.2
- User => vagrant_web
- Password => connect
- Databasename => vagrant_db

III. Media server
-----------------

This one just installs nginx. Setup as you want. 

Note: This setup is quickly made and not meant for actual deployment. 
