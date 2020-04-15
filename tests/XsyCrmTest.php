<?php


namespace Tests;


use XsyCrm\Config\Config;
use XsyCrm\XsyCrm;

class XsyCrmTest extends TestCase {


	public function testLoadConfig() {
		$config = Config::load( __DIR__ . "/../xsy-crm.conf" );
		$this->assertTrue( is_array( $config ) );
	}

	public static function getConfig() {
		$config = Config::load( __DIR__ . "/../xsy-crm.conf" );

		return $config;
	}

	public function testGetToken() {
		XsyCrm::setConfig( self::getConfig() );
		$token = XsyCrm::token();
		$this->assertContains( 'Bearer', $token );
	}

	//创建自定义对象
	public function testDiyObject() {
		$url  = 'xobjects/customEntity1__c';
		$body = '{
				    "data": {
				        "entityType": 1174367973507806,
				        "userId": 1,
				        "customItem2_c":"test",
				        "customItem6__c": "test 文本"
				    }
				}';
		XsyCrm::setConfig( self::getConfig() );
		$res = XsyCrm::apiCall( $url, 'POST', $body, [], [] );
		var_dump( $res );
	}

	//销售机会
	public function testOpportunity() {
		$url  = 'objects/opportunity/create';
		$body = '{	
					"record":{
						"opportunityName":"test",
						"accountId":"1182417849795291",
						"money":%d,
						"saleStageId":1149802098262737,
						"closeDate": "2018-01-01"
					},
				    "products":{}
				}';
		$body = sprintf( $body, rand( 1, 1000 ) );
		XsyCrm::setConfig( self::getConfig() );
		$res = XsyCrm::apiCall( $url, 'POST', $body, [], [], 1 );
		var_dump( $res );
	}

	public function testOpportunity100() {
		for ( $i = 0; $i < 100; $i ++ ) {
//			$this->testOpportunity();
		}
	}

	//客户
	public function testAccountCreate() {
		$url  = 'objects/account/create';
		$body = '{
				    "public": true,
				    "record": {
				        "accountName": "客户测试%d",
				        "entityType": 1149800495940306
				    }
				}';
		$body = sprintf( $body, rand( 1, 1000 ) );
		XsyCrm::setConfig( self::getConfig() );
		$res = XsyCrm::apiCall( $url, 'POST', $body, [], [], 1 );
		var_dump( $res );
	}


	public function testAccountCreate100() {
		for ( $i = 0; $i < 100; $i ++ ) {
			$this->testAccountCreate();
		}
	}


}