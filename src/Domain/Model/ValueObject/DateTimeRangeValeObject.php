<?php
declare(strict_types=1);

namespace PcComponentes\Ddd\Domain\Model\ValueObject;

class DateTimeRangeValeObject implements ValueObject
{
    private DateTimeValueObject $startDate;
    private DateTimeValueObject $endDate;

    private function __construct(DateTimeValueObject $startDate, DateTimeValueObject $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public static function from(DateTimeValueObject $startDate, DateTimeValueObject $endDate)
    {
        if ($startDate >= $endDate) {
            throw new \InvalidArgumentException('Start date can not be greater than the end date.');
        }

        return new self($startDate, $endDate);
    }

    public function startDate(): DateTimeValueObject
    {
        return $this->startDate;
    }

    public function endDate(): DateTimeValueObject
    {
        return $this->endDate;
    }

    public function isInDate(): bool
    {
        $now = new DateTimeValueObject();

        return $now >= $this->startDate && $now <= $this->endDate;
    }

    public function isExpired(): bool
    {
        return (new DateTimeValueObject()) > $this->endDate;
    }

    public function isNotStarted(): bool
    {
        return (new DateTimeValueObject()) < $this->startDate;
    }

    public function equalTo(DateTimeRangeValeObject $another): bool
    {
        return $this->startDate->getTimestamp() === $another->startDate->getTimestamp()
            && $this->endDate->getTimestamp() === $another->endDate->getTimestamp();
    }

    public function jsonSerialize(): array
    {
        return [
            'startDate' => $this->startDate->jsonSerialize(),
            'endDate' => $this->endDate->jsonSerialize(),
        ];
    }
}
