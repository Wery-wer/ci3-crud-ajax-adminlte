USE crud_ajax;

DESCRIBE users;

ALTER TABLE users 
ADD COLUMN updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;

DESCRIBE users;

UPDATE users SET updated_at = CURRENT_TIMESTAMP WHERE updated_at IS NULL;

SELECT 'Kolom updated_at berhasil ditambahkan!' as status;
