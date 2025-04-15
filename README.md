 git clone -b master  https://github.com/vaishalijadhav2418/Sanjeevani-Hospital.git

 apt-get update

 apt install apache2 -y

 sudo apt install php -y

 cp -r Sanjeevani-Hospital/ /var/www/html/
 
 mysql -u admin -h database1.clyiog0o8d75.ap-south-1.rds.amazonaws.com -p 
 -- next create database, tables also as per database file
 
 systemctl restart apache2
  
 sudo apt-get install php-mysql -y      ----> install php my sql driver
 
 -- modify the connect files
 
