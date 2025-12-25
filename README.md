# PulseBuy E-commerce

## Running with Docker

This project includes a Docker setup for local development with PHP, MySQL, and phpMyAdmin.

### Prerequisites
- [Docker](https://www.docker.com/products/docker-desktop) installed
- [Docker Compose](https://docs.docker.com/compose/) (if not included with Docker)

### Usage

1. **Build and start the containers:**
   ```sh
   docker-compose up --build
   ```

2. **Access the application:**
   - Web app: [http://localhost:8080](http://localhost:8080)
   - phpMyAdmin: [http://localhost:8081](http://localhost:8081)
     - Server: `db`
     - Username: `pulseuser` or `root`
     - Password: `pulsepass` or `rootpass`

3. **Database connection settings:**
   - Host: `db`
   - Database: `pulsebuy`
   - User: `pulseuser`
   - Password: `pulsepass`

4. **Stop the containers:**
   ```sh
   docker-compose down
   ```

### Notes
- Place your SQL schema/data in a migration script or import via phpMyAdmin.
- The web server runs on port 8080, phpMyAdmin on 8081.