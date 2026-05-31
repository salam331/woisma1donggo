describe('CRUD Data Kelas', () => {
  const randomNumber = Date.now()

  const classData = {
    name: `Kelas Testing ${randomNumber}`,
    updatedName: `Kelas Edit ${randomNumber}`,
    gradeLevel: 'Kelas 10',
    updatedGradeLevel: 'Kelas 11',
    description: 'Deskripsi kelas testing Cypress',
    updatedDescription: 'Deskripsi kelas berhasil diupdate'
  }

  beforeEach(() => {
    cy.visit('http://127.0.0.1:8000/login')
    cy.get('input[name="email"]').should('be.visible').type('admin@sman1donggo.sch.id')
    cy.get('input[name="password"]').should('be.visible').type('password')
    cy.get('button[type="submit"]').click()
    cy.url().should('not.include', '/login')
  })

  it('Create Data Kelas', () => {
    cy.visit('http://127.0.0.1:8000/admin/classes/create')

    cy.get('input[name="name"]').should('be.visible').type(classData.name)
    cy.get('select[name="grade_level"]').select(classData.gradeLevel)
    cy.get('select[name="teacher_id"]').select(1)
    cy.get('textarea[name="description"]').type(classData.description)

    cy.contains('button', 'Simpan Kelas').click()
    cy.url().should('include', '/admin/classes')
  })

  it('Read Data Kelas', () => {
    cy.visit('http://127.0.0.1:8000/admin/classes')
    cy.get('input[name="search"]').clear().type(classData.name)
    cy.wait(2000)
    cy.contains('td', classData.name).should('be.visible')

    cy.contains('tr', classData.name).within(() => {
      cy.get('a').first().click({ force: true })
    })

    cy.contains('Detail Kelas').should('be.visible')
    cy.contains(classData.name).should('be.visible')
    cy.contains(classData.gradeLevel).should('be.visible')
    cy.contains(classData.description).should('be.visible')
  })

  it('Update Data Kelas', () => {
    cy.visit('http://127.0.0.1:8000/admin/classes')
    cy.get('input[name="search"]').clear().type(classData.name)
    cy.wait(2000)

    cy.contains('tr', classData.name).within(() => {
      cy.get('a[href*="/edit"]').click({ force: true })
    })

    cy.url().should('include', '/edit')
    cy.get('input[name="name"]', { timeout: 10000 }).should('be.visible').clear().type(classData.updatedName)
    .clear({ force: true }) 
    .type(classData.updatedName, { force: true }) 
    cy.get('select[name="grade_level"]').select(classData.updatedGradeLevel)
    cy.get('textarea[name="description"]').clear().type(classData.updatedDescription)

    cy.contains('button', 'Update Kelas').click()
    cy.url().should('include', '/admin/classes')

    cy.get('input[name="search"]').clear().type(classData.updatedName)
    cy.wait(2000)
    cy.contains('td', classData.updatedName).should('be.visible')
  })

  it('Delete Data Kelas', () => {
    cy.visit('http://127.0.0.1:8000/admin/classes')
    cy.get('input[name="search"]').clear().type(classData.updatedName)
    cy.wait(2000)

    cy.on('window:confirm', () => true)

    cy.contains('tr', classData.updatedName).within(() => {
      cy.get('form').submit()
    })

    cy.wait(2000)
    cy.contains('td', classData.updatedName).should('not.exist')
  })
})