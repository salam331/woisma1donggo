# TODO: Membuat Navbar dan Sidebar Admin Fixed Saat Content Scroll (Pertahankan Efek Collapse)

## Informasi Gathered (Ringkasan Pemahaman File):
- `app.blade.php`: Layout flex sidebar + navbar + main scrollable.
- `sidebar-admin.blade.php`: Alpine `{ open: true }`, width w-64/w-16, h-screen, toggle button.
- `navbar-admin.blade.php`: Navbar relative dengan Alpine mobile menu & profile dropdown.

## Plan Breakdown:
- [x] **Step 1**: Edit `resources/views/layouts/app.blade.php` ✅ Struktur fixed layout, Alpine store, main dynamic ml/mt.
  - Tambah Alpine store global `sidebar`.
  - Ubah struktur ke fixed: sidebar fixed kiri, navbar fixed atas, main ml-dynamic mt-navbar-height overflow-auto.
  - Body `overflow-hidden h-screen`.
- [x] **Step 2**: Edit `resources/views/components/sidebar-admin.blade.php` ✅ Fixed positioning, x-data store sync, toggle update. x-show="open" tetap work via store proxy.
  - Ganti `x-data="{ open: true }"` ke `x-data="$store.sidebar"`.
  - Tambah `fixed inset-y-0 left-0 z-40`.
  - Update toggle `@click="$store.sidebar.open = !$store.sidebar.open"`.
- [x] **Step 3**: Verifikasi `resources/views/components/navbar-admin.blade.php` ✅ Tidak perlu edit. Navbar di-wrap fixed h-20 z-50, kompatibel (relative ok di fixed parent, mobile menu absolute relatif parent).
- [x] **Step 4**: Test ✅ Navbar & sidebar fixed saat scroll content (main overflow-y-auto). Efek collapse/expand tetap jalan (toggle width, main ml adjust dynamic via $store.sidebar.open). Kompatibel dark mode, responsive (mobile menu navbar terpisah).
- [x] **Step 5**: Selesai ✅ Perubahan global apply ke semua halaman admin (dashboard, invoices, users, dll.).

**Dependent Files**: Hanya 3 file utama. Global apply ke semua admin pages.

**Followup**: Jika ada issue responsive/dark mode, adjust Tailwind classes.
