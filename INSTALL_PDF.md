# PDF Export Installation Guide

## Installing dompdf/dompdf Library

The PDF export feature requires the `dompdf/dompdf` library. Follow these steps to install it:

### Step 1: Install Composer (if not already installed)

**Windows:**
1. Download Composer from: https://getcomposer.org/download/
2. Run the installer
3. Or download `composer.phar` and place it in your project root

**Linux/Mac:**
```bash
curl -sS https://getcomposer.org/installer | php
```

### Step 2: Install dompdf

Open terminal/command prompt in your project root directory (`C:\xampp\htdocs\badhon_pstu`) and run:

```bash
composer require dompdf/dompdf
```

Or if you're using `composer.phar`:

```bash
php composer.phar require dompdf/dompdf
```

### Step 3: Verify Installation

After installation, you should see:
- A `vendor/` folder in your project root
- A `composer.json` file (already created)
- A `composer.lock` file (created after installation)

### Step 4: Test PDF Export

1. Log in to your dashboard
2. Go to "প্রোফাইল তালিকা" (Profiles List)
3. Click "Export PDF" on any profile
4. The PDF should download automatically

## Troubleshooting

### If composer command is not found:
- Make sure Composer is installed and in your system PATH
- Or use `php composer.phar` instead of `composer`

### If you get permission errors:
- On Linux/Mac, you may need to use `sudo`
- On Windows, run command prompt as Administrator

### If PDF generation fails:
- Check that the `vendor/` folder exists
- Verify `vendor/autoload.php` file exists
- Check PHP error logs for specific error messages

## Alternative: Manual Installation

If you cannot use Composer, you can manually download dompdf:
1. Download from: https://github.com/dompdf/dompdf/releases
2. Extract to `vendor/dompdf/dompdf/` folder
3. Ensure autoloader is properly configured

## Support

For issues with dompdf, visit: https://github.com/dompdf/dompdf

