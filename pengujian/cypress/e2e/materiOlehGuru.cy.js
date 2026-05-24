describe('Fitur Upload Materi Pembelajaran Guru', () => {

    // Alur Login dijalankan sebelum masuk ke pengujian
    beforeEach(() => {
        // --- NARASI: LOGIN GURU ---
        cy.visit('http://127.0.0.1:8000/login');

        cy.get('input[name="email"]')
            .should('be.visible')
            .type('guru1@gmail.com');

        cy.get('input[name="password"]')
            .should('be.visible')
            .type('guru1123');

        cy.get('button.w-full')
            .should('be.visible')
            .click();

        // Validasi login sukses
        cy.url().should('not.include', '/login');
    });

    it('Guru berhasil mengunggah materi pembelajaran baru hingga tersimpan di sistem', () => {
        
        // Intercept API untuk dropdown Mata Pelajaran yang diload via Fetch API
        cy.intercept('GET', '**/guru/materials/get-subjects-by-class/*').as('getSubjects');

        // --- NARASI: GURU NAVIGASI KE DATA MATERI ---
        // Mengunjungi halaman index materi guru
        cy.visit('http://127.0.0.1:8000/guru/materials'); 
        cy.get('h1').should('contain', 'Materi Pembelajaran');

        
        // --- NARASI: GURU MENAMBAH MATERI ---
        // Klik tombol "Upload Materi"
        cy.contains('Upload Materi').click();
        
        // Validasi masuk ke halaman form
        cy.url().should('include', '/guru/materials/create');
        cy.get('h1').should('contain', 'Upload Materi Pembelajaran');

        // 1. Pilih Kelas (Pilih indeks opsi ke-1 / opsi valid pertama)
        cy.get('#class_id').select(1);

        // Menunggu Dropdown Mapel selesai memuat data dari server
        cy.wait('@getSubjects').its('response.statusCode').should('eq', 200);

        // 2. Pilih Mata Pelajaran (Pilih indeks opsi ke-1)
        cy.get('#subject_id').select(1);

        // 3. Isi Judul Materi (Gunakan timestamp agar judul selalu unik tiap di-test)
        const uniqueTitle = 'Materi Cypress Testing ' + Date.now();
        cy.get('#title').type(uniqueTitle);

        // 4. Isi Deskripsi Materi
        cy.get('#description').type('Ini adalah deskripsi materi otomatis dari pengujian Cypress.');

        // 5. Upload File Materi (Menggunakan file dari folder cypress/fixtures/dummy.pdf)
        // Parameter { force: true } dipakai karena input type="file" di-hide oleh class "sr-only" di Blade Anda
        cy.get('input#file[type="file"]').selectFile('cypress/fixtures/materi.pdf', { force: true });

        // Memastikan UI javascript file info (nama file) muncul setelah diupload
        cy.get('#fileName').should('contain', 'materi.pdf');

        // 6. Pilih Visibilitas (Materi Publik - opsional karena radio ini default-nya checked)
        cy.get('#is_public_yes').check({ force: true });


        // --- NARASI: MATERI TERSIMPAN ---
        // Klik tombol submit "Upload Materi"
        cy.get('button[type="submit"]').contains('Upload Materi').click();


        // --- NARASI: VALID & TERINTEGRASI ---
        
        // 1. Validasi URL kembali ke index
        cy.url().should('include', '/guru/materials');

        // 2. Validasi muncul alert/sesi success warna hijau
        cy.get('.bg-green-100.text-green-700').should('be.visible');

        // 3. Validasi materi yang baru saja diinput benar-benar muncul di daftar card tabel
        cy.contains(uniqueTitle).should('be.visible');
    });

});