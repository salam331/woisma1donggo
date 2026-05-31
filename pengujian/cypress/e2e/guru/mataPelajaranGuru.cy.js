describe('Testing Dashboard dan Mata Pelajaran Guru', () => {

  beforeEach(() => {
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

    cy.url().should('not.include', '/login')
  })

  it('Menampilkan Halaman Dashboard Guru', () => {
    cy.contains('Dashboard').should('be.visible')
  })

  it('Mengakses halaman Daftar Mata Pelajaran dan melihat Detail', () => {
    cy.visit('http://127.0.0.1:8000/guru/subjects') 

    cy.contains('Mata Pelajaran').should('be.visible')

    cy.contains('Lihat Detail')
      .should('be.visible')
      .first()
      .click()

    cy.contains('Detail Mata Pelajaran').should('be.visible')
  })
})