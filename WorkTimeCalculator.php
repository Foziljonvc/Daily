<?php
declare(strict_types=1);

class WorkTimeCalculator {
    private array $days;
    private array $results;
    private int $workSchedule;

    public function __construct(array $days, int $workSchedule = 540) {
        $this->days = $days;
        $this->results = [];
        $this->workSchedule = $workSchedule;
    }

    public function calculateWorkTime(string $arrivedAt, string $leavedAt): int {
        $arrivedAt = new DateTime($arrivedAt);
        $leavedAt = new DateTime($leavedAt);
        $interval = $arrivedAt->diff($leavedAt);
        return $interval->h * 60 + $interval->i;
    }

    public function calculateTotalWorkOffTime(int $workTime): int {
        return $this->workSchedule - $workTime;
    }

    public function processRequest(array $postData): void {
        foreach ($this->days as $day) {
            if (isset($postData["{$day}_come"]) && isset($postData["{$day}_gone"])) {
                $arrivedAt = $postData["{$day}_come"];
                $leavedAt = $postData["{$day}_gone"];

                $workTime = $this->calculateWorkTime($arrivedAt, $leavedAt);
                $formattedWorkTime = (new DateTime($arrivedAt))->diff(new DateTime($leavedAt))->format('%H:%I');
                $workOffTime = $this->calculateTotalWorkOffTime($workTime);

                $this->results[$day] = [
                    'workTime' => $formattedWorkTime,
                    'workOffTime' => $workOffTime
                ];
            }
        }
    }

    public function getResults(): array {
        return $this->results;
    }
}
?>
