<?php
error_reporting(E_ALL);
if (explode('.', $_SERVER['HTTP_HOST'])[0] == "testnet") {
	require_once __DIR__ . '/../../tools/tinclude.php';
} else {
	require_once __DIR__ . '/../../tools/include.php';
}
$query="SELECT time, AVG(difficulty) as difficulty
FROM blocks
WHERE id > 1 AND flags LIKE '%proof-of-work%'
GROUP BY CEIL((time)/3600)
ORDER BY time";
$result = $dbconn->query($query);
echo mysqli_real_escape_string($dbconn, $_GET["callback"]);
echo "(";
$days_array = array();
while($row = $result->fetch_assoc())
{
	$time_epoch =($row['time'] * 1000);
	$day_array = array($time_epoch, round($row['difficulty'],8));
	array_push($days_array, $day_array);
}
print json_encode($days_array, JSON_NUMERIC_CHECK);
echo ");";
?>
