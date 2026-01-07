# Plan: Update Admin Materials Pages

## Task Summary
Adjust admin materials pages to match guru materials pages style.

## Changes:

### 1. resources/views/admin/materials/index.blade.php
- [x] Keep table layout
- [x] Add "Status" column (Public/Private badge)
- [x] Add "Kelas" column
- [x] Enhance styling to match guru design

### 2. resources/views/admin/materials/create.blade.php
- [x] Add better header with icons
- [x] Add drag-drop file upload area with preview
- [x] Add visibility settings (Public/Private)
- [x] Add class selection dropdown
- [x] Enhance form styling

### 3. resources/views/admin/materials/edit.blade.php
- [x] Add current file information section
- [x] Add drag-drop file upload area
- [x] Add file preview functionality
- [x] Add visibility settings (Public/Private)
- [x] Enhance form styling

### 4. resources/views/admin/materials/show.blade.php
- [x] Add better header with icons
- [x] Add 2-column layout (details left, actions right)
- [x] Add visibility badge
- [x] Add statistics section
- [x] Enhance action buttons styling

## Status: ALL TASKS COMPLETED ✓

---

## Additional Fix Applied

### Fix: Private materials not hidden from student page

**Changes made to app/Http/Controllers/Student/MaterialController.php:**

1. **index() method:**
   - Added `->where('is_public', true)` to filter out private materials from the student view

2. **download() method:**
   - Added check to prevent students from downloading private materials (returns 403)

**Result:** Students can now only see and download public materials. Private materials are hidden from their view.

