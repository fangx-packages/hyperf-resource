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

use Fangx\Tests\Stubs\Models\Subscription;

class PostResourceWithOptionalPivotRelationship extends PostResource
{
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'subscription' => $this->whenPivotLoaded(Subscription::class, function () {
                return [
                    'foo' => 'bar',
                ];
            }),
            'custom_subscription' => $this->whenPivotLoadedAs('accessor', Subscription::class, function () {
                return [
                    'foo' => 'bar',
                ];
            }),
        ];
    }
}
