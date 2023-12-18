const profileData = $("#profile-data").data();

function fetchStatus(idBefore) {
  $.post("/api/get_profile_status", {
    userId: profileData.id,
    idBefore
  }, statusResponseHandler);
}

$(window).scroll(function () {
  if ($(window).scrollTop() + window.innerHeight === $(document).height()) {
    fetchStatus(earliestStatusId);
  }
});

fetchStatus(0);