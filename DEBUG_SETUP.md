# Laravel Docker Debugging Setup for PhpStorm

## Prerequisites
- PhpStorm installed
- Docker and Docker Compose running
- Laravel application in Docker containers

## Configuration Changes Made

### 1. Xdebug Configuration (`docker-compose/php/xdebug.ini`)
- Enabled Xdebug with debug mode
- Set client host to `host.docker.internal` (for Windows)
- Set client port to `9003`
- Added IDE key for PhpStorm
- Enabled logging for troubleshooting

### 2. Docker Compose Updates (`docker-compose.yml`)
- Added Xdebug configuration volume mounts
- Added environment variables for Xdebug
- Ensured all containers have proper Xdebug setup

### 3. Dockerfile Updates
- Ensured Xdebug is properly installed
- Added log directory permissions

## PhpStorm Setup Instructions

### Step 1: Configure PHP Interpreter
1. Go to `File` → `Settings` → `PHP`
2. Click `...` next to "CLI Interpreter"
3. Click `+` and select "From Docker, Vagrant, VM, WSL, Remote..."
4. Select "Docker Compose"
5. Choose your `docker-compose.yml` file
6. Select the `php` service
7. Set the path to `/usr/local/bin/php`
8. Click "OK"

### Step 2: Configure Debug Settings
1. Go to `File` → `Settings` → `PHP` → `Debug`
2. Set "Xdebug" port to `9003`
3. Check "Can accept external connections"
4. Uncheck "Force break at first line when no path mapping specified"
5. Check "Force break at first line when a script is outside the project"

### Step 3: Configure Servers
1. Go to `File` → `Settings` → `PHP` → `Servers`
2. Click `+` to add a new server
3. Set Name: `Docker Laravel`
4. Set Host: `localhost`
5. Set Port: `8080`
6. Check "Use path mappings"
7. Map your local `src` folder to `/var/www` on the server
8. Check "Debugger" and select "Xdebug"

### Step 4: Import Run Configuration (Optional)
1. Go to `Run` → `Edit Configurations`
2. Click the gear icon → `Import Configuration`
3. Select the `phpstorm-debug-config.xml` file
4. The configuration will be imported automatically

### Step 5: Start Debugging
1. Start your Docker containers:
   ```bash
   docker-compose up -d
   ```

2. In PhpStorm:
   - Set breakpoints in your PHP code
   - Click the "Start Listening for PHP Debug Connections" button (phone icon)
   - Access your application at `http://localhost:8080`
   - The debugger should stop at your breakpoints

## Troubleshooting

### Check Xdebug Status
1. Create a PHP file with `phpinfo();`
2. Access it through your browser
3. Search for "xdebug" to verify it's installed and configured

### Check Xdebug Logs
1. Access the container: `docker-compose exec php bash`
2. Check logs: `tail -f /tmp/xdebug.log`

### Common Issues

1. **Debugger not connecting:**
   - Ensure port 9003 is not blocked by firewall
   - Check that "Start Listening" is enabled in PhpStorm
   - Verify path mappings are correct

2. **Breakpoints not hitting:**
   - Check that the file paths match exactly
   - Ensure the file is being executed (not cached)
   - Verify Xdebug is enabled in the container

3. **Performance issues:**
   - Xdebug can slow down your application
   - Consider using `xdebug.start_with_request=trigger` instead of `yes`
   - Add `?XDEBUG_SESSION=PHPSTORM` to URLs to trigger debugging

## Environment Variables
Make sure your `.env` file (if you create one) includes:
```
XDEBUG_MODE=debug
XDEBUG_CLIENT_HOST=host.docker.internal
XDEBUG_CLIENT_PORT=9003
XDEBUG_START_WITH_REQUEST=yes
```

## Testing the Setup
1. Create a simple test route in `routes/web.php`:
   ```php
   Route::get('/test-debug', function () {
       $test = 'Hello Debug!';
       return $test; // Set breakpoint here
   });
   ```

2. Set a breakpoint on the return line
3. Access `http://localhost:8080/test-debug`
4. The debugger should stop at your breakpoint

## Notes
- The setup uses port 9003 for Xdebug (standard for Xdebug 3.x)
- `host.docker.internal` is used for Windows Docker Desktop
- For Linux, you might need to use your host machine's IP address
- Make sure your Laravel application has a proper `.env` file with database credentials 