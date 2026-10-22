# Urutan Migrasi Database (ERD 12 Tabel)

Ini adalah urutan pembuatan tabel untuk project Sistem Informasi Turnamen Esport.
Urutan ini penting agar tidak terjadi error "Foreign Key Constraint" saat migrate.

1. `users` (Tabel utama, sudah ada dari bawaan Laravel + modif role)
2. `games` (Master data game)
3. `super_admins` (Extension dari users)
4. `penyelenggara` (Extension dari users)
5. `peserta` (Extension dari users)
6. `teams` (Butuh id_game dan id_kapten dari users)
7. `team_members` (Butuh id_tim dan id_user)
8. `tournaments` (Butuh id_penyelenggara dari users dan id_game)
9. `registrations` (Butuh id_turnamen, id_user, id_tim)
10. `payments` (Butuh id_pendaftaran dari registrations)
11. `matches` (Butuh id_turnamen)
12. `aktivitas` (Butuh id_user)