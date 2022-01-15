<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\WithFaker;
use Prophecy\PhpUnit\ProphecyTrait;
use Tests\TestCase;

class UnitTestCase extends TestCase
{
    use ProphecyTrait;
    use WithFaker;
}
