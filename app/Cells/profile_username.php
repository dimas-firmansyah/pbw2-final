<?php

use App\Entities\User;

/**
 * @var User $user
 */

?>

<div>
  <span class="font-monospace text-body-secondary">@<?=$user->username?></span>
    <?php if ($user->follows(user_id())) {?>
      <span class="badge text-secondary bg-body-secondary">Follows you</span>
    <?php }?>
</div>