# Website for NicoleSippolaMassage.com
Authored by [Shane Smith](https://github.com/voodooGQ) 

## Setup

1. From the repository root: `cp public/wp-config.dist.php public/wp-config.php`
1. `cd build`
1. `npm install` - This may take a few minutes to process... go grab a coffee
1. `gulp install` - Will install bower dependencies
1. `gulp` - Run an initial build
1. `gulp watch` - (Optional) if you want to keep the build task running
1. `cd ../vagrant`
1. `vagrant up` - This may take a few minutes to process... drink some of that coffee you grabbed earlier
1. `vagrant ssh`
1. Following commands are from the vagrant ssh root: `cd /var/www`
1. `composer install`
1. Visit `syntaxalert.dev` in your browser
