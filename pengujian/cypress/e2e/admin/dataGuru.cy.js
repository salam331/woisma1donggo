describe('CRUD Data Guru', () => {
  const randomNumber = Date.now()

  const teacherData = {
    nip: `${randomNumber}`,
    name: `guru testing ${randomNumber}`,
    updatedName: `guru edit ${randomNumber}`,
    email: `guru${randomNumber}@gmail.com`,
    password: 'password123',
    phone: '081234567890',
    updatedPhone: '089999999999',
    gender: 'male',
    birthDate: '1990-01-01',
    subject: 'Matematika',
    updatedSubject: 'Fisika',
    address: 'Alamat Testing Guru',
    updatedAddress: 'Alamat Guru Sudah Diupdate'
  }

  beforeEach(() => {
    cy.visit('http://127.0.0.1:8000/login')
    cy.get('input[name="email"]').should('be.visible').type('admin@sman1donggo.sch.id')
    cy.get('input[name="password"]').should('be.visible').type('password')
    cy.get('button[type="submit"]').click()
    cy.url().should('not.include', '/login')
  })

  it('Create Data Guru', () => {
    cy.visit('http://127.0.0.1:8000/admin/teachers/create')

    cy.get('#nip').should('be.visible').type(teacherData.nip)
    cy.get('#name').type(teacherData.name)
    cy.get('#email').type(teacherData.email)
    cy.get('#password').type(teacherData.password)
    cy.get('#password_confirmation').type(teacherData.password)
    cy.get('#phone').type(teacherData.phone)
    cy.get('#gender').select(teacherData.gender)
    cy.get('#birth_date').type(teacherData.birthDate)
    cy.get('#subject_specialization').type(teacherData.subject)
    cy.get('#address').type(teacherData.address)
    cy.get('#photo').selectFile('cypress/fixtures/foto.png', { force: true })

    cy.contains('button', 'Simpan Guru').click()
    cy.url().should('include', '/admin/teachers')
  })

  it('Read Data Guru', () => {
    cy.visit('http://127.0.0.1:8000/admin/teachers')
    cy.get('input[name="search"]').clear().type(teacherData.name)
    cy.wait(2000)
    cy.contains('td', teacherData.name).should('be.visible')

    cy.contains('tr', teacherData.name).within(() => {
      cy.get('a').first().click({ force: true })
    })

    cy.contains('Informasi Guru').should('be.visible')
    cy.contains(teacherData.name).should('be.visible')
    cy.contains(teacherData.email).should('be.visible')
    cy.contains(teacherData.phone).should('be.visible')
    cy.contains(teacherData.subject).should('be.visible')
    cy.contains(teacherData.address).should('be.visible')
  })

  it('Update Data Guru', () => {
    cy.visit('http://127.0.0.1:8000/admin/teachers')
    cy.get('input[name="search"]').clear().type(teacherData.name)
    cy.wait(2000)

    cy.contains('tr', teacherData.name).within(() => {
      cy.get('a[href*="/edit"]').click({ force: true })
    })

    cy.url().should('include', '/edit')
    cy.get('#name', { timeout: 10000 }).should('be.visible')

    cy.get('#name').clear().type(teacherData.updatedName)
    cy.get('#phone').clear().type(teacherData.updatedPhone)
    cy.get('#subject_specialization').clear().type(teacherData.updatedSubject)
    cy.get('#address').clear().type(teacherData.updatedAddress)
    cy.get('#photo').selectFile('cypress/fixtures/foto.png', { force: true })

    cy.contains('button', 'Update Guru').click()
    cy.url().should('include', '/admin/teachers')

    cy.get('input[name="search"]').clear().type(teacherData.updatedName)
    cy.wait(2000)
    cy.contains('td', teacherData.updatedName).should('be.visible')
  })

  it('Delete Data Guru', () => {
    cy.visit('http://127.0.0.1:8000/admin/teachers')
    cy.get('input[name="search"]').clear().type(teacherData.updatedName)
    cy.wait(2000)

    cy.on('window:confirm', () => true)

    cy.contains('tr', teacherData.updatedName).within(() => {
      cy.get('form').submit()
    })

    cy.wait(2000)
    cy.contains('td', teacherData.updatedName).should('not.exist')
  })
})