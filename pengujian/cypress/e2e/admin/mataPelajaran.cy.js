describe('CRUD Data Mata Pelajaran', () => {
  const randomNumber = Date.now()

  const subjectData = {
    name: `Mata Pelajaran Testing ${randomNumber}`,
    updatedName: `Mapel Edit ${randomNumber}`,
    code: `MP${randomNumber}`,
    updatedCode: `UP${randomNumber}`,
    description: 'Deskripsi mata pelajaran testing Cypress',
    updatedDescription: 'Deskripsi mata pelajaran berhasil diupdate'
  }

  beforeEach(() => {
    cy.visit('http://127.0.0.1:8000/login')
    cy.get('input[name="email"]').should('be.visible').type('admin@sman1donggo.sch.id')
    cy.get('input[name="password"]').should('be.visible').type('password')
    cy.get('button[type="submit"]').click()
    cy.url().should('not.include', '/login')
  })

  it('Create Data Mata Pelajaran', () => {
    cy.visit('http://127.0.0.1:8000/admin/subjects/create')

    cy.get('input[name="name"]').should('be.visible').type(subjectData.name)
    cy.get('input[name="code"]').should('be.visible').type(subjectData.code)
    cy.get('select[name="teacher_id"]').select(1)
    cy.get('textarea[name="description"]').type(subjectData.description)

    cy.contains('button', 'Simpan Mata Pelajaran').click()
    cy.url().should('include', '/admin/subjects')
  })

  it('Read Data Mata Pelajaran', () => {
    cy.visit('http://127.0.0.1:8000/admin/subjects')
    cy.get('input[name="search"]').clear().type(subjectData.name)
    cy.wait(2000)
    cy.contains('td', subjectData.name).should('be.visible')

    cy.contains('tr', subjectData.name).within(() => {
      cy.get('a').first().click({ force: true })
    })

    cy.contains('Detail Mata Pelajaran').should('be.visible')
    cy.contains(subjectData.name).should('be.visible')
    cy.contains(subjectData.code).should('be.visible')
    cy.contains(subjectData.description).should('be.visible')
  })

  it('Update Data Mata Pelajaran', () => {
    cy.visit('http://127.0.0.1:8000/admin/subjects')
    cy.url().should('include', '/admin/subjects')
    
    cy.get('input[name="search"]').clear().type(subjectData.name)
    cy.wait(2000)

    cy.contains('tr', subjectData.name).within(() => {
      cy.get('a[href*="/edit"]').click({ force: true })
    })

    cy.url().should('include', '/edit')
    cy.get('input[name="name"]', { timeout: 10000 }).should('be.visible')
    
    cy.get('input[name="name"]').clear({ force: true }).type(subjectData.updatedName, { force: true })
    cy.get('input[name="code"]').clear({ force: true }).type(subjectData.updatedCode, { force: true })
    cy.get('textarea[name="description"]').clear({ force: true }).type(subjectData.updatedDescription, { force: true })

    cy.contains('button', 'Update Mata Pelajaran').click({ force: true })
    cy.url().should('include', '/admin/subjects')

    cy.get('input[name="search"]').clear().type(subjectData.updatedName)
    cy.wait(2000)
    cy.contains('td', subjectData.updatedName).should('be.visible')
  })

  it('Delete Data Mata Pelajaran', () => {
    cy.visit('http://127.0.0.1:8000/admin/subjects')
    cy.url().should('include', '/admin/subjects')
    
    cy.get('input[name="search"]').clear().type(subjectData.updatedName)
    cy.wait(2000)

    cy.on('window:confirm', () => true)

    cy.contains('tr', subjectData.updatedName).within(() => {
      cy.get('form').submit()
    })

    cy.wait(2000)
    cy.contains('td', subjectData.updatedName).should('not.exist')
  })
})