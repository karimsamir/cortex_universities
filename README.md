# Cortex Universities (Laravel Integration for rinvex/universities)

Cortex Universities is a Laravel package that integrates the [rinvex/universities](https://github.com/rinvex/universities) dataset into a relational database. It provides a clean separation between the raw dataset and the Laravel application layer.

## Features

- **Database Migration**: Ready-to-use migration for universities table
- **Data Seeder**: Automatic import of university data from JSON files
- **Eloquent Model**: Feature-rich University model with useful scopes
- **Publishable Assets**: Configurable and customizable for Laravel applications
- **Clean Architecture**: Proper separation between dataset and Laravel layer

## Requirements

- PHP 8.3+
- Laravel 11+
- rinvex/universities package

## Installation

### 1. Install the Package

```bash
composer require karimsamir/cortex_universities
```

### 2. Publish the Assets

```bash

# Publish migrations
php artisan vendor:publish --tag="cortex-universities-migrations"

# Publish seeders (optional - if you want to customize)
php artisan vendor:publish --tag="cortex-universities-seeders"

# Publish models (optional - if you want to customize)
php artisan vendor:publish --tag="cortex-universities-models"

# Or publish all at once
php artisan vendor:publish --tag="cortex-universities"
```

### 3. Run the Migration

```bash
php artisan migrate
```

### 4. Import University Data

```bash
php artisan db:seed --class="Cortex\\Universities\\Database\\Seeders\\UniversitiesSeeder"
```

## Configuration

After publishing the config file, you can customize the package behavior in `config/config.php`:

```php
return [
    'table_name' => 'universities',
    'data_path' => env('UNIVERSITIES_DATA_PATH', null),
    'auto_import' => env('UNIVERSITIES_AUTO_IMPORT', false),
    'cache_duration' => env('UNIVERSITIES_CACHE_DURATION', 3600),
    'per_page' => env('UNIVERSITIES_PER_PAGE', 25),
    // ... other options
];
```

## Usage

### Basic Queries

```php
use Cortex\UniversitiesModule\Models\University;

// Get all universities
$universities = University::all();

// Get paginated universities
$universities = University::paginate(25);

// Find a university by ID
$university = University::find(1);
```

### Using Scopes

```php
// Get universities from a specific country
$usUniversities = University::fromCountry('United States')->get();

// Get universities from a specific state
$californiaUniversities = University::fromState('California')->get();

// Get universities with specific funding type
$publicUniversities = University::withFunding('Public')->get();
```

### Advanced Queries

```php
// Search universities by name
$searchResults = University::where('name', 'LIKE', '%Harvard%')->get();

// Get universities with website
$universitiesWithWebsite = University::whereNotNull('website')->get();

// Order by name
$universities = University::orderBy('name')->get();
```

### Accessing University Properties

```php
$university = University::first();

echo $university->name;
echo $university->country;
echo $university->website;

// Get full address
echo $university->full_address; // "Massachusetts Hall, Cambridge, Massachusetts, 02138"
```

## Available Fields

The University model provides the following fields:

- `name` - University name
- `alt_name` - Alternative name
- `country` - Country name
- `state` - State/province
- `street` - Street address
- `city` - City
- `province` - Province
- `postal_code` - Postal/ZIP code
- `telephone` - Phone number
- `website` - Website URL
- `email` - Email address
- `fax` - Fax number
- `funding` - Funding type (Public/Private)
- `languages` - Languages (JSON array)
- `academic_year` - Academic year information
- `accrediting_agency` - Accrediting agency

## Data Source

This package uses data from the [rinvex/universities](https://github.com/rinvex/universities) package, which contains information about over 17,000 universities worldwide. The data includes comprehensive details such as contact information, addresses, and accreditation details.

## Customization

### Custom Table Name

You can change the table name in the configuration file:

```php
'table_name' => 'my_universities',
```

### Adding Custom Methods

You can extend the University model by creating your own model that extends it:

```php
use Cortex\UniversitiesModule\Models\University as BaseUniversity;

class University extends BaseUniversity
{
    public function scopeActive($query)
    {
        return $query->whereNotNull('website');
    }
}
```

## Performance Considerations

- The package includes database indexes on commonly queried fields (country, state, funding, name)
- Consider implementing caching for frequently accessed university data
- Use pagination when displaying large lists of universities

## Troubleshooting

### Seeder Issues

If the seeder can't find the universities data:

1. Ensure the rinvex/universities package is installed
2. Check that the data files exist in the expected location
3. Verify file permissions

### Migration Issues

If you encounter migration conflicts:

1. Check if the table already exists
2. Consider using a custom table name in the configuration
3. Rollback and re-run migrations if needed

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

This package is open-sourced software licensed under the [MIT license](LICENSE).

## Credits

- [rinvex/universities](https://github.com/rinvex/universities) for the comprehensive university dataset
- The Laravel community for inspiration and best practices

## Support

If you encounter any issues or have questions, please file an issue on the [GitHub repository](https://github.com/karimsamir/cortex-universities/issues).
