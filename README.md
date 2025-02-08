# Đồ án Phát triển Phần mềm Hướng dịch vụ

### Hướng dẫn cài đặt
- Cài đặt XAMPP >= 8.0.25, Composer (mặc định là phiên bản mới nhất)
- Tạo 1 database mới trên phpmyadmin có tên là " thitracnghiem ", sau đó nhập database vào
- Cấu hình thông tin database và đường dẫn trang chủ tại file config.php
- Cài đặt thư viện cần thiết: mở terminal nhập " composer install "
- Thông tin chi tiết các chức năng vui lòng liên hệ trực tiếp

### Tài khoản Admin
- Username: 3121410422
- Password: 123456

### Tài khoản Giảng Viên
- Username: 111111
- Password: 123456

### Tài khoản Sinh Viên
- Username: 2155010067
- Password: 123456

### Chức năng
1. Landing page giới thiệu hệ thống.
2. Đăng nhập, đăng xuất.
3. Đăng nhập sử dụng cơ chế lưu token .
4. Đăng nhập sử dụng tài khoản Google (trường hợp đã liên kết với tài khoản Google).
5. Cho phép sinh viên cập nhật hồ sơ.
6. Thêm, xóa, chỉnh sửa câu hỏi, môn học, chương, đề thi, nhóm học phần, phân công giảng dạy, nhóm quyền, thông báo, người dùng.
7. Tìm kiếm, phân trang sử dụng Ajax.
8. Phân quyền linh động trong hệ thống.
9. Phân công giảng dạy (những giảng viên được phân công dạy môn học nào thì chỉ được tạo nhóm học phần, thêm câu hỏi ở những môn đó).
10. Đọc câu hỏi ở file word và import lên hệ thống (cấu trúc file word tự quy định).
11. Import danh sách sinh viên vào hệ thống.
12. Sinh viên tham gia nhóm học phần bằng mã mời.
13. In kết quả bài làm khi sinh viên thi xong (in 1 sinh viên / in toàn bộ nhóm).
14. Xuất báo cáo kết quả thi tất cả các bài kiểm tra.
15. Đề kiểm tra có 2 dạng
a. Đề thi thủ công (Giảng viên tự chọn từng câu hỏi), cho phép cấu hình đảo câu hỏi, đảo câu trả lời.
b. Đề thi tự động (Giảng viên chỉ cần nhập số lượng câu hỏi ở từng mức độ, chương và hệ thống sẽ tự động ra đề, mỗi sinh viên sẽ có một đề khác nhau)
16. Phát hiện sinh viên chuyển tab khi kiểm tra và ghi nhận lại số lần thoát tab.
17. Giới hạn thời gian bắt đầu và thời gian kết thúc đề thi.
18. Tự động nộp bài khi sinh viên chuyển tab.
19. Lưu lại các đáp án sinh viên đã chọn khi ấn nhầm tắt trình duyệt.
20. Sinh viên có thể xem lại bài thi của mình (khi cấu hình đề thi cho phép xem).
21. Thống kê điểm số của sinh viên tham gia đề thi.
22. Lọc sinh viên đã tham gia, chưa tham gia thi hoặc đã thi xong.
23. Sắp xếp theo tên, điểm số của sinh viên ở từng đề kiểm tra.