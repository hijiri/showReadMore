/**
 * Loggix_Plugin - Show ReadMore Link
 *
 * @copyright Copyright (C) UP!
 * @author    hijiri
 * @link      http://tkns.homelinux.net/
 * @license   http://www.opensource.org/licenses/bsd-license.php  New BSD License
 * @since     2010.04.28
 * @version   10.6.3
 */

●"続きを読む"のリンクを表示して記事を折りたたむプラグイン

■概略
このソフトウェアは、Loggixの記事中に<!-- more -->～<!-- /more -->を記述すると、"続きを読む"のリンクを表示して記事を折りたたむプラグインです。

■詳細
Loggixで記事を投稿する際に特定のマーク(標準では<!-- more -->～<!-- /more -->)を記述すると、マークに挟まれた文章を非表示にして"続きを読む"のリンクを表示します。

"続きを読む"のリンクをクリックする事でjQuery UIの視覚効果を利用して表示/非常時のトグルを行います。JavaScriptが無効の場合はPermalinkを表示します。

■インストール/アンインストール方法
インストール
    1./plugins/へshowReadMore.phpをアップロードします。
    2./theme/js/scripts.jsへ以下のコードを追加しアップロードします。

/* --------------- Add Start --------------- */
$(function() {
    $('.read-more a[rel=Bookmark]').click(function(){
        // SETTING BEGIN
        // Effect type
        var effect     = 'blind';
        // Effect time
        var effectTime = 1000;
        // Link text
        readText  = '続きを読む';
        hideText  = '続きを隠す';
        //readText  = 'Read more';
        //hideText  = 'Return';
        // SETTING END

        targetLnk = $(this);
        id = targetLnk.attr('href').match(/\?id=([0-9]{1,})/)[1];
        targetObj = $('#targetId' + id);

        targetObj.toggle(effect, '', effectTime, function() {
            if (targetObj.is(':hidden')) {
                targetLnk.text(readText);
                targetLnk.removeClass('hidelink');
                targetLnk.addClass('showlink');
                targetLnk.attr('title', 'ID ' + id + ':' + readText);
            } else {
                targetLnk.text(hideText);
                targetLnk.removeClass('showlink');
                targetLnk.addClass('hidelink');
                targetLnk.attr('title', 'ID ' + id + ':' + hideText);
            }
        });
        return false;
    });
});
/* ---------------- Add End ---------------- */

アンインストール
    1./plugins/からshowReadMore.phpを削除します。
    2./theme/js/scripts.jsから追加したコードを削除します。

■使用方法
記事を投稿する際に折りたたみたい文章を<!-- more -->と<!-- /more -->で挟んでください。<!-- more -->～<!-- /more -->の前後のHTMLの整合性はチェックしません。結果的にHTMLタグが入れ子になった場合の動作はどうなるか分かりません。

■その他
JavaScriptで行っている"続きを読む"リンクのタイトル属性の書き換えが、qTipのツールチップ表示に反映されない既知の問題があります。

■サポート
作者多忙の為サポート出来ません。意見/感想はContactからご連絡ください。

■更新履歴
2010-06-03:正常に置換出来ない場合があるバグとJavaScriptを修正。
2010-06-02:jQuery UI Ver1.8.1に対応
2010-05-28:公開
2010-05-18:beta版公開