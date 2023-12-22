const avatarButton = $("#avatar-button");
const avatarImg = avatarButton.find("img");
const avatarInput = $("#avatar");

const bio = $("#bio");
const bioCounter = $("#bio-counter");

avatarButton.click(function () {
  avatarInput.click();
});

avatarInput.change(function () {
  const reader = new FileReader();
  reader.readAsDataURL(avatarInput.prop("files")[0]);
  reader.onload = function (e) {
    avatarImg.attr("src", e.target.result);
  };
});

bio.keyup(function () {
  bioCounter.html(bio.val().length);
});

bio.keyup();