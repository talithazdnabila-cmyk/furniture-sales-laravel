# Cart Feature Testing Checklist

## ✅ Basic Functionality
- [ ] Load product listing page (no errors)
- [ ] Click "Tambah ke Keranjang" button
- [ ] Verify product added to cart with quantity=1
- [ ] Cart count = 1 item
- [ ] Load product detail page (no errors)
- [ ] Add product with custom quantity (e.g., 3)
- [ ] Verify quantity is correct in DB

## ✅ Checkbox Functionality
- [ ] Open /cart page
- [ ] Checkbox states are persisted (selected=true by default)
- [ ] Click checkbox to deselect individual item
  - [ ] Total price updates immediately
  - [ ] Database "selected" column updates
- [ ] Click "Pilih Semua" checkbox
  - [ ] All item checkboxes become checked
  - [ ] Total price updates
- [ ] Uncheck "Pilih Semua"
  - [ ] All items deselect
  - [ ] Total becomes 0

## ✅ Cart Operations
- [ ] Increment quantity with + button
  - [ ] Quantity updates
  - [ ] Price updates
  - [ ] Selected status remains unchanged
- [ ] Decrement quantity with - button
  - [ ] Quantity updates
  - [ ] Price updates
  - [ ] Minus button disabled when qty=1
- [ ] Delete item
  - [ ] Item removed from view
  - [ ] Total updates
- [ ] Clear cart
  - [ ] All items deleted
  - [ ] Show empty cart message
  - [ ] Can add new items again

## ✅ Edge Cases
- [ ] Add same product twice
  - [ ] Quantity should increase on existing item
  - [ ] Not create duplicate row
- [ ] Add to cart when user is NOT logged in
  - [ ] Redirect to login
- [ ] Access /cart without login
  - [ ] Redirect to login
- [ ] Multiple tabs/windows
  - [ ] Refresh one tab updates cart consistently

## 🐛 Known Issues & Fixes Needed
(To be filled during testing)

---

## Instructions
1. Open browser to http://127.0.0.1:8000
2. Login as test user
3. Run through each test
4. Report any failures or bugs
