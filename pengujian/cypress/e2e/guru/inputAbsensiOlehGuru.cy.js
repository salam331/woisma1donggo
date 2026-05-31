describe('Fitur Absensi Guru', () => {
  const today = new Date().toISOString().split('T')[0]

  beforeEach(() => {
    cy.visit('http://127.0.0.1:8000/login')

    cy.get('input[name="email"]').should('be.visible').type('guru1@gmail.com')
    cy.get('input[name="password"]').should('be.visible').type('guru1123')
    cy.get('button.w-full').should('be.visible').click()

    cy.url().should('not.include', '/login')
    cy.contains('Dashboard').should('be.visible')
  })

  it('Mengisi Form dan Memuat Data Siswa', () => {
    cy.intercept('GET', '**/guru/classes/*/students/json').as('getStudents')

    cy.visit('http://127.0.0.1:8000/guru/attendances/create')

    cy.get('h2').should('contain', 'Tambah Kehadiran Siswa - Kelas yang Anda Ajar')
    cy.get('#attendanceForm').should('exist')

    cy.get('#class_id').select(3)
    cy.get('#scheduleSection').should('be.visible')

    cy.get('#schedule_id').select(1)
    cy.get('#dateSection').should('be.visible')

    cy.get('#date').clear().type(today).trigger('change')

    cy.wait('@getStudents').its('response.statusCode').should('eq', 200)
    cy.wait(500)

    cy.get('#studentList').should('be.visible')
    cy.get('#studentTableBody').find('tr').should('have.length.of.at.least', 1)
  })

  it('Mengisi Status Absensi dan Catatan Siswa', () => {
    cy.intercept('GET', '**/guru/classes/*/students/json').as('getStudents')
    cy.visit('http://127.0.0.1:8000/guru/attendances/create')
    cy.get('#class_id').select(3)
    cy.get('#schedule_id').select(1)
    cy.get('#date').clear().type(today).trigger('change')
    cy.wait('@getStudents')

    cy.get('#studentTableBody tr').each(($row) => {
      cy.wrap($row).within(() => {
        cy.get('td').eq(0).should('not.be.empty')
        cy.get('td').eq(1).should('not.be.empty')
        cy.get('select[name*="[status]"]').select('present')
      })
    })

    cy.get('#studentTableBody tr').first().within(() => {
      cy.get('textarea[name*="[notes]"]').type('Siswa pertama hadir tepat waktu.', { force: true })
    })

    cy.get('#studentTableBody [name="attendances[3][status]"]').select('present')
    cy.get('#studentTableBody [name="attendances[4][status]"]').select('present')
    cy.get('#studentTableBody [name="attendances[4][notes]"]').click({ force: true })
    cy.get('#studentTableBody [name="attendances[4][notes]"]').type('hadir kok', { force: true })
  })

  it('Menyimpan Data Absensi Berhasil', () => {
    cy.intercept('GET', '**/guru/classes/*/students/json').as('getStudents')
    cy.visit('http://127.0.0.1:8000/guru/attendances/create')
    cy.get('#class_id').select(3)
    cy.get('#schedule_id').select(1)
    cy.get('#date').clear().type(today).trigger('change')
    cy.wait('@getStudents')

    cy.get('#studentTableBody [name="attendances[3][status]"]').select('present')
    cy.get('#studentTableBody [name="attendances[4][status]"]').select('present')

    cy.get('#submitSection').should('be.visible')
    cy.get('#submitSection button[type="submit"]').click({ force: true })

    cy.url().should('include', '/guru/attendances')
  })
})