<?php

require __DIR__ . '/_types.php';

?>

<?php $view->extend('templates/nav');?>


<?php $view->section('head');?>
<link rel="stylesheet" href="/css/profile-list.css">
<?php $view->endSection();?>


<?php $view->section('data');?>
<div id="search-data"
     data-client-user-id="<?=user_id()?>"></div>
<?php $view->endSection();?>


<?php $view->section('slot');?>
<div class="input-group p-3 border-bottom sticky-top bg-light">
  <span class="input-group-text"><i class="fa-solid fa-fw fa-search"></i></span>
  <input type="text" class="form-control" placeholder="Search Profiles" id="search-input"
         aria-label="Search Profiles">
</div>

<div class="d-flex flex-column" id="search-result-container"></div>
<?php $view->endSection();?>

<?php $view->section('js');?>
<script src="/js/search.js"></script>
<?php $view->endSection();?>
