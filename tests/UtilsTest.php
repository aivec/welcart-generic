<?php

declare(strict_types=1);

use Aivec\Welcart\Generic\WelcartUtils;
use PHPUnit\Framework\TestCase;
use phpmock\Mock;
use phpmock\MockBuilder;

final class UtilsTest extends TestCase
{
    protected function tearDown(): void {
        Mock::disableAll();
    }

    private function getIsAdminMock(bool $func_result) {
        return (new MockBuilder())->setNamespace('Aivec\Welcart\Generic')
            ->setName('is_admin')
            ->setFunction(function () use ($func_result) {
                return $func_result;
            })
            ->build();
    }

    public function testIsOrderListPage(): void {
        // assert false when not on admin page
        $mock = $this->getIsAdminMock(false);
        $mock->enable();
        $res = WelcartUtils::isOrderListPage();
        $mock->disable();
        $this->assertSame(false, $res);

        // assert false when $_REQUEST['page'] is not set
        $mock = $this->getIsAdminMock(true);
        $mock->enable();
        $res = WelcartUtils::isOrderListPage();
        $this->assertSame(false, $res);

        // assert invalid $_REQUEST['page'] values are handled gracefully
        foreach ([true, false, null, 0, 10] as $val) {
            $_REQUEST['page'] = $val;
            $res = WelcartUtils::isOrderListPage();
            $this->assertSame(false, $res);
        }

        // assert $_REQUEST['order_action'] values are handled gracefully
        foreach ([true, false, null, 0, 10, ['foo'], ''] as $val) {
            $_REQUEST['order_action'] = $val;
            $res = WelcartUtils::isOrderListPage();
            $this->assertSame(false, $res);
        }

        // assert false when page is 'usces_orderlist' but 'order_action'
        // is not empty
        $_REQUEST['page'] = 'usces_orderlist';
        $_REQUEST['order_action'] = 'bar';
        $res = WelcartUtils::isOrderListPage();
        $this->assertSame(false, $res);

        // assert true when page is 'usces_orderlist' and 'order_action'
        // is empty
        $_REQUEST['page'] = 'usces_orderlist';
        $_REQUEST['order_action'] = '';
        $res = WelcartUtils::isOrderListPage();
        $this->assertSame(true, $res);

        // assert false when $_REQUEST['page'] is array of pages where none of
        // the values are 'usces_orderlist' and $_REQUEST['order_action'] is empty
        $_REQUEST['page'] = ['foo', 'bar'];
        $_REQUEST['order_action'] = '';
        $res = WelcartUtils::isOrderListPage();
        $this->assertSame(false, $res);

        // assert true when $_REQUEST['page'] is array of pages where at
        // least one is 'usces_orderlist' and $_REQUEST['order_action'] is empty
        foreach ([['usces_orderlist', 'bar'], ['foo', 'usces_orderlist']] as $val) {
            $_REQUEST['page'] = $val;
            $_REQUEST['order_action'] = '';
            $res = WelcartUtils::isOrderListPage();
            $this->assertSame(true, $res);
        }
    }

