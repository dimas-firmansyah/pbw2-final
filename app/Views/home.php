<?php /** @var \CodeIgniter\View\View $this */?>

<?php 
use App\Cells\NavBarCell;
?>

<?php $this->extend('template');?>

<?php $this->section('head');?>
<link rel="stylesheet" href="/css/navbar.css">
<?php $this->endSection();?>

<?php $this->section('body');?>
<div class="c-container container p-0 d-flex">
  <?= view_cell(NavBarCell::class, ['active' => 'home']);?>

  <div class="flex-grow-1 d-flex flex-column border-start border-end">
    <div class="flex-grow-1" id="main">
      <div class="p-3 d-flex gap-3 border-bottom" id="status-input-container">
        <div class="c-status-avatar flex-shrink-0 mb-auto">
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
  </div>
</div>
<?php $this->endSection();?>
