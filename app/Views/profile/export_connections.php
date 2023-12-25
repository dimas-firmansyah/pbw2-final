<?php

use App\Entities\Connection;
use App\Entities\Profile;
use App\Entities\User;

require __DIR__ . '/../_types.php';

/**
 * @var User $user
 * @var Profile $profile
 */

$following = $user->getFollowing();
$followers = $user->getFollowers();

function print_connection(Connection $connection, bool $following): void
{
    $user = $following
        ? $connection->getFollowing()
        : $connection->getFollower();

    $profile = $user->getProfile();

    if ($profile == null) {
        return;
    }

    ?>
      <tr>
        <td>@<?=$user->username?></td>
        <td><?=esc($profile->display_name)?></td>
      </tr>
    <?php
}
?>


<h3>User following <?=esc($profile->display_name)?> (@<?=$user->username?>)</h3>

  <table>
    <thead>
    <tr>
      <th>Username</th>
      <th>Display Name</th>
    </tr>
    </thead>
    <tbody>
      <?php foreach ($followers as $con) {print_connection($con, false);}?>
    </tbody>
  </table>

  <h3>User followed by <?=esc($profile->display_name)?> (@<?=$user->username?>)</h3>

  <table>
    <thead>
    <tr>
      <th>Username</th>
      <th>Display Name</th>
    </tr>
    </thead>
    <tbody>
      <?php foreach ($following as $con) {print_connection($con, true);}?>
    </tbody>
</table>