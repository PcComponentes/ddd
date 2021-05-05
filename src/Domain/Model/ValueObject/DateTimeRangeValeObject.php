<?php
declare(strict_types=1);

namespace PcComponentes\Ddd\Domain\Model\ValueObject;

class DateTimeRangeValeObject implements ValueObject
{
    private DateTimeValueObject $start;
    private DateTimeValueObject $end;

    final private function __construct(DateTimeValueObject $start, DateTimeValueObject $end)
    {
        $this->start = $start;
        $this->end = $end;
    }

    public static function from(DateTimeValueObject $start, DateTimeValueObject $end): static
    {
        if ($start >= $end) {
            throw new \InvalidArgumentException('Start date can not be greater than the end date.');
        }

        return new static($start, $end);
    }

    public function start(): DateTimeValueObject
    {
        return $this->start;
    }

    public function end(): DateTimeValueObject
    {
        return $this->end;
    }

    public function isInDate(): bool
    {
        $now = DateTimeValueObject::now();

        return $now >= $this->start && $now <= $this->end;
    }

    public function isExpired(): bool
    {
        return DateTimeValueObject::now() > $this->end;
    }

    public function isNotStarted(): bool
    {
        return DateTimeValueObject::now() < $this->start;
    }

    public function equalTo(DateTimeRangeValeObject $another): bool
    {
        return $this->start->getTimestamp() === $another->start->getTimestamp()
            && $this->end->getTimestamp() === $another->end->getTimestamp();
    }

    public function jsonSerialize(): array
    {
        return [
            'start' => $this->start,
            'end' => $this->end,
        ];
    }
}
