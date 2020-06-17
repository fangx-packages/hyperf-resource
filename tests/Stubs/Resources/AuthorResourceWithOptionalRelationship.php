<?php

declare(strict_types=1);

/**
 * Fangx's Packages
 *
 * @link     https://github.com/fangx-packages/hyperf-resource
 * @document https://github.com/fangx-packages/hyperf-resource/blob/master/README.md
 * @contact  nfangxu@gmail.com
 * @author   nfangxu
 */

namespace Fangx\Tests\Stubs\Resources;

class AuthorResourceWithOptionalRelationship extends PostResource
{
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'posts_count' => $this->whenLoaded('posts', function () {
                return $this->posts->count() . ' posts';
            }, function () {
                return 'not loaded';
            }),
            'latest_post_title' => $this->whenLoaded('posts', function () {
                return optional($this->posts->first())->title ?: 'no posts yet';
            }, 'not loaded'),
        ];
    }
}
