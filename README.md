<p align="center"><a href="https://www.qr-code-generator.com/" target="_blank"><img src="https://cdn-web.qr-code-generator.com/wp-content/themes/qr/new_structure/assets/media/images/logos/egoditor/logo-icon-blue.svg" width="100"></a></p>

## Egoditor - Updater - Afolabi Abass

## Egoditor
Egoditor was founded in 2009 by Nils Drescher and Nils Engelking. They both saw the true potential of QR Codes when it was still under the radar. But when the impact on mobile marketing became obvious, QR-Code-Generator.com was already miles ahead

## Instructions

- Git clone this repository or download this application folder which ever is relevant
- From terminal set current working directory to the application folder
```
cd egoditor-updater
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
php artisan dpip:update
```

- Finally, to set up the scheduler on the server run the command below
```
crontab -e
```
This will open the server's Crontab file. The code below can be pasted into the file then save and exit.
```
* * * * * cd /path-to/egoditor-updater && php artisan schedule:run >> /dev/null 2>&1
```

## Authors

- Afolabi Abass [afolabi.abass@hotmail.co.uk](mailto://afolabi.abass@hotmail.co.uk).


