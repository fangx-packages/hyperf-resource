<?php
declare(strict_types=1);

namespace Fangx\Tests\Stubs\Resources;

use Fangx\Resource\Grpc\GrpcResource;
use Grpc\HiReply;

class HiReplyResource extends GrpcResource
{
    public function toArray(): array
    {
        return [
            'message' => $this->message,
            'user' => HiUserResource::make($this->user),
        ];
    }

    public function except(): string
    {
        return HiReply::class;
    }
}
