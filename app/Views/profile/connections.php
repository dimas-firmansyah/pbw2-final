<?php

require __DIR__ . '/../_types.php';

use App\Cells\ProfileUsernameCell;
use App\Entities\Connection;
use App\Entities\User;

/**
 * @var User $user
 * @var Connection[] $connections
 * @var bool $isFollowingTab
 */

$profile = $user->getProfile();

$showExportButton = ((int) ($_ENV['FEAT_EXPORT_CONNECTIONS'] ?? 0)) > 0;
?>

<?php $view->extend('templates/nav');?>


<?php $view->section('head');?>
<link rel="stylesheet" href="/css/tab.css">
<link rel="stylesheet" href="/css/profile/header.css">
<link rel="stylesheet" href="/css/profile/list.css">
<?php $view->endSection();?>


<?php $view->section('slot');?>
<div class="sticky-top bg-light">
  <div class="px-3 py-2 d-flex gap-3">
    <a class="c-back-button btn my-auto" href="javascript:history.back()">
      <i class="fa-solid fa-fw fa-arrow-left"></i>
    </a>
    <div class="fs-5 flex-grow-1 my-auto"><?=esc($profile->display_name)?></div>
      <?php if ($showExportButton) {?>
        <a href="/profile/<?=$user->username?>/export" class="c-profile-button btn btn-dark fw-bold">Export</a>
      <?php }?>
  </div>

  <ul class="c-tab nav nav-underline nav-fill border-bottom">
    <li class="nav-item">
      <a class="nav-link link-body-emphasis <?=$isFollowingTab ? 'active' : ''?>"
         href="/profile/<?=$user->username?>/following">Following</a>
    </li>
    <li class="nav-item">
      <a class="nav-link link-body-emphasis <?=$isFollowingTab ? '' : 'active'?>"
         href="/profile/<?=$user->username?>/followers">Followers</a>
    </li>
  </ul>
</div>

<ul class="nav flex-column">
  <?php foreach ($connections as $connection) {
    $connectionUser = $isFollowingTab ? $connection->getFollowing() : $connection->getFollower();
    $connectionProfile = $connectionUser->getProfile();
    $followedByClient = $connectionUser->isFollowedBy(user_id());
    ?>
    <li class="c-user nav-item d-flex px-3 py-2 gap-3"
        data-followed="<?=$followedByClient ? 'true' : 'false'?>"
        data-id="<?=$connectionUser->id?>"
        data-username="<?=$connectionUser->username?>"
        data-client="<?=$connectionUser->id == user_id()?>">
      <div class="c-avatar flex-shrink-0 mb-auto">
        <img src="<?=$connectionProfile->getAvatarUrl()?>" alt="">
      </div>
      <div class="d-flex flex-column flex-grow-1">
        <div class="d-flex">
          <div class="flex-grow-1">
            <a href="/profile/<?=$connectionUser->username?>"
               class="link-body-emphasis link-underline link-underline-opacity-0 link-underline-opacity-100-hover fw-bold">
                <?=esc($connectionProfile->display_name)?>
            </a>
              <?=ProfileUsernameCell::m($connectionUser)?>
          </div>
          <div class="c-profile-buttons my-auto">
            
          </div>
        </div>
        <div><?=esc($connectionProfile->bio)?></div>
      </div>
    </li>
  <?php }?>
</ul>
<?php $view->endSection();?>


<?php $view->section('js');?>
<script src="/js/profile/connection.js"></script>
<?php $view->endSection();?>
