<?php

declare(strict_types=1);

namespace App\Tasks\Domain\Exceptions;

use Exception;

class TaskCannotBeStartedWithActiveEntries extends Exception {}