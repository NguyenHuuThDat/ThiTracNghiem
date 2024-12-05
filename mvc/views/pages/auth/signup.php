<!-- Page Content -->
<div class="bg-image" style="background-image: url('./public/media/photos/photo14@2x.jpg');">
    <div class="row g-0 justify-content-center bg-black-75">
        <div class="hero-static col-sm-8 col-md-6 col-xl-4 d-flex align-items-center p-2 px-sm-0">
            <!-- Sign Up Block -->
            <div class="block block-transparent block-rounded w-100 mb-0 overflow-hidden">
                <div class="block-content block-content-full px-lg-5 px-xl-6 py-4 py-md-5 py-lg-6 bg-body-extra-light">
                    <!-- Header -->
                    <div class="mb-2 text-center">
                        <a class="link-fx fw-bold fs-1" href="#">
                            <span class="text-dark">OnTest</span><span class="text-primary">VN</span>
                        </a>
                        <p class="text-uppercase fw-bold fs-sm text-muted">Tạo tài khoản mới</p>
                    </div>
                    <!-- END Header -->

                    <!-- Sign Up Form -->
                    <!-- jQuery Validation (.js-validation-signup class is initialized in js/pages/op_auth_signup.min.js which was auto compiled from _js/pages/op_auth_signup.js) -->
                    <!-- For more info and examples you can check out https://github.com/jzaefferer/jquery-validation -->
                    <form class="js-validation-signup" method="POST">
                        <div class="mb-4">
                            <div class="input-group input-group-lg">
                                <input type="text" class="form-control" id="signup-username" name="signup-username" placeholder="Họ và tên">
                                <span class="input-group-text">
                                    <i class="fa fa-user-circle"></i>
                                </span>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="input-group input-group-lg">
                                <input type="email" class="form-control" id="signup-email" name="signup-email" placeholder="Địa chỉ Email">
                                <span class="input-group-text">
                                    <i class="fa fa-envelope-open"></i>
                                </span>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="input-group input-group-lg">
                                <input type="password" class="form-control" id="signup-password" name="signup-password" placeholder="Mật khẩu">
                                <span class="input-group-text">
                                    <i class="fa fa-asterisk"></i>
                                </span>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="input-group input-group-lg">
                                <input type="password" class="form-control" id="signup-password-confirm" name="signup-password-confirm" placeholder="Nhập lại mật khẩu">
                                <span class="input-group-text">
                                    <i class="fa fa-asterisk"></i>
                                </span>
                            </div>
                        </div>
                        
                        <div class="d-sm-flex justify-content-sm-between align-items-sm-center mb-4 bg-body rounded py-2 px-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="signup-terms" name="signup-terms">
                                <label class="form-check-label" for="signup-terms">Tôi đồng ý</label>
                            </div>

                            <div class="fw-semibold fs-sm py-1">
                                <a class="fw-semibold fs-sm" href="#" data-bs-toggle="modal"
                                    data-bs-target="#modal-terms">Điều khoản &amp; Chính sách</a>
                            </div>
                        </div>

                        <div class="text-center mb-4">
                            <button type="submit" class="btn btn-hero btn-primary" id="add-user">
                                <i class="fa fa-fw fa-plus opacity-50 me-1"></i> Tạo tài khoản
                            </button>
                        </div>
                    </form>
                    <!-- END Sign Up Form -->
                </div>
            </div>
        </div>
        <!-- END Sign Up Block -->
    </div>

    <!-- Terms Modal -->
    <div class="modal fade" id="modal-terms" tabindex="-1" role="dialog" aria-labelledby="modal-terms" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-success">
                        <h3 class="block-title">Điều khoản &amp; Chính sách</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                    </div>

                    <div class="block-content">
                        <p style="text-align: justify">
                            <b> 1. Quy định về tài khoản người dùng </b><br>
                            Khi đăng ký sử dụng trang web, người dùng cần cung cấp thông tin chính xác, đầy đủ và cập nhật thường xuyên. 
                            Người dùng có trách nhiệm bảo mật thông tin tài khoản, bao gồm tên đăng nhập và mật khẩu, để đảm bảo rằng 
                            tài khoản không bị truy cập trái phép. Việc chia sẻ tài khoản với người khác là hành vi vi phạm điều khoản 
                            sử dụng, và mọi hành động được thực hiện từ tài khoản của bạn sẽ được coi là do chính bạn thực hiện. 
                            Trong trường hợp phát hiện bất kỳ hành vi bất thường, vi phạm bảo mật hoặc nghi ngờ có người khác sử dụng 
                            trái phép tài khoản của mình, người dùng phải thông báo ngay lập tức cho ban quản trị. Chúng tôi có quyền 
                            tạm ngưng hoặc khóa tài khoản nếu phát hiện hành vi vi phạm hoặc các dấu hiệu sử dụng bất thường.
                        </p>

                        <p style="text-align: justify">
                            <b> 2. Chính sách về nội dung và bản quyền </b><br>
                            Tất cả nội dung trên trang web, bao gồm nhưng không giới hạn ở câu hỏi trắc nghiệm, tài liệu học tập, 
                            giao diện người dùng, và các tính năng hỗ trợ khác, đều thuộc quyền sở hữu của trang web hoặc được cung cấp 
                            bởi các đối tác hợp pháp. Các nội dung này được bảo vệ bởi luật sở hữu trí tuệ, và người dùng không được phép 
                            sao chép, chỉnh sửa, phân phối, hoặc sử dụng cho mục đích thương mại mà không có sự cho phép bằng văn bản 
                            từ ban quản trị. Việc sử dụng nội dung trái phép không chỉ vi phạm điều khoản mà còn có thể dẫn đến hành động 
                            pháp lý. Nếu người dùng phát hiện nội dung có dấu hiệu vi phạm bản quyền hoặc không phù hợp, họ có thể liên hệ 
                            với chúng tôi để xử lý kịp thời, đảm bảo sự minh bạch và bảo vệ quyền lợi của tất cả các bên.
                        </p>
                    </div>

                    <div class="block-content block-content-full text-end bg-body">
                        <button type="button" class="btn btn-sm btn-primary" data-bs-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Terms Modal -->
</div>
<!-- END Page Content -->