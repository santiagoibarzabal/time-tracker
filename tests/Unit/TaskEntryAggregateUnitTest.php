.<?php

use App\TaskEntries\Domain\TaskEntryAggregate;
use App\TaskEntries\Domain\ValueObjects\TaskId;


test('create task entry', function () {
    $taskEntryAggregate = TaskEntryAggregate::create(
        new TaskId(3),
        (new DateTimeImmutable())->add(new DateInterval('PT1H'))
    );
    expect($taskEntryAggregate)->toBeInstanceOf(TaskEntryAggregate::class);
});

test('stop task entry', function () {
    $taskEntryAggregate = TaskEntryAggregate::create(
        new TaskId(3),
        (new DateTimeImmutable())->add(new DateInterval('PT1H'))
    );
    $updated = $taskEntryAggregate->stop(new DateTimeImmutable());
    expect($updated->stoppedAt())->toBeInstanceOf(DateTimeImmutable::class);
});
