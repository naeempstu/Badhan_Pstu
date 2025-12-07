@echo off
echo Installing dompdf/dompdf library for PDF export...
echo.

REM Check if composer exists
where composer >nul 2>&1
if %ERRORLEVEL% NEQ 0 (
    echo ERROR: Composer is not installed or not in PATH.
    echo.
    echo Please install Composer first:
    echo 1. Download from: https://getcomposer.org/download/
    echo 2. Or use: php composer.phar require dompdf/dompdf
    echo.
    pause
    exit /b 1
)

echo Composer found. Installing dompdf/dompdf...
echo.

composer require dompdf/dompdf

if %ERRORLEVEL% EQU 0 (
    echo.
    echo ========================================
    echo Installation successful!
    echo ========================================
    echo.
    echo PDF export should now work. Try exporting a profile.
) else (
    echo.
    echo ========================================
    echo Installation failed!
    echo ========================================
    echo.
    echo Please check the error messages above.
)

echo.
pause

