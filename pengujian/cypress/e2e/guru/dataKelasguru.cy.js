describe('Testing Login Guru dan Navigasi Menu', () => {
  beforeEach(() => {
    cy.visit('http://127.0.0.1:8000/login')
    cy.get('input[name="email"]').should('be.visible').type('guru1@gmail.com')
    cy.get('input[name="password"]').should('be.visible').type('guru1123')
    cy.get('button.w-full').should('be.visible').click()
    cy.url().should('not.include', '/login')
  })

  it('Verifikasi Halaman Dashboard Guru', () => {
    cy.contains('Dashboard').should('be.visible')
  })

  it('Navigasi dan Verifikasi Menu Daftar Kelas', () => {
    cy.contains('Kelas').should('be.visible').click()
    cy.url().should('include', '/guru/classes')
    cy.contains('Kelas').should('have.class', 'text-blue-600')
  })
})