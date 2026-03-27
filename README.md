# User Management & Activity Logging System

A comprehensive Laravel application for managing users, roles, permissions, and tracking system activities with real-time audit logs.

## 📋 Features

### User Management
- Create, read, update, and delete users
- Soft delete functionality (restore deleted users)
- Search users by name or email
- Filter users by role
- Password hashing and validation
- User role assignment

### Role & Permission Management
- Create custom roles dynamically
- Assign permissions to roles
- Assign roles to users
- Fine-grained permission control for UI features:
  - `manage-users` — Create, edit, delete users
  - `view-users` — View user list
  - `manage-roles` — Manage roles and permissions
  - `view-roles` — View roles
  - `view-logs` — Access activity logs

### Activity Logging
- Automatic tracking of all user operations:
  - User created, updated, deleted, restored
  - User login events
  - Activity descriptions with user names and changed attributes
- Comprehensive activity log dashboard with:
  - Timestamp
  - User who performed action
  - Action description
  - Subject (affected resource)
  - Changed attributes

### Dashboard
- Overview statistics:
  - Total users
  - Total roles
  - Total activity logs
  - Number of deleted users
- Recent activity feed
- Quick navigation to key sections

### Authentication & Authorization
- Laravel's built-in authentication system
- Password reset functionality
- Role-based access control (RBAC)

## 🛠️ Tech Stack

- **Framework:** Laravel 12
- **Frontend:** Blade Templates with Tailwind CSS
- **Database:** MySQL
- **Packages:**
  - `spatie/laravel-permission` — Role/Permission management
  - `spatie/laravel-activitylog` — Activity logging
  - `laravel/breeze` — Authentication scaffolding

## 📁 Project Structure

```
my-project/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── UserController.php         # User CRUD & search
│   │       ├── RoleController.php         # Role management
│   │       └── ActivityLogController.php  # Activity log display
│   ├── Listeners/
│   │   └── LogSuccessfulLogin.php        # Login event tracking
│   ├── Models/
│   │   └── User.php                      # User model with activity logging
│   └── Providers/
│       └── AppServiceProvider.php        # Event listener registration
├── config/
│   ├── activitylog.php                   # Activity logging config
│   ├── permission.php                    # Permission config
│   └── auth.php                          # Auth config
├── database/
│   ├── migrations/                       # Database schemas
│   └── seeders/
│       └── RoleAndPermissionSeeder.php   # Default roles, permissions, users
├── resources/
│   └── views/
│       ├── users/
│       │   ├── index.blade.php           # User list with search/filter
│       │   ├── create.blade.php          # Create user form
│       │   ├── edit.blade.php            # Edit user form
│       │   └── roles/                    # Role management views
│       ├── activity/
│       │   └── index.blade.php           # Activity log view
│       ├── dashboard.blade.php           # Dashboard
│       └── layouts/                      # Navigation & layout components
├── routes/
│   ├── web.php                           # Web routes
│   └── auth.php                          # Auth routes
└── README.md                             # This file
```

## 🚀 Getting Started

### Prerequisites
- PHP 8.2+
- MySQL 8.0+
- Composer
- Node.js 16+

### Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/popotingasoooo/my-project
   cd my-project
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Copy environment file**
   ```bash
   cp .env.example .env
   ```

4. **Configure database** in `.env`
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=my_project
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Run migrations**
   ```bash
   php artisan migrate
   ```

6. **Seed default data**
   ```bash
   php artisan db:seed
   ```
   This creates:
   - Admin role with all permissions
   - Staff role with view-only permissions
   - Default admin user (email: Admin@test, password: password)
   - Default staff user (email: Staff@test, password: password)


7. **Start development server**
    ```bash
    php artisan serve
    ```

Visit `http://localhost:8000` and log in with the seeded credentials.

## 📊 Usage Guide

### User Management

#### View Users
- Navigate to **Users** in the navigation menu
- See pagination, search, and role filter
- View soft-deleted users in a separate table below

#### Create User
1. Click **+ Create User** button
2. Fill in name, email, password
3. Select role from dynamic dropdown (all created roles available)
4. Click **Create**
5. Activity logged: "Created user: John Doe"

#### Edit User
1. Click **Edit** button next to a user
2. Modify name, email, or role
3. Optionally set a new password
4. Click **Update**
5. Activity logged: "Updated user: John Doe"

#### Delete User (Soft Delete)
1. Click **Delete** button next to a user
2. Confirm deletion
3. User moves to "Deleted Users" section
4. Activity logged: "Deleted user: John Doe"

