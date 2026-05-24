describe('Pengujian Manajemen Data Nilai - Admin (Black Box)', () => {

  it('Admin berhasil menginput nilai dan memastikan data langsung sinkron di halaman utama', () => {

    const gradeData = {
      email: 'admin@sman1donggo.sch.id',
      password: 'password',

      classId: '5',
      subjectId: '3',
      examId: '17',

      score: '85',
      gradeLetter: 'B'
    }

    // =====================================================
    // 1. LOGIN
    // =====================================================
    cy.visit('http://127.0.0.1:8000/login')

    cy.get('input[name="email"]', { timeout: 10000 })
      .should('be.visible')
      .type(gradeData.email)

    cy.get('input[name="password"]')
      .type(gradeData.password)

    cy.get('button[type="submit"]').click()

    cy.url().should('not.include', '/login')


    // =====================================================
    // 2. MASUK HALAMAN CREATE & INPUT NILAI SISWA
    // =====================================================
    cy.visit('http://127.0.0.1:8000/admin/grades/create')

    cy.url().should('include', '/admin/grades/create')

    cy.get('#class_id', { timeout: 15000 })
      .should('be.visible')
      .select(gradeData.classId)

    // Tunggu AJAX subject & student load
    cy.wait(1000)

    cy.get('#subject_id')
      .should('not.be.disabled')
      .select(gradeData.subjectId)

    cy.wait(1000)

    cy.get('#exam_id')
      .should('exist')
      .select(gradeData.examId)

    // Input nilai pada baris pertama tabel siswa
    cy.get('#students-table-body tr', { timeout: 15000 })
      .should('have.length.greaterThan', 0)

    cy.get('#students-table-body tr')
      .first()
      .within(() => {
        cy.get('input[type="number"]')
          .type(gradeData.score)

        cy.get('textarea')
          .type('Nilai hasil pengujian Cypress')
      })


    // =====================================================
    // 3. SUBMIT / SIMPAN DATA
    // =====================================================
    cy.contains('button', 'Simpan Nilai')
      .click()

// =====================================================
    // 4. VALIDASI SINKRONISASI DATA DI HALAMAN INDEX
    // =====================================================
    // Memastikan diarahkan kembali ke halaman index nilai
    cy.url().should('include', '/admin/grades')

    // Cek teks "Nilai Siswa" dan pesan sukses muncul
    cy.get('body').should('contain.text', 'Nilai Siswa')
    cy.get('body').should('contain.text', 'Nilai berhasil ditambahkan')

    // --- PERBAIKAN DI SINI ---
    // Klik nama kelas terlebih dahulu untuk melihat daftar nilainya.
    // (Silakan ganti 'X IPA 1' dengan nama kelas yang sesuai dengan classId: '5')
    cy.contains('IPS', { timeout: 10000 })
      .should('be.visible')
      .click()
    // --------------------------

    cy.contains('Ilmu Pengetahuan Sosial', { timeout: 10000 })
      .should('be.visible')
      .click()

    cy.contains('ujian ips', { timeout: 10000 })
      .should('be.visible')
      .click()

    // Memastikan komponen tabel/div data siswa sudah muncul setelah kelas diklik
    cy.get('div, table', { timeout: 15000 })
      .should('exist')

    // Sekarang baru cek apakah nilai '85' yang baru diinput benar-benar muncul
    cy.get('body')
      .should('contain.text', gradeData.score)

    // Memastikan tidak ada teks tulisan "Belum ada nilai"
    cy.get('body')
      .should('not.contain.text', 'Belum ada nilai')

  })

})