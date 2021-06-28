# TIKS Assure audit

Ledger backups every in a while

- Auto logs all model classes
- Make new model as recordable
- Archive ledgers and daily sync

## Installation

1. Install Tiks-Audit

   - `composer require tnchalise/tiks`

2. Edit the `config/app.php` to add following:

   ```
   'providers' => [
        Altek\Accountant\AccountantServiceProvider::class,
        Tiks\Audit\ServiceProvider::class,
   ],
   ```

3. Publish Tiks-Audit

   - `php artisan vendor:publish --tag="accountant-configuration"`
   - `php artisan vendor:publish --tag="accountant-migrations"`
   - `php artisan vendor:publish --provider="Tnchalise\Tiks\ServiceProvider"`

4. Adjust `.env` to have following

   ```
   DB_AUDIT_HOST=****
   DB_AUDIT_DATABASE=****
   DB_AUDIT_USERNAME=****
   DB_AUDIT_PASSWORD=****
   AUDIT_ARCHIVE_INTERVAL=3 # Months
   ```

5. Set up secondary DB connection named `audit` in `config/databas.php`

   ```
    'audit' => [
            'driver'      => 'mysql',
            'host'        => env('DB_AUDIT_HOST', '127.0.0.1'),
            'port'        => env('DB_AUDIT_PORT', '3306'),
            'database'    => env('DB_AUDIT_DATABASE', 'forge'),
            'username'    => env('DB_AUDIT_USERNAME', 'forge'),
            'password'    => env('DB_AUDIT_PASSWORD', ''),
            'unix_socket' => env('DB_AUDIT_SOCKET', ''),
            'charset'     => 'utf8',
            'collation'   => 'utf8_unicode_ci',
            'prefix'      => '',
            'strict'      => false,
            'engine'      => null,
        ],
   ```

6. Run Migrations

7. Repalce existing model to extend RecordableModel **(optional)**
   - `sh sh/make-model-recordable.sh` from root directory, if necessary adjust path in `sh/make-model-recordable.sh`

## Usage

### Create a new recordable model

- `php artisan make:recordable-model <name>`

### Schedule ledger archive

- `$schedule->command('php artisan archive:ledgers')->dailyAtMidNight()`
