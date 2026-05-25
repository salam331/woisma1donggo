describe('Testing Login Guru dan Input Nilai', () => {

  it('Melakukan Login dan Menginput Nilai Siswa', () => {

    // 1. PROSES LOGIN (Kode Anda)
    cy.visit('http://127.0.0.1:8000/login')

    cy.get('input[name="email"]')
      .should('be.visible')
      .type('guru1@gmail.com')

    cy.get('input[name="password"]')
      .should('be.visible')
      .type('guru1123')

    cy.get('button.w-full')
      .should('be.visible')
      .click()

    cy.url()
      .should('not.include', '/login')

    cy.contains('Dashboard')
      .should('be.visible')

    // ==========================================
    // 2. PROSES INPUT NILAI
    // ==========================================

    // Menuju ke halaman index nilai guru
    cy.visit('http://127.0.0.1:8000/guru/grades')
    
    // Klik tombol Tambah Nilai
    cy.contains('Tambah Nilai')
      .should('be.visible')
      .click()

    // Memastikan sudah berada di halaman create
    cy.url().should('include', '/guru/grades/create')

    // Memilih Kelas
    cy.get('#class_id').select(3)
    cy.wait(500) // Beri waktu AJAX memuat Mata Pelajaran
    
    // Memilih Mata Pelajaran
    cy.get('#subject_id').select(1)
    cy.wait(500) // Beri waktu AJAX memuat Ujian
    
    // Memilih Ujian
    cy.get('#exam_id').select(2)
    cy.wait(1000) // Beri waktu ekstra bagi AJAX untuk merender tabel seluruh siswa

    // Memastikan input nilai sudah muncul di layar
    cy.get('input[name^="grades"][name$="[score]"]')
      .should('be.visible')

    // Mengisi nilai untuk siswa pertama di tabel DAN memicu event input
    cy.get('input[name^="grades"][name$="[score]"]')
      .first()
      .clear() // Bersihkan input terlebih dahulu jika ada data bawaan
      .type('85')
      .trigger('input') // <-- Solusi Utama: Memaksa oninput="updateGradeLetter()" berjalan

    // Memastikan fungsi JavaScript huruf grade (A/B/C/D) bekerja (85 = B)
    cy.get('span[id^="grade-"]')
      .first()
      .should('have.text', 'B')

    // Mengisi catatan untuk siswa pertama
    cy.get('textarea[name^="grades"][name$="[notes]"]')
      .first()
      .type('Pertahankan prestasimu!')

    // Klik tombol Simpan Nilai
    cy.contains('button', 'Simpan Nilai').click()

    // Verifikasi dialihkan kembali ke index dan mendapat pesan sukses
    cy.url().should('include', '/guru/grades')
    
    // Memastikan alert success muncul (bisa disesuaikan selector class-nya jika tidak pakai .bg-green-100)
    cy.get('body').should('contain', 'Nilai').and('contain', 'berhasil')
  })

})