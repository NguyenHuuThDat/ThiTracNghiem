Dashmix.onLoad((() => class {
    static initValidation() {
        Dashmix.helpers("jq-validation"), jQuery(".js-validation-signup").validate({
            rules: {
                "signup-username": {
                    required: !0,
                    minlength: 3
                },
                "signup-email": {
                    required: !0,
                    emailWithDot: !0
                },
                "signup-password": {
                    required: !0,
                    minlength: 5
                },
                "signup-password-confirm": {
                    required: !0,
                    equalTo: "#signup-password"
                },
                "signup-terms": {
                    required: !0
                }
            },
            messages: {
                "signup-username": {
                    required: "Vui lòng nhập tên người dùng",
                    minlength: "Tên người dùng của bạn phải bao gồm ít nhất 3 ký tự"
                },
                "signup-email": "Vui lòng nhập địa chỉ email hợp lệ",
                "signup-password": {
                    required: "Vui lòng nhập mật khẩu",
                    minlength: "Mật khẩu của bạn phải dài ít nhất 5 ký tự"
                },
                "signup-password-confirm": {
                    required: "Vui lòng nhập mật khẩu",
                    minlength: "Mật khẩu của bạn phải dài ít nhất 5 ký tự",
                    equalTo: "Vui lòng nhập cùng một mật khẩu như trên"
                },
                "signup-terms": "Bạn phải đồng ý với các điều khoản dịch vụ!"
            }
        })
    }
    static init() {
        this.initValidation()
    }
}.init()));


$(".js-validation-signup").submit(function (e) { 
    e.preventDefault();
    if($(".js-validation-signup").valid()) {
        $.ajax({
            type: "post",
            url: "./auth/addUser",
            data: {
                fullname: $('#signup-username').val(),
                email: $('#signup-email').val(),
                password: $('#signup-password').val(),
            },
            dataType: "json",
            success: function (response) {
                if(response) {
                    window.location = "./auth/signin"
                } else {
                    Dashmix.helpers('jq-notify', { type: 'danger', icon: 'fa fa-times me-1', message: "Tạo tài khoản không thành công"});
                }
            }
        });
    }
});
