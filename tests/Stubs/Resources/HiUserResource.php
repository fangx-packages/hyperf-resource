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

use Fangx\Resource\Grpc\GrpcResource;
use Grpc\HiUser;

class HiUserResource extends GrpcResource
{
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'sex' => $this->sex,
        ];
    }

    public function expect(): string
    {
        return HiUser::class;
    }
}
