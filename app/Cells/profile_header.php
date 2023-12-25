<?php

use App\Entities\Profile;

/**
 * @var string $val
 * @var bool $enableBackButton
 */

?>

<div class="sticky-top bg-light border-bottom" id="profile-header-cell">
  <div class="px-3 py-2 d-flex gap-3">
    <?php if ($enableBackButton) {?>
      <a class="c-back-button btn my-auto" href="javascript:history.back()">
        <i class="fa-solid fa-fw fa-arrow-left"></i>
      </a>
    <?php }?>
    <div class="fs-5"><?=esc($val)?></div>
  </div>
</div>