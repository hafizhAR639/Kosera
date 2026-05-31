-- USER EXAMPLE DATA INSERT (Fallback SQL)
-- Simple direct SQL inserts for customer users and orders
-- KISS principle: Direct, no stored procedures, easy to verify

-- CUSTOMERS (Users with role='user')
INSERT IGNORE INTO users (nama, email, password, phone, location, role, status, join_date, created_at, updated_at) VALUES
('Budi Santoso', 'budi.santoso@email.com', '$2y$12$n52zAu/ykUW3ysgGKkN3q.7EXF3EaC4qQKqKgS2/K5bENFfDuSmBm', '081234567890', 'Jakarta, Indonesia', 'user', 'active', NOW(), NOW(), NOW()),
('Siti Nurhaliza', 'siti.nurhaliza@email.com', '$2y$12$n52zAu/ykUW3ysgGKkN3q.7EXF3EaC4qQKqKgS2/K5bENFfDuSmBm', '081345678901', 'Surabaya, Indonesia', 'user', 'active', NOW(), NOW(), NOW()),
('Ahmad Rahman', 'ahmad.rahman@email.com', '$2y$12$n52zAu/ykUW3ysgGKkN3q.7EXF3EaC4qQKqKgS2/K5bENFfDuSmBm', '081456789012', 'Bandung, Indonesia', 'user', 'active', NOW(), NOW(), NOW()),
('Dewi Lestari', 'dewi.lestari@email.com', '$2y$12$n52zAu/ykUW3ysgGKkN3q.7EXF3EaC4qQKqKgS2/K5bENFfDuSmBm', '081567890123', 'Medan, Indonesia', 'user', 'active', NOW(), NOW(), NOW()),
('Rudi Hermawan', 'rudi.hermawan@email.com', '$2y$12$n52zAu/ykUW3ysgGKkN3q.7EXF3EaC4qQKqKgS2/K5bENFfDuSmBm', '081678901234', 'Yogyakarta, Indonesia', 'user', 'active', NOW(), NOW(), NOW());

-- ORDERS (Link customers to existing services)
-- Note: Password hash above = 'password123'
-- Service IDs: Get from "SELECT id FROM services WHERE status='active' LIMIT 1"

-- Example orders for Budi Santoso (ID: assumed from insert above)
INSERT INTO orders (user_id, service_id, order_code, customer_name, customer_phone, customer_email, alamat_lengkap, tanggal_order, total_harga, status, payment_status, catatan_customer, created_at, updated_at) 
SELECT 
  u.id, 
  s.id,
  CONCAT('KSR-', DATE_FORMAT(NOW(), '%Y%m%d%H%i%s'), '-', DECLARE @r = FLOOR(RAND() * 900 + 100)),
  'Budi Santoso',
  '081234567890',
  'budi.santoso@email.com',
  'Jakarta, Indonesia, Jalan Contoh No. 42',
  DATE_SUB(NOW(), INTERVAL 5 DAY),
  s.harga_mulai,
  'completed',
  'paid',
  'Pengerjaan sesuai jadwal',
  NOW(),
  NOW()
FROM users u, services s 
WHERE u.email = 'budi.santoso@email.com' AND s.status = 'active' LIMIT 1;

-- Example orders for Siti Nurhaliza
INSERT INTO orders (user_id, service_id, order_code, customer_name, customer_phone, customer_email, alamat_lengkap, tanggal_order, total_harga, status, payment_status, created_at, updated_at) 
SELECT 
  u.id, 
  s.id,
  CONCAT('KSR-', DATE_FORMAT(NOW(), '%Y%m%d%H%i%s'), '-', FLOOR(RAND() * 900 + 100)),
  'Siti Nurhaliza',
  '081345678901',
  'siti.nurhaliza@email.com',
  'Surabaya, Indonesia, Jalan Contoh No. 15',
  DATE_SUB(NOW(), INTERVAL 10 DAY),
  s.harga_mulai,
  'pending',
  'unpaid',
  NOW(),
  NOW()
FROM users u, services s 
WHERE u.email = 'siti.nurhaliza@email.com' AND s.status = 'active' LIMIT 1;

-- VERIFICATION QUERIES
-- Run these to verify data:
-- SELECT COUNT(*) as total_customers FROM users WHERE role='user';
-- SELECT COUNT(*) as total_orders FROM orders WHERE user_id IN (SELECT id FROM users WHERE role='user');
-- SELECT o.id, o.order_code, u.nama, s.nama_layanan, o.status FROM orders o 
--   JOIN users u ON o.user_id = u.id 
--   JOIN services s ON o.service_id = s.id 
--   WHERE u.role='user' 
--   LIMIT 10;
