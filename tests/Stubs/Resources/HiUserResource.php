<?php
declare(strict_types=1);

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
