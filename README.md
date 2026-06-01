# Deployment does in Opalstack

## Step 1: ssh into Opalstack
    ssh yourusername@servername/Ip

## Step 2: Check PHP version
    cd ~
    php -v
    which php -> make sure it is PHP v8.1+ and if you need a specific version opalstack lets you select your preferred one

## Step 3-5: Install composer correctly and verify that it works
    cd ~
    curl -sS https://getcomposer.org/installer | php -> This creates ~/composer.phar and now move it to  your personal bin

    mkdir -p ~/bin
    mv ~/composer.phar ~/bin/composer
    chmod +x ~/bin/composer

    Add ~/bin to your   PATH permanently
    echo 'export PATH="HOME/bin:$PATH"' >> ~/.bashrc
    source ~/.bashrc
    composr -v

## Step 6: Upload your laravel project(Terminal)
    Path: /home/username/
    First create an app in the opalstack dashboard 
    git clone <git repository>

## Step 7: install dependancies
    cd to your project folder
    composer install --no-dev --optimize-autoloader

## Step 8: Set up your .env
    Path: /home/username/projectname
    cp .env.example .env
    nano .env {Note: set and replace the values accordingly}

## Step 9: Generate the app key
    Path: /home/username/projectname
    php artisan key:generate

## Step 10: Set permissions
    Path: /home/username/projectname
    chmod -R 775 storage bootstrap/cache
    chown -R $USER:$USER storage bootstrap/cache

## Step 11: Run Migrations
    php artisan migrate --force
    php artisan migrate:fresh --force ->To wipe and run migrations afresh

## Step 12: Point web root to /public 
    Go to Apps-> your app-> settings and find it then set the root path to /home/youruser/apps/yourappname/public

## Step 13: Verity the .htaccess exists
    path: ~/apps/yourproject/public
    cat ~/apps/yourproject/public/.htaccess

## Step 14: cache everything for production
    /home/youruser/yourproject
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache

## Step 15: Link your domain in opalstack panel
    Domains-> Add/Edit Domain and assign it to your app and if using https enable ssl certificate from the panel too

# Database Seeder
## Step 1: Run the seeder class directly
    Path: /home/username/projectname
    /usr/bin/php83 artisan db:seed --class=AdminSeeder

## Step 2: If it fails user tinker on the server
    /usr/bin/php83 artisan tinker
    then
    \App\Models\User::create([
    'name' => 'Admin',
    'email' => 'admin email address',
    'password' => bcrypt('password'),
    'role' => 'admin',
]);

## Step 3: Check if seeder already ran 
    /usr/bin/php83 artisan tinker --execute="echo \App\Models\User::where('email','admin email')->exists() ? 'EXISTS' : 'NOT FOUND';"

## Step 4: Re-run all seeders
    /usr/bin/php83 artisan db:seed --force


# Making updates and Upgrades
Since we deployed from a git repository

## Step 1: Make changes locally - push to Github
    From vs/ any editor
    git add .
    git commit -m "updates on whatever either views, .env, db {any message}"
    git push origin main

## Step 2: SSH into the server
    ssh username@servername/ip

## Step 3: Pull the latest changes
    cd /home/username/project/
    git pull origin main

## Step 4: Run these based on what you changed
    If PHP -> /usr/bin/php83 ~/bin/composer install --no-dev --optimize-autoloader
    Migrations -> /usr/bin/php83 artisan migrate --force
    Seeders -> /usr/bin/php83 artisan db:seed --force
    .env
        nano .env
### make your edits, then:
        /usr/bin/php83 artisan config:clear
        /usr/bin/php83 artisan config:cache
    Routes
        /usr/bin/php83 artisan route:clear
        /usr/bin/php83 artisan route:cache
    Blade Views
        /usr/bin/php83 artisan view:clear
        /usr/bin/php83 artisan view:cache

# Quickest and safety way (Combined)
        Cd /home/username/projectfolder && \
        git pull origin main && \
        /usr/bin/php83 ~/bin/composer install --no-dev --optimize-autoloader && \
        /usr/bin/php83 artisan migrate --force && \
        /usr/bin/php83 artisan cache:clear && \
        /usr/bin/php83 artisan config:cache && \
        /usr/bin/php83 artisan route:cache && \
        /usr/bin/php83 artisan view:cache