describe('Testing Login Guru dan Input Nilai', () => {

  it('Melakukan Login dan Menginput Nilai Siswa', () => {

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

    cy.visit('http://127.0.0.1:8000/guru/grades')
    
    cy.contains('Tambah Nilai')
      .should('be.visible')
      .click()

    cy.url().should('include', '/guru/grades/create')

    cy.get('#class_id').select(3)
    cy.wait(500) 
    
    cy.get('#subject_id').select(1)
    cy.wait(500) 
    
    cy.get('#exam_id').select(2)
    cy.wait(1000) 

    cy.get('input[name^="grades"][name$="[score]"]')
      .should('be.visible')

    cy.get('input[name^="grades"][name$="[score]"]')
      .first()
      .clear() 
      .type('85')
      .trigger('input') 

    cy.get('span[id^="grade-"]')
      .first()
      .should('have.text', 'B')

    cy.get('textarea[name^="grades"][name$="[notes]"]')
      .first()
      .type('Pertahankan prestasimu!')

    cy.contains('button', 'Simpan Nilai').click()

    cy.url().should('include', '/guru/grades')
    
    cy.get('body').should('contain', 'Nilai').and('contain', 'berhasil')
  })

})