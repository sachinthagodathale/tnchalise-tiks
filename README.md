# TIKS Assure audit

Ledger backups every in a while

- Auto logs all model classes
- Make new model as recordable
- Archive ledgers and daily sync

## Installation

1. Install `Accountant` & `Eventaully`

    - `composer require altek/accountant:1.*`
    - `composer require altek/eventually:1.*`

2. Edit the `config/app.php` to add following:

   ```
   'providers' => [
        Altek\Accountant\AccountantServiceProvider::class,
   ],
   ```

3. Publish Altek

    - `php artisan vendor:publish --tag="accountant-configuration"`
    - `php artisan vendor:publish --tag="accountant-migrations"`

4. Install Tiks-Audit

    - `composer require tnchalise/tiks-audit`

5. Edit the `config/app.php` to add following:

   ```
   'providers' => [
        Tiks\Audit\ServiceProvider::class,
   ],
   ```

6. Publish Tiks-Audit

    - `php artisan vendor:publish --provider="Tiks\Audit\ServiceProvider::class "`

7. Adjust `.env` to have following

   ```
   DB_AUDIT_HOST=****
   DB_AUDIT_DATABASE=****
   DB_AUDIT_USERNAME=****
   DB_AUDIT_PASSWORD=****
   AUDIT_ARCHIVE_INTERVAL=3 # Months
   ```

8. Run Migrations

9. Repalce existing model to extend RecordableModel **(optional)**
    - `sh sh/make-model-recordable.sh` from root directory, if necessary adjust path in `sh/make-model-recordable.sh`

## Usage

### Create a new recordable model

- `php artisan make:recordable-model <name>`

### Schedule ledger archive

- `$schedule->command('php artisan archive:ledgers')->dailyAtMidNight()`
