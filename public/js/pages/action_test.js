Dashmix.helpersOnLoad(["js-flatpickr", "jq-datepicker", "jq-select2"]);

Dashmix.onLoad(() =>
  class {
    static initValidation() {
      Dashmix.helpers("jq-validation"),
        $.validator.addMethod(
          "validTimeEnd",
          function (value, element) {
            var startTime = new Date($("#time-start").val());
            var currentTime = new Date();
            var endTime = new Date(value);
            return endTime > startTime && endTime > currentTime;
          },
          "Thời gian kết thúc phải lớn hơn thời gian bắt đầu và không bé hơn thời gian hiện tại"
        );

      $.validator.addMethod(
        "validTimeStart",
        function (value, element) {
          var startTime = new Date(value);
          var currentTime = new Date();
          return startTime > currentTime;
        },
        "Thời gian bắt đầu không được bé hơn thời gian hiện tại"
      );

      $.validator.addMethod(
        "validSoLuong",
        function (value, element, param) {
          let c = $("#chuong").val() === undefined ? "" : $("#chuong").val();
          let m =
            $("#nhom-hp").val() == ""
              ? 0
              : groups[$("#nhom-hp").val()].mamonhoc;
          let result =
            parseInt(getToTalQuestionOfChapter(c, m, param)) >= parseInt(value);
          return result;
        },
        "Số lượng câu hỏi không đủ"
      );

      $.validator.addMethod(
        "validThoigianthi",
        function (value, element, param) {
          let startTime = new Date($("#time-start").val());
          let endTime = new Date($("#time-end").val());
          return (
            startTime < endTime &&
            parseInt(getMinutesBetweenDates(startTime, endTime)) >=
              parseInt(value)
          );
        },
        "Thời gian làm bài không hợp lệ"
      );

      jQuery(".form-taodethi").validate({
        rules: {
          "name-exam": {
            required: true,
          },
          "time-start": {
            required: !0,
            validTimeStart: true,
          },
          "time-end": {
            required: !0,
            validTimeEnd: true,
          },
          "exam-time": {
            required: !0,
            digits: true,
            validThoigianthi: true,
          },
          "nhom-hp": {
            required: !0,
          },
          user_nhomquyen: {
            required: !0,
          },
          chuong: {
            required: !0,
          },
          coban: {
            required: !0,
            digits: true,
            validSoLuong: 1,
          },
          trungbinh: {
            required: !0,
            digits: true,
            validSoLuong: 2,
          },
          kho: {
            required: !0,
            digits: true,
            validSoLuong: 3,
          },
        },
        messages: {
          "name-exam": {
            required: "Vui lòng nhập tên đề kiểm tra",
          },
          "time-start": {
            required: "Vui lòng chọn thời điểm bắt đầu của bài kiểm tra",
            validTimeStart:
              "Thời gian bắt đầu không được bé hơn thời gian hiện tại",
          },
          "time-end": {
            required: "Vui lòng chọn thời điểm kết thúc của bài kiểm tra",
            validTimeEnd: "Thời gian kết thúc không hợp lệ",
          },
          "exam-time": {
            required: "Vui lòng chọn thời gian làm bài kiểm tra",
          },
          "nhom-hp": {
            required: "Vui lòng chọn nhóm học phần giảng dạy",
          },
          chuong: {
            required: "Vui lòng chọn số chương cho đề kiểm tra",
          },
          coban: {
            required: "Vui lòng cho biết số câu dễ",
            digits: "Vui lòng nhập số",
          },
          trungbinh: {
            required: "Vui lòng cho biết số câu trung bình",
            digits: "Vui lòng nhập số",
          },
          kho: {
            required: "Vui lòng cho biết số câu khó",
            digits: "Vui lòng nhập số",
          },
        },
      });
    }
    static init() {
      this.initValidation();
    }
  }.init()
);
