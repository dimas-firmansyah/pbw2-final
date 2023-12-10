<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;
use CodeIgniter\Files\File;
use Config\App;

/**
 * @property int $id
 * @property string $display_name
 */
class Profile extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];

    public static function create(int $id, string $displayName, ?string $avatar): Profile
    {
        return new Profile([
            'id'           => $id,
            'display_name' => $displayName,
            'avatar'       => $avatar,
        ]);
    }

    public static function resolveAvatarUrl(string $avatar): string {
        return config(App::class)->baseURL . 'img/avatar/' . $avatar;
    }

    public function getAvatarUrl(): string
    {
        return Profile::resolveAvatarUrl($this->attributes['avatar']);
    }

    public function uploadAvatar(File $file)
    {
        $hash = hash_file('sha256', $file->getPathname());
        $file->move("img/avatar", $hash, true);

        $oldAvatar = $this->attributes['avatar'];
        if (isset($oldAvatar) && file_exists("img/avatar/$oldAvatar")) {
            unlink("img/avatar/$oldAvatar");
        }

        $this->attributes['avatar'] = $hash;
    }
}
