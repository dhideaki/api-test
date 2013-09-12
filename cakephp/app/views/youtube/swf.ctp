<?php
echo $this->Html->script('swfobject', array('inline' => false));
echo $this->Html->script('jquery-1.10.2.min', array('inline' => false));
?>

<!-- TEST作成のため、CSSは直接書いている-->
<h1>YouTube test</h1>
<div id="yt" style="width: 800px;margin: auto;">
    <div style="float: left;">
        <div id="ytapiplayer">
        You need Flash player 8+ and JavaScript enabled to view this video.
        </div>
    </div>
    <div style="margin-left: 5px; float: left;width:260px; height:375px; overflow: scroll;">
        <?php
        foreach ($videoFeed as $videoEntry) {
            // サムネイルの取得
            $videoThumbnails = $videoEntry->getVideoThumbnails();
            // サムネイルは4つ取得できる（ここでは１つだけ表示した）
            foreach ($videoThumbnails as $thumbnail) {
                echo $this->Html->image($thumbnail['url'], array('height' => 90, 'width' => 120, 'id' => $videoEntry->getVideoId(), 'class' => 'youtube', 'title' => $videoEntry->getVideoTitle(), 'alt' => $videoEntry->getVideoTitle()));
                break;
            }
        }
        ?>
    </div>
</div>
<script type="text/javascript">
    var ytplayer = null;
    // playerの準備が完了後に呼び出されるコールバック
    // playerを制御するには必ず実装が必要
    function onYouTubePlayerReady(playerid){
        // プレイヤーを取得（swfobjectで指定したidを指定する）
        ytplayer = document.getElementById("myytplayer");
//      ytplayer.cueVideoById();
    }

    var params = { allowScriptAccess: "always" };
    var atts = { id: "myytplayer" };
    swfobject.embedSWF("http://www.youtube.com/v/u1zgFlCw8Aw?enablejsapi=1&playerapiid=ytplayer",
    "ytapiplayer", "500", "375", "8", null, null, params, atts);
    $(function(){
        $("img.youtube").click(function(){
            ytplayer.loadVideoById($(this).attr("id"));
        });
        $("img.youtube").hover(function(){
            $(this).css("cursor", "pointer")
                .fadeTo("fast", 0.5);
        },function(){
            $(this).fadeTo("fast", 1);
        })
    });

</script>
