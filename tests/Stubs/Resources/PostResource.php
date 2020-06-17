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

class PostResource extends JsonResource
{
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'custom' => true,
        ];
    }

    public function withResponse($request, $response)
    {
        $response->header('X-Resource', 'True');
    }
}
