### WATER MANAGENT SYSTEM (Water Ms)
To run this project you need to have the following
``` 
    1. Xampp installed 
    2. databse server installed (Mysql)
    3. Import /db/water_ms.sql sql file in the water_ms database
    4. Test credentials : email:admin@gmail.com, password : 123
    5. in the app_settings.php 
```

```php
    class AppSettings
    {
        // app name, main link properties 
        public static $app_name = "Water Ms";
        public static $app_link = "http://localhost/water_ms";
        // db properties
        public static $db_host = "localhost";
        public static $db_name = "water_ms";
        public static $db_user = "root";
        public static $db_pass = "";
```
    6. set the above required parameters as required
    7. Run the app_link in browser 
    8. you are set