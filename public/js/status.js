const monthName = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
const statusContainer = $("#status-container");

let earliestStatusId = 0;

function likeButtonClick(statusId) {
  $.post("/api/like", {
    status_id: statusId
  }, function (data) {
    const {
      liked,
      new_like_count
    } = data;

    if (new_like_count !== undefined) {
      const likeCounter = $(`#status-${statusId} #like-count`);
      likeCounter.html(new_like_count);

      const heart = $(`#status-${statusId} #heart`);
      if (liked) heart
        .removeClass("fa-regular")
        .addClass("fa-solid");
      else heart
        .removeClass("fa-solid")
        .addClass("fa-regular");
    }
  });
}

function formatStatusDate(date) {
  const hours = `${date.getHours()}`.padStart(2, "0");
  const minutes = `${date.getMinutes()}`.padStart(2, "0");

  return `${hours}:${minutes} - ${monthName[date.getMonth()]} ${date.getDate()}, ${date.getFullYear()}`;
}

function createStatusDiv(data) {
  const {
    id,
    username,
    created_at,
    updated_at,
    display_name,
    avatar,
    like_count,
    child_count,
    liked_by_client,
    deleted
  } = data;

  const heartStyle = liked_by_client ? "fa-solid" : "fa-regular";
  const date = deleted ? null : parseMysqlDateTime(created_at);
  const dateString = deleted ? null : formatStatusDate(date);

  const updatedIcon = updated_at === created_at ? "" : /*html*/`
      <i class="fa-solid fa-xs fa-pen"></i>`;

  const inner = !deleted ? /*html*/`
      <div class="d-flex flex-column flex-shrink-0">
        <div class="c-thread-line c-hidden" id="thread-line-before"></div>
        <a href="/profile/${username}" class="c-status-avatar">
          <img src="/img/avatar/${avatar}" alt="">
        </a>
        <div class="c-thread-line c-hidden flex-grow-1" id="thread-line-after"></div>
      </div>

      <div class="d-flex py-3 flex-column gap-2 flex-grow-1">
        <div>
          <div class="d-flex gap-2">
            <a href="/profile/${username}"
               class="link-body-emphasis link-underline link-underline-opacity-0 link-underline-opacity-100-hover fw-bold">
              ${escapeHtml(display_name)}
            </a>
            <div class="font-monospace text-body-secondary">@${username}</div>
            <div class="text-body-tertiary flex-grow-1">${dateString} ${updatedIcon}</div>
            <div class="font-monospace text-body-tertiary">#${id}</div>
          </div>

          <div class="text-break" id="status-content"></div>
        </div>
        <div class="c-status-buttons d-flex gap-3">
          <div>
            <a href="/status/${id}" class="c-status-button c-comment btn">
              <i class="fa-regular fa-fw fa-comment"></i> ${child_count}
            </a>
          </div>
          <div>
            <button class="c-status-button c-status-like btn">
              <i class="${heartStyle} fa-fw fa-heart" id="heart"></i> <span id="like-count">${like_count}</span>
            </button>
          </div>
        </div>
      </div>` : /*html*/`
      <div class="p-3 text-center flex-grow-1">
        Status Deleted
      </div>`;

  return /*html*/`
      <div class="c-status px-3 d-flex gap-3 border-bottom" id="status-${id}">
        ${inner}
      </div>`;
}

function setupStatusDiv(id, content) {
  const status = $(`#status-${id}`);

  status.click(function () {
    if (hasTextSelected()) return;

    window.location.href = `/status/${id}`;
  });

  status.find("#status-content").text(content);

  status.find(".c-status-like").click(function () {
    likeButtonClick(id);
  });

  status.find("button").click(function (e) {
    e.stopPropagation();
  });
}

function statusResponseHandler(data) {
  for (let i = 0; i < data.length; i++) {
    const { id, content } = data[i];
    const statusDiv = createStatusDiv(data[i]);

    statusContainer.append(statusDiv);
    setupStatusDiv(id, content);

    earliestStatusId = id;
  }
}