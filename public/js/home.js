const statusInput = $("#status-input");
const statusInputContainer = $("#status-input-container");
const statusInputCounter = $("#status-input-counter");
const postStatusButton = $("#post-status");
const newStatusAnchor = $("#new-status-anchor");

function fetchStatus(idBefore) {
  $.post("/api/get_home_status", { idBefore }, statusResponseHandler);
}

fetchStatus(0);

statusInput.keyup(function () {
  const statusLength = statusInput.val().trim().length;
  statusInputCounter.html(statusLength);
  postStatusButton.prop("disabled", statusLength <= 0);
});

postStatusButton.click(function () {
  $.post("/api/post_status", {
    content: statusInput.val().trim()
  }, function (data) {
    const { id, content } = data;
    const statusDiv = createStatusDiv(data);
    statusContainer.prepend(statusDiv);
    setupStatusDiv(id, content);
    statusInput.val("");
    statusInput.keyup();
  });
});

$(window).scroll(function () {
  if ($(window).scrollTop() + window.innerHeight === $(document).height()) {
    fetchStatus(earliestStatusId);
  }
});

newStatusAnchor.click(function () {
  setTimeout(function () {
    window.scrollTo(0, 0);
    statusInput.focus();
  }, 100);
});

if (window.location.hash === "#new") {
  newStatusAnchor.click();
}