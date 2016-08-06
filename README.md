# platoon-se

Source code for [http://platoon.se/]() core module.


## Install

To contribute to the project do you need to have [node][], [bower](http://bower.io/) and [composer][] installed.

First install [node][] using the installer from [https://nodejs.org/][node] which comes with the "node package manager" ([npm](https://www.npmjs.com/)) then install bower running the command below in a terminal:

    # might need sudo
    $ npm install -g bower

When you've installed [composer][] from [https://getcomposer.org/][composer] install all development dependecies by runnig the command below from the project folder, ie. the cloned git repo.

    $ npm install && bower install && composer install

## Environment and configuration

To have the correct environment when developming make sure to copy and configurate the environment variables

    $ cp .env.dist .env

## Gulp

To facilitate develpoment do we use the [gulp][] automate tool. Install it globally on your machine for it to run.

    # might need sudo
    $ npm install -g gulp

### Tasks

Gulp task are then run from the project folder using `gulp [task]`

    app     Concat and generate angular applicaiton
    connect Starts a simple php testserver
    deploy  Deploy project to server using ftp
    reload  Start a development server that watches for and reloads
            resources on changes
    sass    Generate css files from sass source
    watch   Watch for and update .scss and .js changes

[gulp]: http://gulpjs.com/
[node]: https://nodejs.org/
[composer]: https://getcomposer.org/
