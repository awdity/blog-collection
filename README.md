
# Blog Collection API

This is a Blog Collection API built with Laravel. It provides features such as role-based authorization, sorting, searching, tag-based filtering, pagination, and optimization for large datasets. The application allows users with different roles to perform specific actions, including creating, editing, and deleting blog posts.

## Features

- **Sorting**: Sort blogs by title, date, or other parameters.
- **Search**: Search blog posts by title or content.
- **Tag-based Filtering**: Filter blogs based on tags.
- **Pagination**: Paginate through large datasets efficiently.
- **Role-Based Authorization**: 
  - **Admin**: Full access (create, edit, delete).
  - **Author**: Create and edit blog posts, but cannot delete.
  - **User**: View-only access.

## Requirements

- PHP >= 8.2
- Composer
- Laravel >= 9.x
- MySQL
- Node.js and npm (for frontend assets, if applicable)
- Spatie Laravel Permission package

## Installation

1. **Clone the repository**:
   ```bash
   git clone https://github.com/awdity/blog-collection.git
   cd blog-collection
   ```

2. **Install dependencies**:
   Install PHP dependencies using Composer:
   ```bash
   composer install
   ```

3. **Create the `.env` file**:
   Create a copy of the `.env.example` file and name it `.env`:
   ```bash
   cp .env.example .env
   ```

4. **Set up environment variables**:
   Open the `.env` file and configure the database settings:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=blog_collection
   DB_USERNAME=root
   DB_PASSWORD=your_password
   ```

5. **Generate the application key**:
   ```bash
   php artisan key:generate
   ```

6. **Run database migrations**:
   Run the migrations to create the required database tables:
   ```bash
   php artisan migrate
   ```

7. **Seed the database**:
   Run the seeders to populate the database with roles and permissions:
   ```bash
   php artisan db:seed --class=RolesAndPermissionsSeeder
   ```

8. **Run the application**:
   Start the Laravel development server:
   ```bash
   php artisan serve
   ```
   
### Blog Endpoints

- **Get All Blogs**: `GET /api/blogs`
  - Returns a paginated list of blog posts.
  
- **Create a Blog (Admin/Author Only)**: `POST /api/blogs`
  - Request: `{ "title": "My Blog", "content": "Blog content", "tags": ["tag1", "tag2"] }`
  - Requires authentication and role authorization.
  
- **Update a Blog (Admin/Author Only)**: `PUT /api/blogs/{id}`
  - Request: `{ "title": "Updated Title", "content": "Updated content", "tags": ["tag1", "tag3"] }`
  - Requires authentication and role authorization.
  
- **Delete a Blog (Admin Only)**: `DELETE /api/blogs/{id}`
  - Requires Admin role authorization.

### Role-Based Access Control

- **Roles**:
  - Admin: Can create, update, and delete blog posts.
  - Author: Can create and update blog posts, but cannot delete them.
  - User: Can view blog posts but cannot create, update, or delete them.

## Additional Notes

- The application uses **Spatie Laravel Permission** package for managing roles and permissions.

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
