<?php
App::import('Vendor', 'Pager', array('file' => DS. 'Pager' .DS. 'Pager.php'));

class YoutubeController extends AppController {
    public $name = 'Youtube';
    public $uses = '';
    public $layout = 'default';
    public $components = array('Zend');

    /**
     * YouTube 検索
     */
    public function index() {
		if (empty($this->data)) {
			if (!empty($this->passedArgs['query'])) {
				$this->data['query'] = $this->passedArgs['query'];
			}
		}
    	if (!empty($this->data)) {
			$limit = 20;							// 1ページあたりの項目数
			$limitItems = 1000;						// Youtubeの上限項目数
    		$limitIndex = $limitItems - $limit + 1;	// Youtubeの上限開始番号
			$page = 1;								// 開始ページ
			if (!empty($this->passedArgs['page'])) {
				$page = $this->passedArgs['page'];
			}
			$startIndex = ($page - 1) * $limit + 1;
			if ($startIndex > $limitIndex) {
				$startIndex = $limitIndex;
			}
			$searchTerms = $this->data['query'];

			// YouTubeクラスのロード
	        $this->Zend->loadClass('Zend_Gdata_YouTube');
	        $yt = new Zend_Gdata_YouTube();

			// 検索Query
			$query = $yt->newVideoQuery();
			$query->setRacy('include');				// 制限なし
			$query->startIndex = $startIndex;		// 開始番号
			$query->setMaxResults($limit);			// 1ページあたりの項目数
			//$query->setOrderBy('viewCount');		// 視聴回数でソート
			$query->setVideoQuery($searchTerms);	// 検索対象

			// 検索実行
			$videoFeed = $yt->getVideoFeed($query);
			// 検索結果
			$this->set('videoFeed', $videoFeed);

			// ページング
			$totalItems = intval($videoFeed->getTotalResults()->text);
			if ($limitItems < $totalItems) {
				$totalItems = $limitItems;
			}
			$url = Router::url(array('action' => 'index', 'query' => urlencode($searchTerms))) ;
			$options = array(
				'mode' => 'Sliding',
				'totalItems' => $totalItems,
				'delta' => 3,
				'perPage' => $limit,
				'currentPage' => $page,
				'path' => $url,
				'fileName' => "page:%d",
				'append' => false,
			);
			$pager =& Pager::factory($options);
			$navi = $pager -> getLinks();
			$this->set('navi', $navi);
		}
    }

    /**
     * swf sample
     * 参考: http://junichi11.com/?p=558
     */
    public function swf() {
        // YouTubeクラスのロード
        $this->Zend->loadClass('Zend_Gdata_YouTube');
        $yt = new Zend_Gdata_YouTube();
        // Queryの作成
        $query = $yt->newVideoQuery();
        $query->videoQuery = 'アイドル 水着';
        $query->startIndex = 1; // 開始番号
        $query->maxResults = 10; // 検索取得数
        $query->orderBy = 'viewCount'; // 閲覧数順

        // Feedの取得
        $videoFeed = $yt->getVideoFeed($query);
//      $videoFeed = $yt->getUserFavorites('username'); // ユーザのお気に入りの動画を取得
        // 取得したFeedをView変数に設定する
        $this->set('videoFeed', $videoFeed);
    }

}
