<?php

require __DIR__ . '/_types.php';

use App\Entities\User;

?>

<?php $view->extend('templates/nav');?>

<?php $view->section('head');?>
<link rel="stylesheet" href="/css/status.css">
<?php $view->endSection();?>


<?php $view->section('slot');?>
<div class="flex-grow-1" id="main">
  <div class="p-3 d-flex gap-3 border-bottom" id="status-input-container">
    <div class="c-status-avatar flex-shrink-0 mb-auto">
      <img src="<?=User::get()->getProfile()->getAvatarUrl();?>" alt="">
    </div>

    <div class="d-flex flex-column flex-grow-1 gap-2">
      <div>
        <textarea name="status-input" id="status-input" rows="3" maxlength="280"
          aria-label="New status" placeholder="What's Happening???"
          class="form-control form-control-lg"></textarea>
      </div>
      <div class="d-flex gap-3">
        <div class="flex-grow-1"></div>
        <div class="my-auto"><span id="status-input-counter">0</span>/280</div>
        <button class="btn btn-primary fw-bold" id="post-status" disabled>Post</button>
      </div>
    </div>
  </div>

  <div class="d-flex flex-column" id="status-container"></div>
</div>
<?php $view->endSection();?>


<?php $view->section('js');?>
<script src="/js/status-util.js"></script>
<script src="/js/home.js"></script>
<?php $view->endSection();?>
