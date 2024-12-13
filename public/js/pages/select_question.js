// Khởi tạo mảng câu hỏi của đề thi
let arrQuestion = [];

function showListQuestion(questions) {
  let html = ``;
  if (questions.length != 0) {
    questions.forEach((question, index) => {
      let dokhotext = ["", "Dễ", "TB", "Khó"];
      let check =
        arrQuestion.findIndex((item) => item.macauhoi == question.macauhoi) !=
        -1
          ? "checked"
          : "";
      html += `<li class="list-group-item d-flex">
                <div class="form-check">
                    <input class="form-check-input item-question" type="checkbox" id="q-${
                      question.macauhoi
                    }" data-id="${
        question.macauhoi
      }" data-index="${index}" ${check}>
                    <label class="form-check-label text-muted" for="q-${
                      question.macauhoi
                    }" style="word-break: break-all;">${
        question.noidungplaintext
      }</label>
                </div>
                <span class="badge rounded-pill bg-dark m-1 float-end h-100">${
                  dokhotext[question.dokho]
                }</span>
            </li>`;
    });
  } else {
    html += `<p class="text-center">Không có câu hỏi</p>`;
  }
  $("#list-question").html(html);
}

function getAnswerListForQuestion(questions) {
  if (questions.length == 0) {
    $("#list-question").html(`<p class="text-center">Không có câu hỏi</p>`);
    return;
  }
  showListQuestion(questions);

  const arrMaCauHoi = questions.map((question) => +question.macauhoi);
  $.ajax({
    type: "post",
    url: "./question/getAnswersForMultipleQuestions",
    data: {
      questions: arrMaCauHoi,
    },
    dataType: "json",
    success: function (answers) {
      // Gắn các câu trả lời vào tương ứng macauhoi
      currentQuestionLists = questions.map((question) => {
        const { macauhoi } = question;
        return {
          ...question,
          cautraloi: answers
            .filter((answer) => answer.macauhoi === macauhoi)
            .map(({ macautl, noidungtl, ladapan }) => ({
              macautl,
              macauhoi,
              noidungtl,
              ladapan,
            })),
        };
      });
    },
    error: function (err) {
      console.error(err.responseText);
    },
  });
}

function getInfoTest() {
  return $.ajax({
    type: "post",
    url: "./test/getDetail",
    data: {
      made: made,
    },
    dataType: "json",
    success: function (data) {
      infoTest = data;
    },
  });
}

function getQuestionOfTest() {
  return $.ajax({
    type: "post",
    url: "./test/getQuestionOfTestManual",
    data: { made: made },
    dataType: "json",
    success: function (response) {
      arrQuestion = response;
    },
  });
}
