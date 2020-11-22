## Instructions
This will process large CSV data daily whilst displaying command line progress bar from processing jobs

## Instructions

- Git clone this repository or download this application folder which ever is relevant
- From terminal set current working directory to the application folder
```
cd processing-large-csv
```

- Now run the following commands
```
composer install 
cp .env.example .env
php artisan key:generate
php artisan migrate
```

- You can finally do a quick run of the updater using the command below 
```
php artisan update
```

- Finally, to set up the scheduler on the server run the command below
```
crontab -e
```
This will open the server's Crontab file. The code below can be pasted into the file then save and exit.
```
* * * * * cd /path-to/processing-large-csv && php artisan schedule:run >> /dev/null 2>&1
```
## Tests

Run the application test with the command below
```
php artisan test
```

## Authors

- Afolabi Abass [afolabi.abass@hotmail.co.uk](mailto://afolabi.abass@hotmail.co.uk).


