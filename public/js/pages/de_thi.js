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
