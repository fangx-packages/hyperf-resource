<?php
declare(strict_types=1);

namespace Fangx\Tests\Stubs\Resources;

use Fangx\Resource\Grpc\GrpcResource;
use Grpc\AllReply;

class AllReplyResource extends GrpcResource
{
    public function toArray(): array
    {
        return [
            'message' => $this->message,
            'users' => HiUserResource::collection($this->users),
        ];
    }

    public function expect(): string
    {
        return AllReply::class;
    }
}
