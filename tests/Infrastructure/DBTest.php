<?php

namespace Test\Infrastructure;

use PHPUnit\Framework\TestCase;
use EPGThread\Infrastructure\DB;

class DBTest extends TestCase
{
    public function testDBInstance()
    {
        $db1 = DB::getInstance();
        $db2 = DB::getInstance();

        $this->assertSame($db1, $db2);
    }
}
