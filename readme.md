# Order Management System

A comprehensive order management system built with Laravel framework for managing orders, products, parties, inventory, and generating various business reports.

## Project Overview

This is a full-featured order management application designed to handle the complete order lifecycle from product catalog management to order processing, dispatch tracking, and comprehensive reporting. The system includes both a web-based admin panel and a REST API for mobile application integration.

## Tech Stack

### Backend
- **Framework**: Laravel 5.7
- **PHP**: ^7.1.3
- **Database**: MySQL
- **Authentication**: Laravel Auth with Role-Based Access Control (RBAC)

### Frontend
- **JavaScript**: jQuery, Vue.js 2.5.17
- **CSS Framework**: Bootstrap 4.0.0
- **Build Tool**: Laravel Mix 4.0.7
- **UI Libraries**: DataTables, Select2, and various jQuery plugins

### Key Packages
- `jeremykenedy/laravel-roles` (1.4.0) - Role and permission management
- `yajra/laravel-datatables-oracle` (~8.0) - Server-side DataTables integration
- `barryvdh/laravel-dompdf` (^0.8.5) - PDF generation
- `maatwebsite/excel` (~2.1.0) - Excel import/export functionality

## Folder Structure

```
order_management-master/
├── app/
│   ├── Console/          # Artisan commands and scheduled tasks
│   ├── Exceptions/      # Exception handlers
│   ├── Helpers/         # Helper functions (Helper.php)
│   ├── Http/
│   │   ├── Controllers/ # Application controllers
│   │   └── Middleware/  # Custom middleware (API token verification)
│   ├── Mail/            # Email templates and mailable classes
│   ├── Models/          # Eloquent models
│   └── Providers/       # Service providers
├── bootstrap/           # Application bootstrap files
├── config/             # Configuration files
├── database/
│   ├── migrations/     # Database migrations
│   └── seeds/          # Database seeders
├── public/             # Public assets and entry point
├── resources/
│   ├── js/             # JavaScript source files
│   ├── lang/           # Language files (English, Gujarati)
│   ├── sass/           # SCSS source files
│   └── views/          # Blade templates
├── routes/             # Route definitions (web.php, api.php, console.php)
├── storage/            # Logs, cache, and uploaded files
└── tests/              # PHPUnit tests
```

## Feature List

### Core Modules

#### 1. **Order Management**
- Create, edit, and view orders
- Order numbering system (OR_1, OR_2, etc.)
- Multiple products per order
- Order status tracking (Pending/Dispatch)
- Dispatch quantity management
- LR number and transporter tracking
- Order detail view with product breakdown

#### 2. **Product Management**
- Product catalog with categories
- Product images support
- Opening stock management
- Product pricing
- Active/Inactive status control
- Product search and filtering

#### 3. **Party/Customer Management**
- Party registration with contact details
- State and City association
- Mobile number validation
- Address management
- Active/Inactive status control

#### 4. **Purchase/Stock Management**
- Purchase order creation
- Stock adjustment entries
- Transaction-based stock tracking
- Purchase history
- Stock voucher system

#### 5. **Category Management**
- Product categorization
- Category images
- Status management

#### 6. **Geographic Management**
- State management
- City management (linked to states)
- State-City relationships

#### 7. **Dealer Management**
- Dealer registration
- City-wise dealer assignment
- User-dealer associations
- Dealer search functionality

#### 8. **User & Role Management**
- User account management
- Role-based access control (RBAC)
- Permission system
- User activation/deactivation
- Password change functionality
- Login logging and session management

#### 9. **Reporting System**
- **Party-wise Report**: Orders grouped by party/customer
- **Product-wise Report**: Sales analysis by product
- **Date-wise Report**: Orders filtered by date range
- **City-wise Report**: Geographic sales analysis
- Print and export capabilities

#### 10. **Settings**
- Application settings management
- GST configuration (CGST, SGST, IGST)
- Company logo and favicon
- GST type settings (Inter-state/Out of state)

#### 11. **REST API**
- Token-based authentication
- Mobile app integration support
- API endpoints for:
  - User login/logout
  - City list
  - Dealer management
  - Order creation and status
  - Category and product listing
  - Dealer search
  - Order details

#### 12. **Email Notifications**
- Order placement email notifications
- Configurable recipient lists
- Order detail email templates

#### 13. **Multi-language Support**
- English (en)
- Gujarati (gu)
- Language switching functionality

## Application Flow

### Order Processing Flow

1. **Product Setup**
   - Admin creates categories
   - Products are added under categories
   - Opening stock is set for products

