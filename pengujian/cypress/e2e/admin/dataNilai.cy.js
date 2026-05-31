describe('Pengujian Manajemen Data Nilai', () => {
  const gradeData = {
    email: 'admin@sman1donggo.sch.id',
    password: 'password',
    classId: '5',
    subjectId: '3',
    examId: '17',
    score: '85',
    gradeLetter: 'B'
  }

  beforeEach(() => {
    cy.visit('http://127.0.0.1:8000/login')
    cy.get('input[name="email"]', { timeout: 10000 }).should('be.visible').type(gradeData.email)
    cy.get('input[name="password"]').type(gradeData.password)
    cy.get('button[type="submit"]').click()
    cy.url().should('not.include', '/login')
  })

  it('Input Data Nilai Baru', () => {
    cy.visit('http://127.0.0.1:8000/admin/grades/create')
    cy.url().should('include', '/admin/grades/create')

    cy.get('#class_id', { timeout: 15000 }).should('be.visible').select(gradeData.classId)
    cy.wait(1000)
    cy.get('#subject_id').should('not.be.disabled').select(gradeData.subjectId)
    cy.wait(1000)
    cy.get('#exam_id').should('exist').select(gradeData.examId)

    cy.get('#students-table-body tr', { timeout: 15000 }).should('have.length.greaterThan', 0)

    cy.get('#students-table-body tr').first().within(() => {
      cy.get('input[type="number"]').clear({ force: true }).type(gradeData.score, { force: true })
      cy.get('textarea').clear({ force: true }).type('Nilai hasil pengujian Cypress', { force: true })
    })

    cy.contains('button', 'Simpan Nilai').click({ force: true })
    cy.url().should('include', '/admin/grades')
    cy.get('body').should('contain.text', 'Nilai Siswa')
    cy.get('body').should('contain.text', 'Nilai berhasil ditambahkan')
  })

  it('Verifikasi Sinkronisasi Data Nilai di Halaman Utama', () => {
    cy.visit('http://127.0.0.1:8000/admin/grades')
    cy.url().should('include', '/admin/grades')

    cy.contains('IPS', { timeout: 10000 }).should('be.visible').click({ force: true })
    cy.contains('Ilmu Pengetahuan Sosial', { timeout: 10000 }).should('be.visible').click({ force: true })
    cy.contains('ujian ips', { timeout: 10000 }).should('be.visible').click({ force: true })

    cy.get('div, table', { timeout: 15000 }).should('exist')
    cy.get('body').should('contain.text', gradeData.score)
    cy.get('body').should('not.contain.text', 'Belum ada nilai')
  })
})