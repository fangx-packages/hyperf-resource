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

use Fangx\Resource\Json\JsonResource;

class PostResourceWithOptionalMerging extends JsonResource
{
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            $this->mergeWhen(false, ['first' => 'value']),
            $this->mergeWhen(true, ['second' => 'value']),
        ];
    }
}
