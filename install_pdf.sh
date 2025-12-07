#!/bin/bash

echo "Installing dompdf/dompdf library for PDF export..."
echo ""

# Check if composer exists
if ! command -v composer &> /dev/null; then
    echo "ERROR: Composer is not installed or not in PATH."
    echo ""
    echo "Please install Composer first:"
    echo "  curl -sS https://getcomposer.org/installer | php"
    echo "  php composer.phar require dompdf/dompdf"
    echo ""
    exit 1
fi

echo "Composer found. Installing dompdf/dompdf..."
echo ""

composer require dompdf/dompdf

if [ $? -eq 0 ]; then
    echo ""
    echo "========================================"
    echo "Installation successful!"
    echo "========================================"
    echo ""
    echo "PDF export should now work. Try exporting a profile."
else
    echo ""
    echo "========================================"
    echo "Installation failed!"
    echo "========================================"
    echo ""
    echo "Please check the error messages above."
    exit 1
fi