2. **Stock Management**
   - Purchase orders are created to add stock
   - Stock transactions are recorded automatically
   - Stock levels are maintained per product

3. **Party Registration**
   - Parties (customers) are registered with state/city
   - Contact information is stored

4. **Order Creation**
   - User selects party
   - Products are added to order
   - Quantities, prices, discounts are set
   - GST calculations (CGST/SGST/IGST) based on party location
   - Order is saved with unique order number

5. **Order Dispatch**
   - Orders can be partially or fully dispatched
   - Dispatch quantity is tracked
   - LR number and transporter details are added
   - Order status changes to "Dispatch" when fully dispatched

6. **Reporting**
   - Various reports can be generated
   - Reports can be printed or exported
   - Filters available by date, party, product, city

### API Flow

1. **Authentication**
   - Mobile app sends login credentials
   - System validates and returns session token
   - Token is stored in login_logs table

2. **API Requests**
   - All API requests (except login) require user_id and session_token
   - Middleware verifies token validity
   - Request is processed and JSON response returned

3. **Order Creation via API**
   - Dealer and city are selected
   - Products and quantities are specified
   - Order is created and email notification is sent

## API & Third-Party Integrations

### REST API Endpoints

**Base URL**: `/api/webservice`

**Authentication**: Token-based (session_token)

**Available Tasks**:
- `Login` - User authentication
- `Logout` - Session termination
- `CityList` - Get all cities
- `Dealer` - Get dealers by city
- `AddOrder` - Create new order
- `OrderStatus` - Get order status list
- `Category` - Get active categories
- `Product` - Get products by category
- `SearchDealer` - Search dealers by name
- `OrderDetail` - Get detailed order information

**Request Format**:
```json
{
  "task": "TaskName",
  "taskData": {
    "user_id": "2",
    "session_token": "token_string",
    // ... other task-specific data
  }
}
```

### Email Service
- **Driver**: SMTP (configurable)
- **Purpose**: Order placement notifications
- **Configuration**: Via `.env` file (MAIL_* variables)

### PDF Generation
- **Library**: DomPDF
- **Usage**: Report generation and order printing

### Excel Export
- **Library**: Maatwebsite Excel
- **Usage**: Data export functionality

## Setup & Installation

### Prerequisites
- PHP >= 7.1.3
- Composer
- MySQL 5.7+ or MariaDB
- Node.js and NPM
- Web server (Apache/Nginx) or PHP built-in server

### Installation Steps

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd order_management-master
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node dependencies**
   ```bash
   npm install
   ```

4. **Environment Configuration**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure Database**
   Edit `.env` file with your database credentials:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=order_management
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

6. **Run Migrations**
   ```bash
   php artisan migrate
   ```

7. **Seed Database (Optional)**
   ```bash
   php artisan db:seed
   ```

8. **Create Storage Link**
   ```bash
   php artisan storage:link
   ```

9. **Compile Assets**
   ```bash
   # Development
   npm run dev
   
   # Production
   npm run production
   ```

10. **Set Permissions** (Linux/Mac)
    ```bash
    chmod -R 775 storage bootstrap/cache
    chown -R www-data:www-data storage bootstrap/cache
    ```

## Environment Variables

Create a `.env` file in the root directory with the following variables:

```env
APP_NAME="Order Management System"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

LOG_CHANNEL=stack

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=order_management
DB_USERNAME=root
DB_PASSWORD=

BROADCAST_DRIVER=log
CACHE_DRIVER=file
SESSION_DRIVER=file
SESSION_LIFETIME=120
QUEUE_CONNECTION=sync

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_DRIVER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=noreply@example.com
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=mt1

MIX_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
MIX_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
```

## Running the Project

### Local Development

1. **Start the development server**
   ```bash
   php artisan serve
   ```
   Application will be available at `http://localhost:8000`

2. **Watch for asset changes** (in separate terminal)
   ```bash
   npm run watch
   ```

### Production Deployment

1. **Optimize for production**
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   composer install --optimize-autoloader --no-dev
   npm run production
   ```

2. **Set environment**
   ```env
   APP_ENV=production
   APP_DEBUG=false
   ```

3. **Configure web server** (Apache/Nginx) to point to `public/` directory

## Cron Jobs / Background Tasks

Currently, no scheduled cron jobs are configured in the application. The `app/Console/Kernel.php` file has an empty schedule method.

To set up cron jobs (if needed in future):
```bash
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

## Database Models & Relationships

### Core Models

