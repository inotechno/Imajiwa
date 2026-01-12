# Deployment Guide for Imajiwa

This guide covers the deployment of the **Imajiwa** project, which consists of a Laravel frontend and a Node.js WebSocket server (`tldraw-sync-server`).

## Prerequisites

Ensure your VPS has the following installed:
*   **PHP 8.2+** (with extensions: `bcmath`, `ctype`, `fileinfo`, `json`, `mbstring`, `openssl`, `pdo`, `tokenizer`, `xml`)
*   **Composer**
*   **Node.js 20+** & **NPM**
*   **Nginx** (Web Server)
*   **PM2** (Process Manager for Node.js): `npm install -g pm2`
*   **Git**

## 1. Clone the Repository

```bash
cd /var/www
git clone https://github.com/your-username/Imajiwa.git
cd Imajiwa
```

## 2. Laravel Setup (Frontend & Backend)

```bash
# Install PHP Dependencies
composer install --optimize-autoloader --no-dev

# Copy Environment File
cp .env.example .env

# Generate Key
php artisan key:generate

# Set Permissions
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache
```

### Configure .env
Edit `.env` and update your database credentials and app URL:
```ini
APP_URL=https://imajiwa.id
DB_HOST=127.0.0.1
DB_DATABASE=your_db_name
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password

# WebSocket Configuration
VITE_TLDRAW_SYNC_URL=wss://socket.imajiwa.id
```

## 3. Tldraw Sync Server Setup (Node.js)

```bash
cd tldraw-sync-server

# Install Dependencies
npm install

# Copy Environment File
cp .env.example .env
```

### Configure Server .env
Edit `tldraw-sync-server/.env`:
```ini
PORT=5858
# If DB is on the same VPS:
DB_HOST=127.0.0.1
# If DB is on External Hosting:
DB_HOST=103.x.x.x  # IP of your Shared Hosting
DB_DATABASE=your_db_name
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password
```

### Start with PM2
```bash
pm2 start src/server.js --name "imajiwa-sync"
pm2 save
pm2 startup
```

## 4. Nginx Configuration

You need two server blocks: one for the main Laravel app and one for the WebSocket server (or use a location block).

### Main App (imajiwa.id)
```nginx
server {
    listen 80;
    server_name imajiwa.id;
    root /var/www/Imajiwa/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

### WebSocket Proxy (socket.imajiwa.id)
Recommended to use a subdomain for SSL flexibility.

```nginx
server {
    listen 80;
    server_name socket.imajiwa.id;

    location / {
        proxy_pass http://127.0.0.1:5858;
        proxy_http_version 1.1;
        proxy_set_header Upgrade $http_upgrade;
        proxy_set_header Connection "Upgrade";
        proxy_set_header Host $host;
    }
}
```

## 5. SSL (Certbot)
Secure both domains:
```bash
certbot --nginx -d imajiwa.id -d socket.imajiwa.id
```

## 6. Build Frontend Assets
```bash
# Back to root
cd /var/www/Imajiwa
npm install
npm run build
```
