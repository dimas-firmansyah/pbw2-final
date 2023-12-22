<?php

use App\Cells\ProfileHeaderCell;
use App\Cells\ProfileUsernameCell;
use App\Entities\User;

require __DIR__ . '/../_types.php';

/**
 * @var User $user
 */

$profile = $user->getProfile();
$following = $user->getFollowingCount();
$followers = $user->getFollowerCount();
$followed = $user->isFollowedBy(user_id());
?>

<?php $view->extend('templates/nav');?>

<?php $view->section('head');?>
<link rel="stylesheet" href="/css/status.css">
<link rel="stylesheet" href="/css/profile/index.css">
<link rel="stylesheet" href="/css/profile/header.css">
<?php $view->endSection();?>


<?php $view->section('data');?>
<div id="profile-data"
     data-id="<?=$user->id?>"
     data-followed="<?=$followed?>"></div>
<?php $view->endSection();?>


<?php $view->section('slot');?>
<?=ProfileHeaderCell::m($profile->display_name)?>

<div class="border-bottom pb-3">
  <div class="c-banner-picture border-bottom"></div>
  <div class="c-avatar-holder">
    <div class="c-avatar">
      <img src="<?=$profile->getAvatarUrl()?>" alt="">
    </div>
    <div class="c-buttons pt-3 pe-3" id="profile-buttons">
        <?php if ($user->id == user_id()) {?>
          <a href="/settings/profile" class="btn btn-light border border-dark-subtle fw-bold">
            Edit Profile
          </a>
        <?php } else {?>

        <?php }?>
    </div>
  </div>
  <div class="px-3 d-flex flex-column gap-2">
    <div>
      <div class="fw-bold fs-5"><?=esc($profile->display_name)?></div>
      <?=ProfileUsernameCell::m($user)?>
    </div>

    <?php if ($profile->bio) {?>
      <div class="text-break"><?=esc($profile->bio)?></div>
    <?php }?>

    <div class="d-flex gap-3">
      <a href="/profile/<?=$user->username?>/following"
         class="link-body-emphasis link-underline link-underline-opacity-0 link-underline-opacity-100-hover">
        <span class="fw-bold" id="following-count"><?=$following?></span> Following
      </a>
      <a href="/profile/<?=$user->username?>/followers"
         class="link-body-emphasis link-underline link-underline-opacity-0 link-underline-opacity-100-hover">
        <span class="fw-bold" id="follower-count"><?=$followers?></span> Followers
      </a>
    </div>
  </div>
</div>
<div class="d-flex flex-column" id="status-container"></div>
<?php $view->endSection();?>


<?php $view->section('js');?>
<script src="/js/status/util.js"></script>
<script src="/js/profile/base.js"></script>

<?php if ($user->id != user_id()) {?>
<script src="/js/profile/foreign.js"></script>
<?php }?>
<?php $view->endSection();?>