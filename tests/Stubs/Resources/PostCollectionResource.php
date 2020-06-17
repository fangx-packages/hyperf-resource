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

use Fangx\Resource\Json\ResourceCollection;

class PostCollectionResource extends ResourceCollection
{
    public $collects = PostResource::class;

    public function toArray(): array
    {
        return ['data' => $this->collection];
    }
}
