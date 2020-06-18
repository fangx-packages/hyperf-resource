<?php
declare(strict_types=1);

namespace Fangx\Tests;

use Fangx\Tests\Stubs\Resources\HiReplyResource;
use Grpc\HiReply;
use Grpc\HiUser;

class GrpcResourceTest extends TestCase
{
    public function testToResponse()
    {
        /** @var HiReply $response */
        $response = HiReplyResource::make(new class {
            public $message;
            public $user;

            public function __construct()
            {
                $this->message = 'foo';
                $this->user = new class {
                    public $name = 'foo name';
                    public $sex = 1;
                };
            }
        })->toResponse();

        $this->assertSame(HiReply::class, get_class($response));
        $this->assertSame(HiUser::class, get_class($response->getUser()));
    }
}
