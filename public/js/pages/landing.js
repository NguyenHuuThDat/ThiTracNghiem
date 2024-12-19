Dashmix.helpersOnLoad(['jq-appear']);
Dashmix.helpersOnLoad(['jq-slick'])

$('.slider-team').slick({
    autoplay: true, // Đặt tùy chọn phát tự động dựa trên thuộc tính dữ liệu
    dots: true, // Đặt tùy chọn chấm dựa trên thuộc tính dữ liệu
    arrows: true, // Đặt tùy chọn mũi tên dựa trên thuộc tính dữ liệu
    slidesToShow: 4, // Đặt tùy chọn Hiển thị trang chiếu dựa trên thuộc tính dữ liệu
    responsive: [
        {
            breakpoint: 1024, // Thêm điểm ngắt cho các kích thước màn hình khác nhau
            settings: {
                slidesToShow: 3 // Thay đổi số lượng slide hiển thị cho kích thước màn hình này
            }
        },

        {
            breakpoint: 768,
            settings: {
                slidesToShow: 2
            }
        },

        {
            breakpoint: 480,
            settings: {
                slidesToShow: 1
            }
        }
    ]
});

const btnScrollTo = document.querySelector(".btn--scroll-to");
const section1 = document.getElementById("section--1");

btnScrollTo.addEventListener('click', function () {
    section1.scrollIntoView({ behavior: 'smooth' });
});
