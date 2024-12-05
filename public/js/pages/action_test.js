Dashmix.helpersOnLoad(["js-flatpickr", "jq-datepicker", "jq-select2"]);

let groups = [];

function getMinutesBetweenDates(start, end) {
  // Chuyển đổi đối số thành đối tượng Date
  const startDate = new Date(start);
  const endDate = new Date(end);

  // Tính số phút giữa hai khoảng thời gian
  const diffMs = endDate.getTime() - startDate.getTime();
  const diffMins = Math.round(diffMs / 60000);

  // Trả về số phút tính được
  return diffMins;
}

function getToTalQuestionOfChapter(chuong, monhoc, dokho) {
  var result = 0;
  $.ajax({
    url: "./question/getsoluongcauhoi",
    type: "post",
    data: {
      chuong: chuong,
      monhoc: monhoc,
      dokho: dokho,
    },
    async: false,
    success: function (response) {
      result = response;
    },
  });
  return result;
}

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

$(document).ready(function () {
  function showGroup() {
    let html = "<option></option>";
    $.ajax({
      type: "post",
      url: "./module/loadData",
      async: false,
      data: {
        hienthi: 1,
      },
      dataType: "json",
      success: function (response) {
        groups = response;
        response.forEach((item, index) => {
          html += `<option value="${index}">${
            item.mamonhoc +
            " - " +
            item.tenmonhoc +
            " - NH" +
            item.namhoc +
            " - HK" +
            item.hocky
          }</option>`;
        });
        $("#nhom-hp").html(html);
      },
    });
  }

  // Hiển thị chương
  function showChapter(mamonhoc) {
    let html = "<option value=''></option>";
    $("#chuong").val("").trigger("change");
    $.ajax({
      type: "post",
      url: "./subject/getAllChapter",
      async: false,
      data: {
        mamonhoc: mamonhoc,
      },
      dataType: "json",
      success: function (data) {
        data.forEach((item) => {
          html += `<option value="${item.machuong}">${item.tenchuong}</option>`;
        });
        $("#chuong").html(html);
      },
    });
  }

  let infodethi;
  function getDetail(made) {
    return $.ajax({
      type: "post",
      url: "./test/getDetail",
      data: {
        made: made,
      },
      dataType: "json",
      success: function (response) {
        if (response.loaide == 0) {
          $("#btn-update-quesoftest").show();
          $("#btn-update-quesoftest").attr(
            "href",
            `./test/select/${response.made}`
          );
        }
        infodethi = response;
        showInfo(response);
      },
    });
  }
});
