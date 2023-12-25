<?php

require __DIR__ . '/../_types.php';
require __DIR__ . '/_types.php';

?>

<?php $view->extend('templates/base');?>


<?php $view->section('head');?>
<div class="position-absolute top-50 start-50 translate-middle d-flex flex-column justify-content-center w-25">
  <div class="d-flex justify-content-center">
    <i class="fa-solid fa-3x fa-bug fa-spin-pulse"></i>
  </div>

  <form action="<?=url_to('register')?>" method="post"
        class="d-flex flex-column gap-2">
    <h2><?=lang('Auth.register')?></h2>

    <?=csrf_field();?>

    <div class="form-group">
      <input type="email"
             class="form-control <?php if (session('errors.email')): ?>is-invalid<?php endif?>"
             name="email"
             placeholder="<?=lang('Auth.email')?>"
             value="<?=old('email')?>">
      <div class="invalid-feedback">
				<?=session('errors.email')?>
			</div>
    </div>

    <div class="form-group">
      <input type="text"
             class="form-control <?php if (session('errors.username')): ?>is-invalid<?php endif?>"
             name="username"
             placeholder="<?=lang('Auth.username')?>"
             value="<?=old('username')?>">
      <div class="invalid-feedback">
				<?=session('errors.username')?>
			</div>
    </div>

    <div class="form-group">
      <input type="password"
             name="password"
             class="form-control <?php if (session('errors.password')): ?>is-invalid<?php endif?>"
             placeholder="<?=lang('Auth.password')?>"
             autocomplete="off">
      <div class="invalid-feedback">
				<?=session('errors.password')?>
			</div>
    </div>

    <div class="form-group">
      <input type="password"
             name="pass_confirm"
             class="form-control <?php if (session('errors.pass_confirm')): ?>is-invalid<?php endif?>"
             placeholder="<?=lang('Auth.repeatPassword')?>"
             autocomplete="off">
      <div class="invalid-feedback">
				<?=session('errors.pass_confirm')?>
			</div>
    </div>

    <button type="submit" class="btn btn-primary btn-block"><?=lang('Auth.register')?></button>

    <div class="d-flex justify-content-center">
      <div>
        <?=lang('Auth.alreadyRegistered')?> <a href="<?= url_to('login') ?>"><?=lang('Auth.signIn')?></a>
      </div>
    </div>
  </form>
</div>
<?php $view->endSection();?>
