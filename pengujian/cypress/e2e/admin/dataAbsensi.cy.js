describe('Pengujian Manajemen Data Absensi', () => {
  const adminCredentials = {
    email: 'admin@sman1donggo.sch.id',
    password: 'password'
  }

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

  beforeEach(() => {
    cy.visit('http://127.0.0.1:8000/login')
    cy.get('input[name="email"]', { timeout: 10000 }).should('be.visible').type(adminCredentials.email)
    cy.get('input[name="password"]').type(adminCredentials.password)
    cy.get('button[type="submit"]').click()
    cy.url().should('not.include', '/login')
  })

  it('Verifikasi Elemen Halaman Utama Absensi', () => {
    cy.visit('http://127.0.0.1:8000/admin/attendances')
    
    cy.contains('h2', 'Rekap Kehadiran Siswa Berdasarkan Kelas', { timeout: 10000 }).should('be.visible')
    cy.contains('a', 'Lihat Ringkasan').should('be.visible').and('have.attr', 'href').and('include', '/attendances/summary')
    cy.contains('a', 'Tambah Kehadiran').should('be.visible').and('have.attr', 'href').and('include', '/attendances/create')

    expectedHeaders.forEach((headerText) => {
      cy.get('table thead').should('contain.text', headerText)
    })
  })

  it('Verifikasi Data Tabel dan Navigasi Detail Absensi', () => {
    cy.visit('http://127.0.0.1:8000/admin/attendances')

    cy.get('table tbody').then(($tbody) => {
      if ($tbody.text().includes('Tidak ada data kelas ditemukan.')) {
        cy.wrap($tbody).contains('td', 'Tidak ada data kelas ditemukan.').should('be.visible')
      } else {
        cy.get('table tbody tr').should('have.length.greaterThan', 0)

        cy.get('table tbody tr').eq(3).within(() => {
          cy.get('td[data-label="Persentase Hadir"]').should('contain.text', '%')
          cy.get('td[data-label="Aksi"] a').should('be.visible').and('have.attr', 'href').and('include', '/attendances/class')
        })
        
        cy.get('table tbody tr').eq(3).find('td[data-label="Aksi"] a').click({ force: true })
        cy.url().should('include', '/attendances/class')
      }
    })
  })
})