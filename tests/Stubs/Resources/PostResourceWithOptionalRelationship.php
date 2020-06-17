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

class PostResourceWithOptionalRelationship extends PostResource
{
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'comments' => new CommentCollection($this->whenLoaded('comments')),
            'author' => new AuthorResource($this->whenLoaded('author')),
            'author_name' => $this->whenLoaded('author', function () {
                return $this->author->name;
            }),
        ];
    }
}
