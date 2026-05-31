# Database Integration Verification Guide

## Current Status
✅ **Controllers**: Using real database queries with Eloquent
✅ **Models**: All relationships properly defined  
✅ **Routes**: All 7 user routes registered
✅ **Views**: Ready for data binding
⏳ **Test Data**: Ready to insert

## Quick Start - Wire Database

### Option 1: Use Laravel Seeder (RECOMMENDED)

```bash
# Run the custom seeder
php artisan db:seed --class=UserExampleDataSeeder

# Or seed everything
php artisan migrate:fresh --seed
```

### Option 2: Use Tinker Interactive Shell

```bash
php artisan tinker
> include('database/seeds/insert_user_example_data.php')
```

### Option 3: Direct SQL Insert

```bash
# Import SQL file to your database
mysql -u your_user -p your_database < database/example_user_data_inserts.sql
```

---

## Manual Data Insertion (KISS Way)

If you prefer to insert data manually:

### Step 1: Create Customer Users

```bash
php artisan tinker
```

```php
// Create 5 test customers
$customers = [
    ['nama' => 'Budi Santoso', 'email' => 'budi@example.com', 'phone' => '081234567890'],
    ['nama' => 'Siti Nurhaliza', 'email' => 'siti@example.com', 'phone' => '081345678901'],
    ['nama' => 'Ahmad Rahman', 'email' => 'ahmad@example.com', 'phone' => '081456789012'],
];

foreach ($customers as $data) {
    App\Models\User::create(array_merge($data, [
        'password' => Hash::make('password123'),
        'role' => 'user',
        'status' => 'active',
        'location' => 'Indonesia',
    ]));
    echo "✓ Created: {$data['nama']}\n";
}
```

### Step 2: Link Orders to Services

```php
// Get a customer and service
$customer = User::where('email', 'budi@example.com')->first();
$service = Service::where('status', 'active')->first();

// Create order
$order = Order::create([
    'user_id' => $customer->id,
    'service_id' => $service->id,
    'order_code' => 'KSR-' . date('YmdHis'),
    'customer_name' => $customer->nama,
    'customer_phone' => $customer->phone,
    'customer_email' => $customer->email,
    'alamat_lengkap' => $customer->location,
    'tanggal_order' => now(),
    'total_harga' => $service->harga_mulai,
    'status' => 'completed',
    'payment_status' => 'paid',
]);

echo "✓ Order created: {$order->order_code}\n";
```

---

## Verification Checklist

### 1. Database Connection
```bash
# Test connection
php artisan tinker
> DB::connection()->getPdo()
# Should return PDO object (no error)
```

### 2. Models & Relationships
```bash
php artisan tinker

> $user = User::find(1)
> $user->orders()->count()  # Should return 0 or more

> $service = Service::find(1)
> $service->user->nama      # Should return mitra name

> $order = Order::find(1)
> $order->customer_name     # Should return customer name
> $order->service->nama_layanan  # Should return service name
```

### 3. Test Features (In Browser)

```
1. Browse Services
   URL: http://localhost:8000/user/services
   Expected: List of active services with search/filter

2. Service Detail
   URL: http://localhost:8000/user/services/1
   Expected: Service details + mitra sidebar + "Pesan Sekarang" button

3. Order History
   URL: http://localhost:8000/user/riwayat
   Expected: List of orders for Auth::id() user
   Note: Must login or Auth::id()??1 will use user 1

4. Order Detail
   URL: http://localhost:8000/user/orders/1
   Expected: Order details + customer info + mitra card

5. Create Order
   URL: http://localhost:8000/user/orders/create?service_id=1
   Expected: Redirects to confirmation page
```

---

## Data Flow (Database Connected)

```
User (Customer)
├── Orders (Multiple)
│   ├── Service
│   │   └── User (Mitra)
│   └── Status: pending/completed/cancelled
└── Profile: name, email, phone, address
```

### Example Data Layout

**users** table (customers):
- ID: 1, 2, 3, 4, 5 (customers)
- ID: 101, 102, 103 (mitras from Phase 2)

**services** table:
- user_id: 101, 102, 103 (belongs to mitras)
- status: 'active'

**orders** table:
- user_id: 1, 2, 3 (customers who placed orders)
- service_id: (references services table)
- status: 'pending', 'completed', 'cancelled'

---

## KISS Principle Applied

✅ **Simple**: Direct Eloquent queries, no repositories
✅ **Clear**: Easy to follow data flow
✅ **Testable**: Can verify with `php artisan tinker`
✅ **Minimal**: Only necessary fields, no bloat

---

## Troubleshooting

### "SQLSTATE[HY000]" - Database Connection Error
```bash
# Check .env file
cat .env | grep DB_

# Should match your MySQL credentials
# Verify MySQL is running
sudo systemctl status mysql
```

### "No query results for model" when viewing orders
```
Possible causes:
1. No data inserted yet - run seeder
2. Wrong user ID - check Auth::id() value
3. Order doesn't belong to logged-in user - verify user_id in database
```

### Auth returns null
```bash
# Fallback to user 1:
# Controllers use: Auth::id() ?? session('user_id', 1)
# So if not logged in, uses user 1 instead

# Verify user 1 exists:
php artisan tinker
> User::find(1)->nama
```

---

## Next: Implement User Authentication

For production, implement proper:
- Login/Register for users
- Auth middleware on routes
- Session management
- Password reset

This will replace the fallback `?? 1` with real authenticated users.
