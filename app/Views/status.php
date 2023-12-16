<?php

require __DIR__ . '/_types.php';

use App\Cells\ConfirmModalCell;
use App\Cells\ProfileUsernameCell;
use App\Entities\Status;
use App\Entities\User;

/**
 * @var Status $status
 */

$client = User::get();
$clientProfile = $client->getProfile();

$statusOwner = $status->getOwner();
$statusProfile = $statusOwner?->getProfile();

$liked = $status->getEngagementFor(user_id()) !== null;
?>

<?php $view->extend('templates/nav');?>


<?php $view->section('head');?>
<link rel="stylesheet" href="/css/status.css">
<?php $view->endSection();?>


<?php $view->section('slot');?>
<div class="flex-grow-1" id="main">
  <div class="d-flex flex-column" id="ancestor-status-container"></div>

    <div id="main-status-data"
         data-id="<?=$status->id?>"
         data-created-at="<?=$status->created_at?>"
         data-updated-at="<?=$status->updated_at?>">
    </div>

    <?php if (!$status->isDeleted()) {?>
      <div class="px-3 d-flex flex-column gap-3" id="main-status">
        <div class="d-flex gap-3">
          <div class="d-flex flex-column flex-shrink-0">
            <div class="c-thread-line c-hidden" id="thread-line-before"></div>
            <a href="/profile/<?=$statusOwner->username?>" class="c-status-avatar">
              <img src="<?=$statusProfile->getAvatarUrl()?>" alt="">
            </a>
          </div>
          <div class="pt-3 d-flex flex-column flex-grow-1 gap-2">
            <div>
              <div>
                <a href="/profile/<?=$statusOwner->username?>"
                   class="link-body-emphasis link-underline link-underline-opacity-0 link-underline-opacity-100-hover fw-bold">
                    <?=$statusProfile->getSaveDisplayName()?>
                </a>
                <span class="float-end font-monospace text-body-tertiary">#<?=$status->id?></span>
              </div>
                <?=ProfileUsernameCell::m($statusOwner)?>
            </div>
          </div>
        </div>
        <div class="text-break fs-5" id="main-status-content"><?=$status->getSaveContent()?></div>

          <?php if ($liked) {?>
            <div class="d-flex flex-column flex-grow-1 gap-2 pb-3 border-bottom d-none" id="edit-status-container">
              <div>
              <textarea name="status-input" id="edit-input" rows="3" maxlength="280"
                        aria-label="New status" placeholder="Edit status"
                        class="form-control form-control-lg"></textarea>
              </div>
              <div class="d-flex gap-3">
                <div class="flex-grow-1"></div>
                <div class="my-auto"><span id="edit-input-counter">0</span>/280</div>
                <button class="btn btn-light border border-dark-subtle fw-bold" id="post-edit-cancel">Cancel
                </button>
                <button class="btn btn-primary fw-bold" id="post-edit-submit" disabled>Edit</button>
              </div>
            </div>
          <?php }?>

        <div class="text-break pb-3 border-bottom d-flex gap-3">
          <div class="my-auto"><span class="fw-bold" id="main-status-like-counter"><?=$status->like_count?></span>
            Likes
          </div>
          <button class="c-status-button c-status-like btn">
            <i class="<?=$liked ? 'fa-solid' : 'fa-regular'?> fa-fw fa-heart"
               id="main-status-heart"></i>
          </button>
          <div class="flex-grow-1"></div>
          <div class="my-auto text-body-tertiary" id="main-status-time"></div>

            <?php if ($statusOwner->id === user_id()) {?>
              <div class="d-flex gap-2">
                <button class="c-status-button btn" id="edit-status"
                        data-bs-toggle="tooltip"
                        data-bs-placement="bottom" data-bs-title="Edit Status">
                  <i class="fa-regular fa-fw fa-pen-to-square"></i>
                </button>
                <div data-bs-toggle="tooltip"
                     data-bs-placement="bottom" data-bs-title="Delete Status">
                  <button class="c-status-button btn"
                          data-bs-toggle="modal" data-bs-target="#delete-status-modal">
                    <i class="fa-regular fa-fw fa-trash-can"></i>
                  </button>
                </div>
              </div>
            <?php }?>

        </div>
      </div>
    <?php } else {?>
      <div class="p-3 border-bottom text-center" id="main-status">Status deleted</div>
    <?php }?>

    <?php if (!$status->isDeleted()) {?>
      <div class="p-3 d-flex gap-3 border-bottom">
        <div class="c-status-avatar flex-shrink-0 mb-auto">
          <img src="<?=$clientProfile->getAvatarUrl()?>" alt="">
        </div>
        <div class="d-flex flex-column flex-grow-1 gap-2">
          <div>
          <textarea name="status-input" id="reply-input" rows="3" maxlength="280"
                    aria-label="New status" placeholder="Post your reply!"
                    class="form-control form-control-lg"></textarea>
          </div>
          <div class="d-flex gap-3">
            <div class="flex-grow-1"></div>
            <div class="my-auto"><span id="reply-input-counter">0</span>/280</div>
            <button class="btn btn-primary fw-bold" id="post-reply" disabled>Reply</button>
          </div>
        </div>
      </div>
    <?php }?>

  <div class="d-flex flex-column" id="status-container"></div>
</div>
<?php $view->endSection();?>


<?php $view->section('footer');?>
<?=ConfirmModalCell::m(
    'delete-status-modal',
    'Delete Status?',
    'This can\'t be undone and it will be removed from your profile and the timeline of any accounts that follow you.');?>
<?php $view->endSection();?>


<?php $view->section('js');?>
<script src="/js/status-util.js"></script>
<script src="/js/status-detail.js"></script>
<?php $view->endSection();?>