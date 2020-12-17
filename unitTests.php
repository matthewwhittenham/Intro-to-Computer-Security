<?php
    include 'htmLawed.php';
    class unitTests extends \PHPUnit_Framework_TestCase
    {
        // Checks that the password_hash and password_verify correctly hash, and verify plaintext values correctly. 
        public function testPasswordHash()
        {
            $encryptedValue = password_hash("test", PASSWORD_BCRYPT, array("cost" => 10));
            $this->assertFalse("test" == $encryptedValue);
            $this->assertTrue(password_verify("test", $encryptedValue));
        }

        //Checks that the htmLawed module correctly removes any HTML scripts or executable content. 
        public function htmLawedTest()
        {
            $this->assertEquals("test", htmLawed("test"), array('safe'=>1, 'deny_attribute'=>'style'));
            $this->assertEquals("", htmLawed("<script></script>"), array('safe'=>1, 'deny_attribute'=>'style'));
            $this->assertEquals("test", htmLawed("test<iframe>hello</iframe>"), array('safe'=>1, 'deny_attribute'=>'style'));
        }
    }

?>