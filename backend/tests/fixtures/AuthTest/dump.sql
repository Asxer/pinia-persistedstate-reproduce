INSERT INTO roles(id, name, created_at, updated_at) VALUES
  (1, 'administrator', '2016-10-20 11:05:00', '2016-10-20 11:05:00'),
  (2, 'user', '2016-10-20 11:05:00', '2016-10-20 11:05:00');

INSERT INTO users(id, name, email, password, remember_token, reset_password_hash, role_id, created_at, updated_at) VALUES
  (1, 'Admin', 'admin@admin.com', '$2y$10$sYDGzjfmtrr5E0CAA.raIOSkRRYr.qsuVwoXuBl7kjS2gqO3gKenS', null, null, 1, '2016-10-20 11:05:00', '2016-10-20 11:05:00'),
  (2, 'User', 'user@user.com', 'old_password', null, 'restore_token', 2, '2016-10-20 11:05:00', '2016-10-20 11:05:00');