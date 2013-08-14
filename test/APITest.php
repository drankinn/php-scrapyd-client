<?php namespace Weblabz\Test;
/**
 * WebLabz LLC
 * User: lance
 * Date: 8/9/13
 * Time: 5:12 PM
 */

use Weblabz\Scrapyd\API;
require_once __DIR__ .'/BaseTest.php';
class APITest extends BaseTest {

    private $api;

    public function setUp(){
        $this->api = new API;
    }
    public function testJunk(){
        assert(true);
    }
}
