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

  <form action="<?=url_to('login')?>" method="post"
        class="d-flex flex-column gap-2">
    <h2><?=lang('Auth.loginTitle')?></h2>

    <?=csrf_field();?>

    <div class="form-group">
			<input type="text"
             class="form-control <?=session('errors.login') ? 'is-invalid' : ''?>"
				     name="login"
             placeholder="<?=lang('Auth.emailOrUsername')?>">
			<div class="invalid-feedback">
				<?=session('errors.login')?>
			</div>
		</div>

    <div class="form-group">
			<input type="password"
             name="password"
             class="form-control <?=session('errors.password') ? 'is-invalid' : ''?>"
             placeholder="<?=lang('Auth.password')?>">
			<div class="invalid-feedback">
				<?=session('errors.password')?>
			</div>
		</div>

    <button type="submit" class="btn btn-primary btn-block"><?=lang('Auth.loginAction')?></button>
    
    <div class="d-flex justify-content-center">
      <a href="<?= url_to('register') ?>"><?=lang('Auth.needAnAccount')?>
    </div>
  </form>
</div>
<?php $view->endSection();?>
