Requirements:
- php v8.4
- node.js v22.14
- npm v10.9.2
- composer

If you have these already, skip to the following steps:

1. Clone down the git respository to the directory of your choosing, using: `git clone https://github.com/dom-elves/atarim-url-encoder.git` when you are inside the directory in your terminal.

2. Run `composer install`. You may be prompted to create the SQLite database, select yes.
3. Run `php artisan migrate` to run the migrations for the project.
4. Run `php artisan key:generate` to generate an application key that enables it to run.
5. Run `php artisan serve` to run the project locally. This starts the development server.
6. Open a new terminal and browse to the project directory. Run `npm install`. This will install dependencies. 
7. Now in the same terminal window, run `npm run watch`. This is a command that I've added to compile the frontend assets, as well as watch for changes in the project. For example, if you were to change some of the CSS, you won't have to run `npm run build` in order to compile it again. 

If you do not have the requirements:

MAC:
1. Start by installing composer globally with these two commands: `curl -sS https://getcomposer.org/installer -o composer-setup.php` followed by 
`sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer`.
2. Now install homebrew with `/bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"`. This is a package manager for MACs.
3. For PHP, run `brew install php`, this should install the latest version.
4. For node.js & npm, `brew install node`. 

Windows:
1. Download composer & follow their instructions: https://getcomposer.org/Composer-Setup.exe
2. Download php & follow their instructions: https://www.php.net/downloads.php
3. Download node.js: https://nodejs.org/. This will install node.js & npm.

Linux:
1. Before performing any commands, be sure to run `sudo apt update`.
2. Three commands to install composer: `sudo apt install curl php-cli php-mbstring git unzip`, `curl -sS https://getcomposer.org/installer -o composer-setup.php`, `sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer`. Verify the installation with `composer --version`. This will set up composer globally. 
3. For php, run `sudo apt install php`. Verify with `php -v`.
4. For node & npm, you'll first need to install nvm (Node Version Manager): `curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.1/install.sh | bash`, followed by `export NVM_DIR="$([ -z "${XDG_CONFIG_HOME-}" ] && printf %s "${HOME}/.nvm" || printf %s "${XDG_CONFIG_HOME}/nvm")" [ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh"`. After this, you can install npm & node: `nvm install node`. Verify the installations with `node -v` and `npm -v`. 


Project notes:

Just going to write a little bit about the task, how I found it, challenges overcome etc. 

- I had some issues with setting up the initial project. The past few months I've been using a windows subsystem for linux (WSL2) on my PC so I can get better at using linux, as for a personal project I'm working on I'm using docker so I can improve on that too. I didn't feel the need to dockerise this task, and this is the only other new repo I've started in WSL2, so there were some teething problems. Though I think when it came down to it, I'd just forgotten to run `npm install`....
- The instructions for each system may not be entirely perfect. For Linux, I already had npm/node/php/composer installed so the instructions above are taken from online/memory, I haven't been able to test that they work. Smae goes for the Windows instructions. The MAC instructions should work, as I've cloned down the repo & got it working on a macbook. The only small caveat is that I totally forgot homebrew existed at first, so I had to do some unneccessary messing around of running commands I didn't fully understand though having set it up again using homebrew, everything should work fine. 
- I've never worked with algorithms, and starting to research them became quite overwhelming, so I figured it was acceptable to actually just save the URL and build a 'decoded' version using the `Str` helper. The email also mentioned keeping the URL in memory, though I haven't really done any work with caching and since time seemed to be limited, I just stuck to what I knew. 
- The frontend isn't perfect/fleshed out fully, though the overall spec was vague. The repo is at a stage where I'd raise a PR asking for a review. Where I previously worked, I'd raise a PR with a version rough version of what it was for, then there'd be a lot of back & forth reviewing, suggestions, asking for help etc.
- I'd never come across Services in Laravel before, so that was interesting to read up on a bit. 
- I thought there was a shorthand way of sending a 422 response with validation. I know you can if you're using the `Validator` class (as per the Laravel docs) but I wanted to use a request class for each operation, hence the bulky `failedValidation()` method in each request class. There must be a way, but I didn't really want to spend any more time on this when it was essentially finished. As previously mentioned, I have it at the point where I'd ask for an initial PR review. 


