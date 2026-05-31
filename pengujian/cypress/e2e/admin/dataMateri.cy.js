describe('CRUD Data Materi Pelajaran', () => {
  const randomNumber = Date.now()

  const materialData = {
    title: `Materi Testing ${randomNumber}`,
    updatedTitle: `Materi Update ${randomNumber}`,
    description: 'Deskripsi materi testing Cypress',
    updatedDescription: 'Deskripsi materi berhasil diupdate'
  }

  beforeEach(() => {
    cy.visit('http://127.0.0.1:8000/login')
    cy.get('input[name="email"]').should('be.visible').type('admin@sman1donggo.sch.id')
    cy.get('input[name="password"]').should('be.visible').type('password')
    cy.get('button[type="submit"]').click()
    cy.url().should('not.include', '/login')
  })

  it('Create Data Materi', () => {
    cy.visit('http://127.0.0.1:8000/admin/materials/create')

    cy.get('select[name="teacher_id"]').should('be.visible').select(3)
    cy.get('select[name="class_id"]', { timeout: 10000 }).should('not.be.disabled')
    cy.get('select[name="class_id"]').select(1)
    cy.get('select[name="subject_id"]', { timeout: 10000 }).should('not.be.disabled')
    cy.get('select[name="subject_id"]').select(1)
    cy.get('input[name="title"]').type(materialData.title)
    cy.get('textarea[name="description"]').type(materialData.description)
    cy.get('input[name="file"]').selectFile('cypress/fixtures/materi.pdf', { force: true })
    cy.get('input[id="is_public_yes"]').check({ force: true })

    cy.contains('button', 'Upload Materi').click()
    cy.url().should('include', '/admin/materials')
  })

  it('Read Data Materi', () => {
    cy.visit('http://127.0.0.1:8000/admin/materials')
    cy.get('input[name="search"]').clear().type(materialData.title)
    cy.wait(2000)
    cy.contains('td', materialData.title).should('be.visible')

    cy.contains('tr', materialData.title).within(() => {
      cy.get('a[title="Lihat"]').click({ force: true })
    })

    cy.contains(materialData.title).should('be.visible')
    cy.contains(materialData.description).should('be.visible')
  })

  it('Update Data Materi', () => {
    cy.visit('http://127.0.0.1:8000/admin/materials')
    cy.get('input[name="search"]').clear().type(materialData.title)
    cy.wait(2000)

    cy.contains('tr', materialData.title).within(() => {
      cy.get('a[title="Edit"]').click({ force: true })
    })

    cy.url().should('include', '/edit')
    cy.get('input[name="title"]').clear({ force: true }).type(materialData.updatedTitle, { force: true })
    cy.get('textarea[name="description"]').clear({ force: true }).type(materialData.updatedDescription, { force: true })

    cy.contains('button', 'Simpan Perubahan').click({ force: true })
    cy.url().should('include', '/admin/materials')

    cy.get('input[name="search"]').clear().type(materialData.updatedTitle)
    cy.wait(2000)
    cy.contains('td', materialData.updatedTitle).should('be.visible')
  })

  it('Delete Data Materi', () => {
    cy.visit('http://127.0.0.1:8000/admin/materials')
    cy.get('input[name="search"]').clear().type(materialData.updatedTitle)
    cy.wait(2000)

    cy.on('window:confirm', () => true)

    cy.contains('tr', materialData.updatedTitle).within(() => {
      cy.get('form').submit()
    })

    cy.wait(2000)
    cy.contains('td', materialData.updatedTitle).should('not.exist')
  })
})