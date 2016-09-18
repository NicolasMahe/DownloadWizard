<?php


//library
include("library/third/simple_html_dom.php");
include("library/Tracker.php");
include("library/Forum.php");
include("library/Cron.php");
include("library/Meta.php");
include("library/Downloader.php");
include("library/Table.php");

//helper
include("helper/Log.php");
include("helper/Response.php");
include("helper/Error.php");
include("helper/Config.php");
include("helper/Request.php");
include("helper/Storage.php");
include("helper/Recognize.php");

class TableTest
{
    public function testAll()
    {
        $testTable = new Table("watchlist");
        /*
        $testTable->add(array(
            "test" => "leu"
        ));
        */
        /*
        echo "\n\rupdate: ".$testTable->update(array(
            "test" => "leudzdzdzd",
            "id" => 2
        ));
        
        echo "\n\rdelete: ".$testTable->delete(3);
        */
        
        echo "\n\rget";
        $get = $testTable->get(1);
        print_r($get);
        
        echo "\n\rall";
        $all = $testTable->getAll();
        print_r($all);
    }
}

echo "<pre>";

$test = new TableTest();

$test->testAll();

print_r(ErrorPerso::getAll());

echo "</pre>";