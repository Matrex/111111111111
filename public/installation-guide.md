# Claw Machine Game Installation Guide

## Prerequisites
- Web server with PHP 7.0+ support
- MySQL database
- FTP access to your web server (or equivalent file transfer method)

## Installation Steps

1. **Prepare the files**
   - Download all the game files and organize them according to the folder structure provided earlier.
   - Ensure all files are in their correct directories.

2. **Upload files to the server**
   - Use FTP or your preferred method to upload all files and folders to your web server.
   - Typically, you'll want to upload these to a directory like `public_html/claw_machine/` or wherever you want the game to be accessible.

3. **Set permissions**
   - Ensure the `uploads/` directory is writable by the web server.
   - On Unix-based systems, you might need to use a command like:
     ```
     chmod 755 uploads/
     ```

4. **Create a MySQL database**
   - Log into your MySQL management tool (e.g., phpMyAdmin).
   - Create a new database for the claw machine game.
   - Note down the database name, username, and password.

5. **Run the installer**
   - In your web browser, navigate to the install script:
     ```
     http://your-domain.com/path-to-game/install.php
     ```
   - Fill in the database details (host, name, username, password) you noted earlier.
   - Click "Install" to run the installation process.

6. **Verify the installation**
   - The installer should create the necessary database tables and a configuration file.
   - If successful, you should see a success message.

7. **Secure the installation**
   - After successful installation, delete or rename `install.php` to prevent security issues.

8. **Access the game**
   - Navigate to the main game URL:
     ```
     http://your-domain.com/path-to-game/index.php
     ```
   - You should see the game interface.

9. **Access the admin panel**
   - Navigate to the admin panel:
     ```
     http://your-domain.com/path-to-game/admin.php
     ```
   - Log in with the default credentials:
     - Username: admin
     - Password: admin123
   - Important: Change the admin password immediately after your first login.

10. **Configure the game**
    - Use the admin panel to set up game parameters, add prizes, etc.

11. **Test the game**
    - Play through the game to ensure all features are working correctly.
    - Test on different devices and browsers to ensure compatibility.

## Troubleshooting
- If you encounter database connection errors, double-check your database credentials in `config.php`.
- For file permission issues, ensure your web server has appropriate read/write access to the necessary directories.
- If you experience any PHP errors, check your server's PHP error logs for more details.

## Security Notes
- Always keep your server software and PHP up to date.
- Regularly update the admin password.
- Consider implementing additional security measures like IP restrictions for the admin panel.

For any further issues or questions, please refer to the game's documentation or seek support from the game's developer.
