let { followed } = profileData;

$("#profile-buttons").html(/*html*/`
  <button class="btn btn-light border border-dark-subtle fw-bold" id="unfollow-button">
    <span></span>
  </button>
  <button class="btn btn-dark fw-bold" id="follow-button">Follow</button>`);

const followButton = $("#follow-button");
const unfollowButton = $("#unfollow-button");

followButton.click(clickButton("follow"));
unfollowButton.click(clickButton("unfollow"));

function clickButton(type) {
  return function () {
    $.post("/api/follow", {
      type,
      targetId: profileData.id
    }, function (data) {
      const { followerCount } = data;
      if (followerCount !== undefined) {
        followed = !followed;
        $("#follower-count").html(followerCount);
        toggleButtons();
      }
    });
  };
}

function toggleButtons() {
  if (followed) {
    followButton.hide();
    unfollowButton.show();
  } else {
    followButton.show();
    unfollowButton.hide();
  }
}

toggleButtons();