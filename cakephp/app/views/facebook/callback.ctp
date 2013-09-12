FaceBook 情報
<table>
<?php
echo $html->tableHeaders(array('項目名', '内容'));
$cells = array();
foreach ($user_profile as $k => $v) {
	if (is_array($v)) {
		$v = print_r($v, true);
		$v = "<pre>$v</pre>";
	}
	$cells[] = array($k, $v);
}

echo $html->tableCells($cells);
?>
</table>