#### Restore User
1. In the **Deleted Users** table below
2. Click **Restore** button
3. User re-appears in active users list
4. Activity logged: "Restored user: John Doe"

#### Search & Filter
- **Search:** By name or email (case-insensitive)
- **Filter:** By role (admin, staff, or any custom role)
- **Clear:** Reset all filters
- Results maintain query parameters in pagination

### Role Management

#### View Roles
- Navigate to **Roles** in the navigation menu
- See all roles with their assigned permissions

#### Create Role
1. Click **+ New Role** button
2. Enter role name
3. Select permissions to assign
4. Click **Create**

#### Assign Roles to Users
1. Click **Assign Roles** button
2. Select a user
3. Select role(s) to assign
4. Submit
5. Activity logged: "Updated user: [name]"

### Activity Logs

#### View Activity Log
- Navigate to **Activity Logs** in the navigation menu
- See all system activities with:
  - **Date & Time:** When the action occurred
  - **User:** Who performed the action
  - **Action:** What was done (e.g., "Created user: Sarah")
  - **Subject:** Type of resource affected (User, Role, etc.)
  - **Changes:** Specific attributes that changed

#### Logged Events
- **User Login:** "User John Doe logged in"
- **User Creation:** "Created user: Jane Smith"
- **User Update:** "Updated user: Bob Johnson"
- **User Delete:** "Deleted user: Alice Brown"
- **User Restore:** "Restored user: Charlie Davis"

### Dashboard
- **Quick Stats:** View totals for users, roles, and activity logs
- **Deleted Users Count:** See how many users are in trash
- **Recent Activity:** See the 5 most recent actions in the system

## 🔐 Authentication & Authorization

### Login
- Use email and password from seeding
- Or register a new account

### Permissions

| Permission | Role | Access |
|---|---|---|
| `manage-users` | Admin | ✅ Create, edit, delete users |
| `view-users` | Admin, Staff | ✅ View user list |
| `manage-roles` | Admin | ✅ Create roles, assign permissions |
| `view-roles` | Admin, Staff | ✅ View roles |
| `view-logs` | Admin | ✅ View activity logs |

### Adding New Permissions
1. Update `RoleAndPermissionSeeder.php`
2. Add permission name to array
3. Re-seed database: `php artisan db:seed`

## 🔍 Key Code Examples

### Search & Filter Users
```php
// UserController@index
if ($request->filled('search')) {
    $query->where(function ($q) use ($request) {
        $q->where('name', 'like', '%' . $request->search . '%')
          ->orWhere('email', 'like', '%' . $request->search . '%');
    });
}

if ($request->filled('role')) {
    $query->where('role', $request->role);
}
```

### Activity Logging
User model tracks changes automatically:
```php
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Authenticatable {
    use LogsActivity;
    
    public function getActivityLogOptions(): LogOptions {
        return LogOptions::defaults()
            ->logOnly(['name', 'email', 'role'])
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => 
                ucfirst($eventName) . ' user: ' . ($this->name ?? 'N/A')
            );
    }
}
```

### Login Logging
```php
// LogSuccessfulLogin.php
activity()
    ->causedBy($event->user)
    ->performedOn($event->user)
    ->log('User ' . $event->user->name . ' logged in');
```

## 🐛 Troubleshooting

### Roles not syncing between Users and Roles sections
- Clear cache: `php artisan cache:clear`
- Re-seed: `php artisan db:seed`
- Check that `spatie/laravel-permission` package is installed

### Activity logs not showing
- Ensure `LogsActivity` trait is added to User model
- Run migrations: `php artisan migrate`
- Check activity log table in database

### Search not working
- Verify `UserController@index` uses `$request->filled()` not `$request->filed()`
- Check form in `users/index.blade.php` has `method="GET"`

### Permissions not working
- Clear cache: `php artisan cache:clear`
- Re-run seeder: `php artisan db:seed`

## 📝 Environment Variables

Key `.env` variables:

```
APP_NAME="User Management System"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=my_project
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=log
```

## 📦 Dependencies

```json
{
  "require": {
    "php": "^8.2",
    "laravel/framework": "^11.0",
    "spatie/laravel-permission": "^6.0",
    "spatie/laravel-activitylog": "^4.0"
  }
}
```

## 🤝 Contributing

1. Create a feature branch
2. Make your changes
3. Test thoroughly
4. Submit a pull request


## ✉️ Support

For issues or questions, contact me from my place near the pantry.

---

**Last Updated:** March 27, 2026
**Version:** 1.0.0
