describe('Fitur Absensi Guru - End to End', () => {
    
    // Alur Login dijalankan sebelum masuk ke pengujian absensi
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
        cy.contains('Dashboard').should('be.visible');
    });

    it('Guru berhasil menginput data absensi siswa hingga tersimpan', () => {
        // Intercept untuk mengamankan masalah timing load data siswa via AJAX
        cy.intercept('GET', '**/guru/classes/*/students/json').as('getStudents');
        
        // --- NARASI: GURU NAVIGASI KE HALAMAN TAMBAH ABSENSI ---
        cy.visit('http://127.0.0.1:8000/guru/attendances/create'); 
        
        // Memastikan elemen utama form tambah absensi sudah tampil
        cy.get('h2').should('contain', 'Tambah Kehadiran Siswa - Kelas yang Anda Ajar');
        cy.get('#attendanceForm').should('exist');
        
        
        // --- NARASI: GURU MENGINPUT PARAMETER ABSENSI ---
        
        // Step 1: Pilih Kelas
        cy.get('#class_id').select(3); 
        
        // Validasi: Section Jadwal otomatis muncul setelah Kelas dipilih
        cy.get('#scheduleSection').should('be.visible');
        
        // Step 2: Pilih Jadwal Mengajar
        cy.get('#schedule_id').select(1);
        
        // Validasi: Section Tanggal otomatis muncul setelah Jadwal dipilih
        cy.get('#dateSection').should('be.visible');
        
        // Step 3: Isi Tanggal Absensi
        const today = new Date().toISOString().split('T')[0];
        cy.get('#date').clear().type(today).trigger('change');
        
        
        // --- NARASI: VALIDASI DATA SISWA (MENUNGGU API SELESAI) ---
        
        // Menunggu respons API selesai (Status 200) agar HTML tidak berubah saat diisi Cypress
        cy.wait('@getStudents').its('response.statusCode').should('eq', 200);
        cy.wait(500); // Jeda penstabil DOM browser
        
        // Memastikan daftar siswa muncul di tabel setelah tanggal dipilih
        cy.get('#studentList').should('be.visible');
        cy.get('#studentTableBody').find('tr').should('have.length.of.at.least', 1);
        
        
        // --- NARASI: GURU MENGISI ABSENSI UNTUK SEMUA SISWA ---
        
        // Loop otomatis ke setiap baris siswa yang ada di dalam tabel body
        cy.get('#studentTableBody tr').each(($row) => {
            cy.wrap($row).within(() => {
                // Memastikan kolom NIS dan Nama tidak kosong sebelum diisi
                cy.get('td').eq(0).should('not.be.empty'); 
                cy.get('td').eq(1).should('not.be.empty');
        
                // Pilih Status Kehadiran: "Hadir" (value="present") pada semua siswa
                cy.get('select[name*="[status]"]').select('present');
            });
        });
        
        // Memberikan catatan khusus hanya pada siswa pertama (indeks 0)
        cy.get('#studentTableBody tr').first().within(() => {
            cy.get('textarea[name*="[notes]"]').type('Siswa pertama hadir tepat waktu.', { force: true });
        });
        
        
        // --- NARASI: ABSENSI TERSIMPAN / INPUT BERHASIL ---
        
        // Memastikan tombol submit kini telah muncul
        cy.get('#submitSection').should('be.visible');
        
        // Klik tombol "Simpan Kehadiran"
        cy.get('#submitSection button[type="submit"]').click();
        
        // Validasi Akhir: Pastikan halaman berhasil beralih kembali ke index absensi
        cy.url().should('include', '/guru/attendances'); 
        cy.get('#studentTableBody [name="attendances[3][status]"]').select('present');
        cy.get('#studentTableBody [name="attendances[4][status]"]').select('present');
        cy.get('#studentTableBody [name="attendances[4][notes]"]').click();
        cy.get('#studentTableBody [name="attendances[4][notes]"]').type('hadir kok');
        cy.get('#submitSection button.rounded').click();
    });

});