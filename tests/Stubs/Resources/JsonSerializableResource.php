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

class JsonSerializableResource implements \JsonSerializable
{
    public $resource;

    public function __construct($resource)
    {
        $this->resource = $resource;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->resource->id,
        ];
    }
}
