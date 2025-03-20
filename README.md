# Larastrap5 - Laravel Bootstrap 5 Boilerplate

A modern Laravel boilerplate with Bootstrap 5, complete authentication system, and basic CRUD functionalities. Perfect for quickly starting new Laravel projects with a solid foundation.

## Features

- 🔐 Complete Authentication System
  - Login
  - Registration
  - Password Reset
  - User Management
- 🎨 Bootstrap 5 Integration
  - Modern UI Components
  - Responsive Design
  - FontAwesome Icons
- 📊 Dashboard Layout
  - Clean and Modern Interface
  - Sidebar Navigation
  - User Profile
- 💼 Basic CRUD Modules
  - User Management
  - Client Management
  - Project Management
- 🌡️ System Information Page
  - Server Status
  - Application Details
  - Weather Information Integration
- 🔧 Development Tools
  - PHPUnit Testing Setup
  - Factory Definitions
  - Database Migrations

## Requirements

- PHP >= 8.1
- Composer
- MySQL/MariaDB
- Node.js & NPM
- OpenWeatherMap API Key (for weather functionality)

## Installation

1. Clone the repository:
```bash
git clone https://github.com/yourusername/larastrap5.git
cd larastrap5
```

2. Install PHP dependencies:
```bash
composer install
```

3. Install and compile frontend dependencies:
```bash
npm install
npm run dev
```

4. Create environment file:
```bash
cp .env.example .env
```

5. Generate application key:
```bash
php artisan key:generate
```

6. Configure your database in `.env`:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

7. Run migrations:
```bash
php artisan migrate
```

8. (Optional) Seed the database with sample data:
```bash
php artisan db:seed
```

## Configuration

### Weather Information

To enable weather information on the system page:

1. Get an API key from [OpenWeatherMap](https://openweathermap.org/api)
2. Add to your `.env`:
```
OPENWEATHERMAP_API_KEY=your_api_key
WEATHER_CITY=your_city
```

## Testing

Run the test suite:
```bash
php artisan test
```

## Directory Structure

```
├── app/
│   ├── Http/Controllers/    # Application controllers
│   ├── Models/             # Eloquent models
│   └── Services/           # Service classes
├── database/
│   ├── factories/          # Model factories
│   ├── migrations/         # Database migrations
│   └── seeders/           # Database seeders
├── resources/
│   ├── js/                # JavaScript files
│   ├── sass/              # SASS files
│   └── views/             # Blade templates
└── tests/                 # Test files
```

## Key Features Explained

### Authentication System
- Custom authentication implementation
- User registration with email verification
- Password reset functionality
- Remember me feature

### User Management
- CRUD operations for users
- Role-based access control
- User profile management

### Client Management
- Complete client database
- Client information tracking
- Relationship with projects

### Project Management
- Project creation and tracking
- Client association
- Status management
- Date tracking

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## Security

If you discover any security-related issues feel free to open a issue.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Credits

- [Laravel](https://laravel.com)
- [Bootstrap](https://getbootstrap.com)
- [FontAwesome](https://fontawesome.com)
- [OpenWeatherMap](https://openweathermap.org)
