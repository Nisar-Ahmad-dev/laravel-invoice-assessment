# Laravel Invoice Assessment

Arabic RTL invoice application built with **Laravel** and **Livewire**. Create invoices with dynamic line items, server-side total calculations, MySQL persistence, and PDF preview.

## Features

- Arabic RTL invoice form (فاتورة)
- Customer dropdown with inline add-customer form
- 2–3 dynamic item rows (add/remove, minimum 2 rows)
- Server-side calculation of quantity, unit price, discount, tax, and totals
- Save invoices and line items to MySQL
- PDF preview in the browser (mPDF with Arabic RTL shaping)
- Clean Laravel structure with dedicated services

## Requirements

- PHP 8.2+
- Composer
- Node.js 18+
- MySQL 8

## Setup

```bash
git clone https://github.com/Nisar-Ahmad-dev/laravel-invoice-assessment.git
cd laravel-invoice-assessment
composer install
cp .env.example .env
php artisan key:generate
```

Configure MySQL in `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_invoice
DB_USERNAME=root
DB_PASSWORD=
```

Create the database, then migrate and seed:

```bash
mysql -u root -e "CREATE DATABASE laravel_invoice CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
php artisan migrate --seed
npm install && npm run build
php artisan serve
```

Open [http://127.0.0.1:8000](http://127.0.0.1:8000)

## Usage

1. Select a customer from the dropdown, or click **+ إضافة عميل جديد** to add one.
2. Fill in item rows (description, quantity, unit price, discount %, tax %).
3. Totals update automatically via Livewire server requests (no client-side math).
4. Click **حفظ الفاتورة** to save.
5. On the success page, click **معاينة PDF** to preview the invoice PDF.

## Server-side calculations

All totals are computed in PHP by `App\Services\InvoiceCalculator`:

```
line_subtotal = quantity × unit_price
line_discount = line_subtotal × (discount_percent / 100)
taxable       = line_subtotal − line_discount
line_tax      = taxable × (tax_percent / 100)
line_total    = taxable + line_tax
```

`InvoiceForm` recalculates on every field change (`wire:model.live`). `InvoiceService` recalculates again before saving to ensure persisted values match server logic.

## Project structure

```
app/
  Http/Controllers/InvoiceController.php
  Http/Controllers/InvoicePdfController.php
  Livewire/InvoiceForm.php
  Livewire/AddCustomer.php
  Models/Customer.php, Invoice.php, InvoiceItem.php
  Services/InvoiceCalculator.php, InvoiceService.php
database/migrations/
database/seeders/CustomerSeeder.php
resources/views/
  layouts/invoice.blade.php
  livewire/
  invoices/show.blade.php
  pdf/invoice.blade.php
```

## License

MIT

## Publishing to GitHub

Repository: [github.com/Nisar-Ahmad-dev/laravel-invoice-assessment](https://github.com/Nisar-Ahmad-dev/laravel-invoice-assessment)
