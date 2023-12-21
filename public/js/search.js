const { clientUserId } = $("#search-data").data();
const searchInput = $("#search-input");
const searchResultContainer = $("#search-result-container");

let searchInputTimer;

searchInput.keyup(function () {
  clearTimeout(searchInputTimer);
  searchInputTimer = setTimeout(requestResults, 500);
});

function requestResults() {
  const query = searchInput.val().trim();
  if (query.length === 0) return;
  if (query.length === 1 && query[0] === '@') return;

  $.post("/api/search", {
    query
  }, function (data) {
    searchResultContainer.html("");

    for (let i = 0; i < data.length; i++) {
      const { id, username, display_name, avatar, bio, following, followed } = data[i];
      let followedByClient = followed !== "0";

      const followsYouSpan = following === "0" ? "" : /*html*/`
        <span class="badge text-secondary bg-body-secondary">Follows you</span>`;

      const followButtonsDiv = id === `${clientUserId}` ? "" : /*html*/`
        <div class="c-profile-buttons my-auto">
          <button class="c-profile-button c-unfollow btn btn-light border border-dark-subtle fw-bold">
            <span></span>
          </button>
          <button class="c-profile-button c-follow btn btn-dark fw-bold">Follow</button>
        </div>`;

      searchResultContainer.append(/*html*/`
        <div class="c-user d-flex px-3 py-2 gap-3" id="user-${id}">
          <div class="c-avatar flex-shrink-0 mb-auto">
            <img src="/img/avatar/${avatar}" alt="">
          </div>
          <div class="d-flex flex-column flex-grow-1">
            <div class="d-flex">
              <div class="flex-grow-1">
                <a href="/profile/${username}"
                   class="link-body-emphasis link-underline link-underline-opacity-0 link-underline-opacity-100-hover fw-bold">
                  ${escapeHtml(display_name)}
                </a>
                <div>
                  <span class="font-monospace text-body-secondary">@${username}</span>
                  ${followsYouSpan}
                </div>
              </div>
              ${followButtonsDiv}
            </div>
            <div>${bio == null ? '' : escapeHtml(bio)}</div>
          </div>
        </div>`);

      const userDiv = $(`#user-${id}`);
      const followButton = userDiv.find(".c-follow");
      const unfollowButton = userDiv.find(".c-unfollow");

      userDiv.click(function () {
        if (hasTextSelected()) return;
        window.location.href = `/profile/${username}`;
      });

      followButton.click(clickButton("follow"));
      unfollowButton.click(clickButton("unfollow"));

      function clickButton(type) {
        return function (e) {
          e.stopPropagation();

          $.post("/api/follow", {
            type,
            targetId: id
          }, function (data) {
            const { followerCount } = data;
            if (followerCount !== undefined) {
              followedByClient = !followedByClient;
              toggleButtons();
            }
          });
        };
      }

      function toggleButtons() {
        if (followedByClient) {
          followButton.hide();
          unfollowButton.show();
        } else {
          followButton.show();
          unfollowButton.hide();
        }
      }

      toggleButtons();
    }
  });
}

requestResults();