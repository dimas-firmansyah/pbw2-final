<?php

include __DIR__ . '/../_types.php';

function activeClass(string $value)
{
    global $viewName;
    return $viewName == $value ? 'active' : '';
}

?>

<?php $view->extend('templates/base');?>

<?php $view->section('head');?>
<link rel="stylesheet" href="/css/navbar.css">
<?php $view->endSection();?>

<?php $view->section('body');?>
<div class="c-container container p-0 d-flex">

  <div class="c-nav sticky-top d-flex flex-column p-3">
    <ul class="nav nav-flush flex-column gap-3 flex-grow-1">
      <li class="nav-item">
        <a href="/home" class="c-nav-icon nav-link active">
          <i class="active fa-solid fa-fw fa-bug fa-spin-pulse"></i>
        </a>
      </li>
      <li class="nav-item">
        <a href="/home" class="c-nav-icon nav-link <?=activeClass('home');?>"
           aria-current="page" title=""
           data-bs-toggle="tooltip"
           data-bs-placement="right" data-bs-title="Home">
            <i class="fa-solid fa-fw fa-home"></i>
        </a>
      </li>
      <li class="nav-item">
        <a href="/search" class="c-nav-icon nav-link <?=activeClass('search');?>"
           aria-current="page" title=""
           data-bs-toggle="tooltip"
           data-bs-placement="right" data-bs-title="Search">
            <i class="fa-solid fa-fw fa-magnifying-glass"></i>
        </a>
      </li>
      <li class="nav-item">
        <a href="/home#new" class="c-nav-icon c-nav-primary nav-link text-primary" id="new-status-anchor"
           aria-current="page" title=""
           data-bs-toggle="tooltip"
           data-bs-placement="right" data-bs-title="New Status">
            <i class="fa-solid fa-fw fa-pen-to-square"></i>
        </a>
      </li>
      <li class="nav-item flex-grow-1"></li>
      <li class="nav-item">
        <a href="/profile/<?=user()->username;?>" class="c-nav-icon nav-link"
           aria-current="page" title=""
           data-bs-toggle="tooltip"
           data-bs-placement="right" data-bs-title="Profile">
            <i class="fa-solid fa-fw fa-user"></i>
        </a>
      </li>
      <li class="nav-item">
        <a href="/info" class="c-nav-icon nav-link <?=activeClass('info');?>"
           aria-current="page" title=""
           data-bs-toggle="tooltip"
           data-bs-placement="right" data-bs-title="Info">
            <i class="fa-solid fa-fw fa-circle-info"></i>
        </a>
      </li>
      <li class="nav-item">
        <a href="/logout" class="c-nav-icon c-nav-danger nav-link"
           aria-current="page" title=""
           data-bs-toggle="tooltip"
           data-bs-placement="right" data-bs-title="Logout">
            <i class="fa-solid fa-fw fa-arrow-right-from-bracket"></i>
        </a>
      </li>
    </ul>
  </div>

  <div class="flex-grow-1 d-flex flex-column border-start border-end">
    <?php $view->renderSection('slot');?>
  </div>
<?php $view->endSection();?>