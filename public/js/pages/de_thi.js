let questions = [];
const made = $("#dethicontent").data("id");
const dethi = "dethi" + made;
const cautraloi = "cautraloi" + made;
let endTime = -1;

function getQuestion() {
  return $.ajax({
    type: "post",
    url: "./test/getQuestion",
    data: {
      made: made,
    },
    dataType: "json",
    success: function (response) {
      questions = response;
    },
  });
}

function showListQuestion(questions, answers) {
  let html = ``;
  questions.forEach((question, index) => {
    html += `<div class="question rounded border mb-3 bg-white" id="c${
      index + 1
    }">
        <div class="question-top p-3">
            <p class="question-content fw-bold mb-3">${index + 1}. ${
      question.noidung
    }</p>
            <div class="row">`;
    question.cautraloi.forEach((ctl, i) => {
      html += `<div class="col-6 mb-1">
                <p class="mb-1"><b>${String.fromCharCode(i + 65)}.</b> ${
        ctl.noidungtl
      }</p>
            </div>`;
    });
    html += `</div></div><div class="test-ans bg-primary rounded-bottom py-2 px-3 d-flex align-items-center"><p class="mb-0 text-white me-4">Đáp án của bạn:</p><div>`;
    question.cautraloi.forEach((ctl, i) => {
      let check = answers[index].cautraloi == ctl.macautl ? "checked" : "";
      html += `<input type="radio" class="btn-check" name="options-c${
        index + 1
      }" id="ctl-${ctl.macautl}" autocomplete="off" data-index="${
        index + 1
      }" data-macautl="${ctl.macautl}" ${check}>
                    <label class="btn btn-light rounded-pill me-2 btn-answer" for="ctl-${
                      ctl.macautl
                    }">${String.fromCharCode(i + 65)}</label>`;
    });
    html += `</div></div></div>`;
  });
  $("#list-question").html(html);
}

function showBtnSideBar(questions, answers) {
  let html = ``;
  questions.forEach((q, i) => {
    let isActive = answers[i].cautraloi == 0 ? "" : " active";
    html += `<li class="answer-item p-1"><a href="javascript:void(0)" class="answer-item-link btn btn-outline-primary w-100 btn-sm${isActive}" data-index="${
      i + 1
    }">${i + 1}</a></li>`;
  });
  $(".answer").html(html);
}

function initListAnswer(questions) {
  let listAns = questions.map((item) => {
    let itemAns = {};
    itemAns.macauhoi = item.macauhoi;
    itemAns.cautraloi = 0;
    return itemAns;
  });
  return listAns;
}

function getTimeTest() {
  let dethi = $("#dethicontent").data("id");
  $.ajax({
    type: "post",
    url: "./test/getTimeTest",
    data: {
      dethi: dethi,
    },
    success: function (response) {
      endTime = new Date(response).getTime();
      let curTime = new Date().getTime();
      if (curTime > endTime) {
        localStorage.removeItem(cautraloi);
        localStorage.removeItem(dethi);
        location.href = `./test/start/${made}`;
      } else {
        $.ajax({
          type: "post",
          url: "./test/getTimeEndTest",
          data: {
            dethi: dethi,
          },
          success: function (responseEnd) {
            let endTimeTest = new Date(responseEnd).getTime();
            if (endTimeTest < endTime) {
              endTime = endTimeTest;
            }
          },
        });
        countDown();
      }
    },
  });
}
