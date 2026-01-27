# TODO: Convert All Notifications to Toast Format

## Step 1: Update AppServiceProvider.php
- [x] Add macro to convert session('success') and session('error') to toast format

## Step 2: Update layouts/app.blade.php
- [x] Include <x-toast /> component in the main layout

## Step 3: Create Middleware
- [x] Create ConvertSessionToToast middleware
- [x] Register middleware in bootstrap/app.php

## Step 4: Remove Inline Alerts from Views
### Admin Views
- [x] admin/users/show.blade.php - remove success alert
- [x] admin/materials/show.blade.php - remove success alert
- [x] admin/materials/index.blade.php - remove error alert (already commented)
- [x] admin/materials/edit.blade.php - remove success/error alerts
- [x] admin/materials/create.blade.php - remove success/error alerts
- [x] admin/grades/subject.blade.php - remove success alert
- [x] admin/grades/student.blade.php - remove success alert
- [x] admin/grades/index.blade.php - remove success alert
- [x] admin/grades/exam.blade.php - remove success alert
- [x] admin/grades/edit-exam.blade.php - remove success alert
- [x] admin/grades/class.blade.php - remove success alert
- [x] admin/exams/index.blade.php - remove success alert
- [x] admin/contact-messages/index.blade.php - remove success alert

### Guru Views
- [x] guru/subjects/show_fixed.blade.php - remove success/error alerts
- [x] guru/subjects/show.blade.php - remove success/error alerts
- [x] guru/materials/index.blade.php - remove success/error alerts
- [x] guru/materials/edit.blade.php - remove success/error alerts
- [x] guru/materials/create.blade.php - remove success/error alerts
- [x] guru/materials/show.blade.php - remove session alerts
- [x] guru/grades/subject.blade.php - remove success/error alerts
- [x] guru/grades/student.blade.php - remove success/error alerts
- [x] guru/grades/index.blade.php - remove success/error alerts
- [x] guru/grades/exam.blade.php - remove success/error alerts
- [x] guru/grades/edit.blade.php - remove success/error alerts
- [x] guru/grades/class.blade.php - remove success/error alerts
- [x] guru/exams/show.blade.php - remove success/error alerts
- [x] guru/exams/index.blade.php - remove success/error alerts
- [x] guru/classes/students.blade.php - remove success/error alerts
- [x] guru/classes/show.blade.php - remove success/error alerts
- [x] guru/classes/index.blade.php - remove success/error alerts
- [x] guru/announcements/index.blade.php - remove success/error alerts

### Profile Views
- [x] profile/partials/update-profile-information-form.blade.php - remove status alerts
- [x] profile/partials/update-password-form.blade.php - remove status alerts

### Other Views
- [x] contact.blade.php - remove success alert

## Step 5: Test the implementation
- [ ] Verify toast notifications work on all pages
- [ ] Verify no duplicate notifications appear

