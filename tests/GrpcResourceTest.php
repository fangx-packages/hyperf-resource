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

namespace Fangx\Tests;

use Fangx\Tests\Stubs\Resources\HiReplyResource;
use Grpc\HiReply;
use Grpc\HiUser;

/**
 * @internal
 * @coversNothing
 */
class GrpcResourceTest extends TestCase
{
    public function testResourceToMessage()
    {
        $msg = HiReplyResource::make(new class() {
            public $message;

            public $user;

            public function __construct()
            {
                $this->message = 'foo';
                $this->user = new class() {
                    public $name = 'foo name';

                    public $sex = 1;
                };
            }
        })->toMessage();

        $this->assertSame(HiReply::class, get_class($msg));
        $this->assertSame(HiUser::class, get_class($msg->getUser()));
    }

    public function testCollectionToMessage()
    {
        $collection = collect([
            new class() {
                public $message;

                public $user;

                public function __construct()
                {
                    $this->message = 'foo';
                    $this->user = new class() {
                        public $name = 'foo name';

                        public $sex = 1;
                    };
                }
            },
            new class() {
                public $message;

                public $user;

                public function __construct()
                {
                    $this->message = 'bar';
                    $this->user = new class() {
                        public $name = 'bar name';

                        public $sex = 2;
                    };
                }
            },
        ]);

        $msg = HiReplyResource::collection($collection)->toMessage();

        $this->assertTrue(is_array($msg));

        $this->assertCount(2, $msg);

        foreach ($msg as $value) {
            $this->assertSame(HiReply::class, get_class($value));
            $this->assertSame(HiUser::class, get_class($value->getUser()));
        }
    }
}
