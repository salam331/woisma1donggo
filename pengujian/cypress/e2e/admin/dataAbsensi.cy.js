describe('Pengujian Manajemen Data Absensi - Admin (Black Box)', () => {

  it('Admin berhasil masuk ke halaman rekap absensi dan memastikan data tampil secara valid dan akurat', () => {
    
    const adminCredentials = {
      email: 'admin@sman1donggo.sch.id',
      password: 'password'
    }

    // =====================================================
    // 1. PROSES LOGIN ADMIN
    // =====================================================
    cy.visit('http://127.0.0.1:8000/login')

    cy.get('input[name="email"]', { timeout: 10000 })
      .should('be.visible')
      .type(adminCredentials.email)

    cy.get('input[name="password"]')
      .type(adminCredentials.password)

    cy.get('button[type="submit"]').click()

    // Memastikan berhasil login dan dialihkan dari halaman login
    cy.url().should('not.include', '/login')


    // =====================================================
    // 2. NAVIGASI KE HALAMAN REKAP ABSENSI
    // =====================================================
    // Menuju URL indeks absensi (sesuaikan dengan pattern routing Laravel Anda)
    cy.visit('http://127.0.0.1:8000/admin/attendances')
    
    // Validasi Judul Halaman Utama Absensi
    cy.contains('h2', 'Rekap Kehadiran Siswa Berdasarkan Kelas', { timeout: 10000 })
      .should('be.visible')


    // =====================================================
    // 3. VALIDASI ELEMEN UTAMA (VALIDASI NAVIGASI & TOMBOL)
    // =====================================================
    // Memastikan tombol "Lihat Ringkasan" tersedia dan mengarah ke route yang benar
    cy.contains('a', 'Lihat Ringkasan')
      .should('be.visible')
      .and('have.attr', 'href').and('include', '/attendances/summary')

    // Memastikan tombol "Tambah Kehadiran" tersedia dan mengarah ke route yang benar
    cy.contains('a', 'Tambah Kehadiran')
      .should('be.visible')
      .and('have.attr', 'href').and('include', '/attendances/create')


    // =====================================================
    // 4. VALIDASI STRUKTUR TABEL (AKURASI KOLOM DATA)
    // =====================================================
    // Memastikan seluruh header kolom yang krusial dirender dengan akurat sesuai kode Blade
    const expectedHeaders = [
      'Kelas', 
      'Total Kehadiran', 
      'Hadir', 
      'Tidak Hadir', 
      'Terlambat', 
      'Izin', 
      'Persentase Hadir', 
      'Aksi'
    ]

    expectedHeaders.forEach((headerText) => {
      cy.get('table thead')
        .should('contain.text', headerText)
    })


    // =====================================================
    // 5. VALIDASI KONTEN DATA (KONDISIONAL: ADA DATA / KOSONG)
    // =====================================================
    cy.get('table tbody').then(($tbody) => {
      // Skenario A: Jika tidak ada data ditemukan
      if ($tbody.text().includes('Tidak ada data kelas ditemukan.')) {
        cy.wrap($tbody)
          .contains('td', 'Tidak ada data kelas ditemukan.')
          .should('be.visible')
      } 
      // Skenario B: Jika data absensi kelas tampil (Valid & Akurat)
      else {
        // 1. Memastikan baris tabel terisi data
        cy.get('table tbody tr').should('have.length.greaterThan', 0)

        // 2. Mengambil sampel baris pertama untuk cek format data akurat
        cy.get('table tbody tr').first().within(() => {
          // Memastikan kolom persentase mengandung simbol % (Akurasi Format)
          cy.get('td[data-label="Persentase Hadir"]')
            .should('contain.text', '%')

          // Memastikan tombol aksi 'Lihat' dengan ikon SVG tersedia
          cy.get('td[data-label="Aksi"] a')
            .should('be.visible')
            .and('have.attr', 'href').and('include', '/attendances/class')
        })

        // 3. Menguji Klik Tombol Aksi 'Lihat' pada kelas pertama
        cy.get('table tbody tr').first().find('td[data-label="Aksi"] a').click()
        
        // Memastikan sistem berhasil mengarahkan ke halaman detail absensi kelas tersebut
        cy.url().should('include', '/attendances/class')
      }
    })

  })

})