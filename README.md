# backuper

A small backup script which backs up a given database and pushes the `.sql` file to Amazon S3.
### How to use
backuper is really simple to use, just 5 easy steps to get a fully MySQL Database export to Amazon S3.

1. Create an AWS Account an activate [Amazon S3](http://aws.amazon.com/de/s3/). Be sure to copy your **AWS Access Key** and your **AWS Secret Key**!
2. Upload the script, and the S3 PHP libary to your server. (`backuper.php` and `S3.php`)
3. Make sure PHP has read and write rights in the folder where `backuper.php` is located.
4. Configure the skript to your needs. Please look below for settings and configuration options.
5. Finished!
6. eventually you want to put backuper in your *crontab* or *runwhen* configuration so it gets executed regulary 

### Settings
**DB_USER** = the username for the database connection
**DB_PW** = the password for the database connection
**DB_HOST** = the host of your database, most likely `localhost`
**DB_NAME** = the name of the database which backup should be saved

**AWS_accessKey** = the access key of your Amazon AWS account
**AWS_secretKey** = the secret key of your Amazon AWS account (needed for authorization)
**S3_bucketName** = the name of the buckets where the `.sql` files should be saved

### Configuration options

**$file_name** = sets the default file name for the .sql file which is temporaly saved on the server. *This is not the filename for the real backup file on S3.*

**$sendErrors** = if set to true, backuper will send you an mail to your address specified in `$error_mail`

**$error_mail** = this is the mail adress to which any error messages will be send.

### Naming scheme
Currently only one hardcoded naming scheme is possible.
`YEAR_MONTH_DAY-HOUR:MINUTES:SECONDS_DATABASENAME-RANDOMNUMBER.sql`

Example:
`2014_05_01-20:13:35_appspark-53628ecf3a572.sql`

### License
backuper is released under the MIT License. Please view the license file for futher information.