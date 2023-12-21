$(".c-tab .nav-link").click(function (e) {
  e.preventDefault();
  history.replaceState({}, '', $(this).attr("href"));
  location.reload();
});

$(".c-user").each(function () {
  const user = $(this);
  if (user.data("client")) return;
 
  const id = user.data("id");
  const username = user.data("username");

  user.find(".c-profile-buttons").html(/*html*/`
    <button class="c-profile-button c-unfollow btn btn-light border border-dark-subtle fw-bold">
      <span></span>
    </button>
    
    <button class="c-profile-button c-follow btn btn-dark fw-bold">Follow</button>`);

  const followButton = user.find(".c-follow");
  const unfollowButton = user.find(".c-unfollow");

  user.click(function () {
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
          user.data("followed", !user.data("followed"));
          toggleButtons();
        }
      });
    };
  }

  function toggleButtons() {
    if (user.data("followed")) {
      followButton.hide();
      unfollowButton.show();
    } else {
      followButton.show();
      unfollowButton.hide();
    }
  }

  toggleButtons();
});