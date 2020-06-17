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

class PostResourceWithOptionalData extends JsonResource
{
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'first' => $this->when(false, 'value'),
            'second' => $this->when(true, 'value'),
            'third' => $this->when(true, function () {
                return 'value';
            }),
            'fourth' => $this->when(false, 'value', 'default'),
            'fifth' => $this->when(false, 'value', function () {
                return 'default';
            }),
        ];
    }
}
