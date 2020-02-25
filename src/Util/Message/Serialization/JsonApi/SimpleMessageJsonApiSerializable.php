<?php declare(strict_types=1);

namespace Pccomponentes\Ddd\Util\Message\Serialization\JsonApi;

use Pccomponentes\Ddd\Util\Message\Serialization\SimpleMessageSerializable;
use Pccomponentes\Ddd\Util\Message\SimpleMessage;

final class SimpleMessageJsonApiSerializable implements SimpleMessageSerializable
{
    public function serialize(SimpleMessage $message)
    {
        return \json_encode(
            [
                'data' => [
                    'message_id' => $message->messageId(),
                    'type' => $message::messageName(),
                    'attributes' => $message->messagePayload(),
                ],
            ]
        );
    }
}