- **Order**: Links products, parties, and users. Tracks order details, quantities, GST, dispatch status
- **Product**: Belongs to Category. Has opening stock and pricing
- **Party**: Belongs to State and City. Customer information
- **Purchase**: Stock purchase entries linked to products
- **Stock**: Transaction-based stock tracking
- **Category**: Product categorization
- **State**: Geographic state information
- **City**: Belongs to State
- **Dealer**: Belongs to City and User
- **User**: Laravel authentication model with roles
- **Role**: Role-based access control
- **Permission**: Granular permissions
- **Setting**: Application configuration
- **Login_log**: API session token tracking

### Key Relationships

- Order → Product (belongsTo)
- Order → Party (belongsTo)
- Order → User (belongsTo, added_by/updated_by)
- Product → Category (belongsTo)
- Party → State (belongsTo)
- Party → City (belongsTo)
- Dealer → City (belongsTo)
- Dealer → User (belongsTo)

## Common Use Cases

### Creating an Order
1. Navigate to Orders → Create
2. Select Party
3. Add products with quantities
4. System calculates prices and GST automatically
5. Add instructions and save
6. Order number is auto-generated

### Processing Purchase/Stock
1. Navigate to Purchase → Create
2. Select date and products
3. Enter quantities
4. System automatically creates stock entries
5. Stock levels are updated

### Generating Reports
1. Navigate to desired report (Party-wise/Product-wise/Date-wise/City-wise)
2. Apply filters (date range, party, product, city)
3. View results in DataTable
4. Print or export as needed

### API Order Creation
1. Mobile app authenticates user
2. App fetches cities and dealers
3. User selects products and quantities
4. Order is created via API
5. Email notification is sent automatically

## Known Limitations

1. **No Scheduled Jobs**: No automated background tasks configured
2. **Email Configuration**: Email settings need manual configuration in `.env`
3. **File Storage**: Product images stored in `storage/app/product/` - ensure proper permissions
4. **API Rate Limiting**: No rate limiting implemented for API endpoints
5. **Stock Validation**: No automatic stock validation when creating orders
6. **Order Cancellation**: No explicit order cancellation workflow
7. **Payment Integration**: No payment gateway integration
8. **Multi-currency**: Single currency support only

## Future Improvements

Based on code structure and common requirements:

1. **Stock Validation**: Implement stock availability checks before order creation
2. **Order Cancellation**: Add order cancellation workflow with proper status tracking
3. **Advanced Reporting**: Add more analytical reports (sales trends, profit margins)
4. **Barcode Support**: Add barcode scanning for products
5. **Inventory Alerts**: Low stock alerts and notifications
6. **Payment Integration**: Integrate payment gateways for order payments
7. **Multi-warehouse**: Support for multiple warehouse locations
8. **Order History**: Enhanced order history with status timeline
9. **API Rate Limiting**: Implement rate limiting for API endpoints
10. **Audit Logging**: Comprehensive audit trail for all operations
11. **Export Formats**: Additional export formats (CSV, JSON)
12. **Dashboard Analytics**: Real-time dashboard with key metrics
13. **Mobile App Enhancements**: Push notifications for order status updates
14. **Bulk Operations**: Bulk order creation and updates
15. **Advanced Search**: Full-text search across orders, products, parties

## Contribution Guidelines

1. **Fork the repository**
2. **Create a feature branch**
   ```bash
   git checkout -b feature/your-feature-name
   ```
3. **Follow coding standards**
   - PSR-2 coding style
   - Meaningful variable and function names
   - Add comments for complex logic
4. **Write tests** for new features
5. **Update documentation** if needed
6. **Commit changes** with descriptive messages
7. **Push to your branch** and create a Pull Request

### Code Style
- Follow Laravel conventions
- Use meaningful variable names
- Add PHPDoc comments for methods
- Keep controllers thin, move logic to models/services

## Security Considerations

1. **API Authentication**: Token-based authentication implemented
2. **CSRF Protection**: Enabled for web routes
3. **SQL Injection**: Using Eloquent ORM (parameterized queries)
4. **XSS Protection**: Blade templating engine escapes output
5. **Password Hashing**: Laravel's bcrypt hashing
6. **Session Management**: Secure session handling

**Note**: Ensure proper security measures in production:
- Use HTTPS
- Set strong database passwords
- Regularly update dependencies
- Review and restrict file uploads
- Implement proper backup strategy

## License

Not specified. Please check with the project owner for licensing information.

## Support

For issues, questions, or contributions, please contact the development team or create an issue in the repository.

---

**Version**: 1.0.0  
**Last Updated**: Based on Laravel 5.7  
**PHP Version**: ^7.1.3
