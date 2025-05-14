# PDF Systems Backup SDK

[![Tests](https://img.shields.io/github/actions/workflow/status/pdfsystems/backup-sdk/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/pdfsystems/backup-sdk/actions/workflows/run-tests.yml)

## Installation

You can install the package via composer, but first you need to add PDF's composer repository to your composer.json file:

```json
{
    "repositories": [
        {
            "type": "composer",
            "url": "https://composer.pdfsystems.com"
        }
    ]
}
```

You can install the package via composer:

```bash
composer require pdfsystems/backup-sdk
```

## Usage

### Creating a Client

```php
$client = new \Pdfsystems\BackupSdk\BackupClient('{Auth Token}');
```

### Applications

#### List Applications

```php
$client = new \Pdfsystems\BackupSdk\BackupClient('{Auth Token}');
$client->applications()->list();
```

#### Load Application

```php
$client = new \Pdfsystems\BackupSdk\BackupClient('{Auth Token}');
$client->applications()->find(1);
```

#### Create Application

```php
$client = new \Pdfsystems\BackupSdk\BackupClient('{Auth Token}');
$client->applications()->create(
    new \Pdfsystems\BackupSdk\Dtos\Application([
        'name' => 'My Application',
    ])
);
```

#### Update Application

```php
$client = new \Pdfsystems\BackupSdk\BackupClient('{Auth Token}');
$application = $client->applications()->find(1);
$application->name = 'My Updated Application';
$client->applications()->update($application);
```

### Backups

#### List Backups

```php
$client = new \Pdfsystems\BackupSdk\BackupClient('{Auth Token}');
$client->backups()->list(); // All backups
$client->backups()->list(1); // Backups for a specific application
$client->backups()->list(1, 'database'); // Backups for a specific application + type
```

#### Load Backup

```php
$client = new \Pdfsystems\BackupSdk\BackupClient('{Auth Token}');
$client->backups()->find(1);
```

#### Create Backup

```php
$client = new \Pdfsystems\BackupSdk\BackupClient('{Auth Token}');
$file = new SplFileInfo('/path/to/file.ext');
$client->backups()->create(
    1,
    $file,
    [
        'field1' =>  'value1',
        'field2' =>  'value2',
    ],
    'database'
);
```

#### Update Backup

```php
$client = new \Pdfsystems\BackupSdk\BackupClient('{Auth Token}');
$backup = $client->backups()->find(1);
$backup->name = 'My Updated Backup';
$client->backups()->update($backup);
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/spatie/.github/blob/main/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Rob Pungello](https://github.com/pdfsystems)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
