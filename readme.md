## Clipboard

Clipboard allows you to create online surveys. Built with [Laravel](http://laravel.com/)!

## Demo

Comming soon!

## Installation

First, install Clipboard from github:

    $ git clone https://github.com/bicknoyle/Clipboard.git
    $ cd Clipboard
    $ composer install

Next, you'll need do some configuration set-up. Start by copying over `.env.example`:

	$ cp .env.example .env

And update it for your environment. You'll probably just need to update the database settings:

	DB_HOST=localhost
	DB_DATABASE=clipboard
	DB_USERNAME=dbuser
	DB_PASSWORD=mysekkritpass

Next, generate a unique APP_KEY (used by Laravel for encrypting cookies and things):

	$ php artisan key:generate

Finally, run the database migrations:

    $ php artisan migrate // append --seed option to load demo surveys

You're done!

## License

Clipboard is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
