<?php

require __DIR__ . '/../_types.php';

use App\Cells\ProfileHeaderCell;
use App\Entities\User;

/**
 * @var string[] $error
 * @var bool $initProfile
 */

$user = User::get();
$profile = $user->getProfile();
?>

<?php $view->extend('templates/nav');?>


<?php $view->section('head');?>
<link rel="stylesheet" href="/css/profile/index.css">
<link rel="stylesheet" href="/css/profile/header.css">
<?php $view->endSection();?>


<?php $view->section('slot');?>
<?=ProfileHeaderCell::m($profile->display_name ?? 'Setup Profile', !$initProfile)?>

<div class="c-banner-picture border-bottom"></div>
<div class="c-avatar-holder">
  <button class="c-avatar p-0" id="avatar-button">
    <img src="<?=$profile?->getAvatarUrl()?>" alt="">
  </button>
</div>

<form action="/api/edit_profile" method="post" enctype="multipart/form-data">
  <?=csrf_field();?>
  <input type="file" id="avatar" name="avatar" accept=".png, .jpg, .jpeg" hidden>

  <div class="p-3">
    <div class="mb-3">
      <label for="display_name">Name</label>
      <div>
        <input type="text"
               class="form-control <?=isset($error['display_name']) ? 'is-invalid' : '';?>"
               id="display_name" name="display_name" autofocus
               value="<?=esc(old('display_name') ?? ($profile->display_name) ?? '')?>">
        <div id="display_nameFeedback" class="invalid-feedback">
          <?=$error['display_name'] ?? '';?>
        </div>
      </div>
    </div>

    <div class="mb-3">
      <label for="bio" class="w-100">Bio <span class="float-end text-body-secondary"><span id="bio-counter">0</span>/160</span></label>
      <div>
        <textarea class="form-control <?=isset($error['bio']) ? 'is-invalid' : '';?>"
                  name="bio" id="bio" rows="3" maxlength="160"
        ><?=esc(old('bio') ?? ($profile->bio ?? ''))?></textarea>
      </div>
    </div>

    <button class="btn btn-dark mb-3 float-end fw-bold" type="submit">Save</button>
  </div>
</form>
<?php $view->endSection();?>


<?php $view->section('js');?>
<script src="/js/profile/settings.js"></script>
<?php $view->endSection();?>
