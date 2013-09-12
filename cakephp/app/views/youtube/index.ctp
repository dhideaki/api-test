<h1>YouTube 検索テスト</h1>
<?php e($form->create(null, aa('url', aa('action', 'index')))); ?>

<?php e($form->text('query')); ?>
<?php e($form->submit('検索', aa('div', false))); ?>
<?php
	//e($form->submit('リセット', aa('div', false, 'type', 'reset')));
	//e($form->button('リセット', aa('type', 'button')));
?>

<?php e($form->end()); ?>

<?php if (!empty($videoFeed)): ?>
<br/><br/>

<?php echo $navi['all']; ?>
<hr/>

<?php
// 検索結果の全件数
$get_Totalcount = $videoFeed->getTotalResults()->text;
// 検索結果の1ページ当たりの件数
$get_Itemcount = $videoFeed->getItemsPerPage()->text;

echo "$get_Totalcount 件";
$cells = array();
foreach ($videoFeed as $videoEntry) {
	// 対象の動画のタイトル
	$videoEntry->getVideoTitle();

	// 対象の動画の大画面リンク
	$videoEntry->getFlashPlayerUrl();

	// 対象の動画のサムネイル画像があります。
	$arrVideoThumbnails = $videoEntry->getVideoThumbnails();
	foreach ( $arrVideoThumbnails as $thumbnailValue ) {
		$thumbnail_img = $thumbnailValue['url'];
		break;
	}

	$arr = array();
	$arr[] =  $this->Html->image($thumbnail_img, array(
//		'height' => 90,
		'width' => 185,
		'id' => $videoEntry->getVideoId(),
		'class' => 'youtube',
		'title' => $videoEntry->getVideoTitle(),
		'alt' => $videoEntry->getVideoTitle(),
		'url' => $videoEntry->getFlashPlayerUrl(),
	));

	$link = $html->link($videoEntry->getVideoTitle(), $videoEntry->getVideoWatchPageUrl(), array('target'=>'_blank'));
	$v = $html->div(null, $link);
	$v .= $html->div(null, $videoEntry->getVideoDescription());
	$arr[] = $v;

	$cells[] = $arr;
}
?>

<table>
<?php echo $html->tableCells($cells); ?>
</table>

<?php endif; ?>