    public function testIsOrderEditPage(): void {
        // assert false when not on admin page
        $mock = $this->getIsAdminMock(false);
        $mock->enable();
        $res = WelcartUtils::isOrderEditPage();
        $mock->disable();
        $this->assertSame(false, $res);

        // assert false when $_REQUEST['page'] is not set
        $mock = $this->getIsAdminMock(true);
        $mock->enable();
        $res = WelcartUtils::isOrderEditPage();
        $this->assertSame(false, $res);

        // assert invalid $_REQUEST['page'] values are handled gracefully
        foreach ([true, false, null, 0, 10] as $val) {
            $_REQUEST['page'] = $val;
            $res = WelcartUtils::isOrderEditPage();
            $this->assertSame(false, $res);
        }

        // assert $_REQUEST['order_action'] values are handled gracefully
        foreach ([true, false, null, 0, 10, ['foo'], ''] as $val) {
            $_REQUEST['order_action'] = $val;
            $res = WelcartUtils::isOrderEditPage();
            $this->assertSame(false, $res);
        }

        // assert false when page is 'usces_orderlist' but 'order_action'
        // is not 'edit' or 'editpost'
        $_REQUEST['page'] = 'usces_orderlist';
        $_REQUEST['order_action'] = 'bar';
        $res = WelcartUtils::isOrderEditPage();
        $this->assertSame(false, $res);

        // assert true when page is 'usces_orderlist' and 'order_action'
        // is 'edit'
        $_REQUEST['page'] = 'usces_orderlist';
        $_REQUEST['order_action'] = 'edit';
        $res = WelcartUtils::isOrderEditPage();
        $this->assertSame(true, $res);

        // assert true when page is 'usces_orderlist' and 'order_action'
        // is 'editpost'
        $_REQUEST['page'] = 'usces_orderlist';
        $_REQUEST['order_action'] = 'editpost';
        $res = WelcartUtils::isOrderEditPage();
        $this->assertSame(true, $res);

        // assert false when $_REQUEST['page'] is array of pages where none of
        // the values are 'usces_orderlist' and $_REQUEST['order_action'] is empty
        $_REQUEST['page'] = ['foo', 'bar'];
        $_REQUEST['order_action'] = '';
        $res = WelcartUtils::isOrderEditPage();
        $this->assertSame(false, $res);

        // assert true when $_REQUEST['page'] is array of pages where at
        // least one is 'usces_orderlist' and $_REQUEST['order_action'] is 'edit'
        // or 'editpost'
        foreach ([['usces_orderlist', 'bar'], ['foo', 'usces_orderlist']] as $val) {
            $_REQUEST['page'] = $val;
            $_REQUEST['order_action'] = 'edit';
            $res = WelcartUtils::isOrderEditPage();
            $this->assertSame(true, $res);
        }
    }

    public function testIsAdminItemEditPage(): void {
        // assert false when not on admin page
        $mock = $this->getIsAdminMock(false);
        $mock->enable();
        $res = WelcartUtils::isAdminItemPage();
        $mock->disable();
        $this->assertSame(false, $res);

        // assert false when $_REQUEST['page'] is not set
        $mock = $this->getIsAdminMock(true);
        $mock->enable();
        $res = WelcartUtils::isAdminItemPage();
        $this->assertSame(false, $res);

        // assert invalid $_REQUEST['page'] values are handled gracefully
        foreach ([true, false, null, 0, 10] as $val) {
            $_REQUEST['page'] = $val;
            $res = WelcartUtils::isAdminItemPage();
            $this->assertSame(false, $res);
        }

        // assert false when page is not 'usces_itemedit' or 'usces_itemnew'
        $_REQUEST['page'] = 'usces_orderlist';
        $res = WelcartUtils::isAdminItemPage();
        $this->assertSame(false, $res);

        // assert true when page is 'usces_itemedit' or 'usces_itemnew'
        foreach (['usces_itemedit', 'usces_itemnew'] as $p) {
            $_REQUEST['page'] = $p;
            $res = WelcartUtils::isAdminItemPage();
            $this->assertSame(true, $res);
        }

        // assert false when $_REQUEST['page'] is array of pages where none of
        // the values are 'usces_itemedit' or 'usces_itemnew'
        $_REQUEST['page'] = ['foo', 'bar'];
        $res = WelcartUtils::isAdminItemPage();
        $this->assertSame(false, $res);

        // assert true when $_REQUEST['page'] is array of pages where at
        // least one is 'usces_itemedit' or 'usces_itemnew'
        foreach ([['usces_itemedit', 'bar'], ['foo', 'usces_itemnew']] as $val) {
            $_REQUEST['page'] = $val;
            $res = WelcartUtils::isAdminItemPage();
            $this->assertSame(true, $res);
        }
    }
}
