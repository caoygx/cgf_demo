<?php

namespace Think;

interface Pay
{
	function createPayOrder();
	function queryOrder();
	function callback();
	function notify();

}
