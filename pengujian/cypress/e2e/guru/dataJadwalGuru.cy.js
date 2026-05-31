describe('Testing Dashboard dan Navigasi Guru', () => {
  beforeEach(() => {
    cy.visit('http://127.0.0.1:8000/login')
    cy.get('input[name="email"]').should('be.visible').type('guru1@gmail.com')
    cy.get('input[name="password"]').should('be.visible').type('guru1123')
    cy.get('button.w-full').should('be.visible').click()
    cy.url().should('not.include', '/login')
  })

  it('Verifikasi Dashboard Guru', () => {
    cy.contains('Dashboard').should('be.visible')
  })

  it('Navigasi ke Halaman Jadwal Pelajaran', () => {
    cy.contains('span', 'Jadwal Pelajaran').should('be.visible').click({ force: true })
    cy.url().should('include', '/guru/schedules')
  })
})