<?php
/**
 * Created by PhpStorm.
 * User: PeterLee
 * Date: 2018/1/21
 * Time: 22:29
 */
use common\models\Category;
use common\models\Blog;
use common\models\Reply;

$categories = Category::find()->where(['status' => 0])->orderBy('create_date desc')->all();
$newestBlogs = Blog::find()->where(['status' => 0])->orderBy('create_date desc')->limit(5)->all();
$newestReplies = Reply::find()->orderBy('create_date desc')->limit(5)->all();
$years = Yii::$app->db->createCommand('SELECT DATE_FORMAT(FROM_UNIXTIME(create_date/1000),\'%Y\') AS year,COUNT(id) AS total FROM blog GROUP BY DATE_FORMAT(FROM_UNIXTIME(create_date/1000),\'%Y\') ORDER BY create_date DESC')->queryAll();

$url='http://'.$_SERVER['HTTP_HOST'].substr($_SERVER['PHP_SELF'],0,strrpos($_SERVER['PHP_SELF'],'/')+1);
?>
<script type="text/javascript">
	function add() {
		var keyword = $("#keyword").val();

		var url = "../blog/search";

		$.ajax({
			type : "post",
			url : url,
			data : {
				keyword : keyword
			},
			async: false,
			dataType : "json",
			success : function(json) {

			},
			error : function() {
				alert("系统异常，请稍后重试！");
			}
		});
	}
</script>
<aside id="secondary" class="widget-area" role="complementary">
    <section id="search-2" class="widget widget_search">

        <form role="search" method="post" class="search-form" action="<?php echo($url)?>blog/search">
            <label for="search-form-592543cd20fe4"> <span
                    class="screen-reader-text">搜索：</span>
            </label> <input type="search" id="keyword" class="search-field"
                            placeholder="搜索…" value="" name="keyword" />
            <button type="submit" class="search-submit">
                <svg class="icon icon-search" aria-hidden="true" role="img"> <use
                        href="#icon-search" xlink:href="#icon-search"></use> </svg>
                <span class="screen-reader-text">搜索</span>
            </button>
        </form>
    </section>
    <section id="categories-2" class="widget widget_categories">
        <h2 class="widget-title">分类目录</h2>
        <ul>
            <?php foreach ($categories as $category): ?>
                <li class="cat-item cat-item-3"><a
                        href="<?php echo($url)?>category/list/<?=$category['id']?>">
                        <?=$category['category_name']?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>
    <section id="recent-posts-2" class="widget widget_recent_entries">
        <h2 class="widget-title">近期文章</h2>
        <ul>
            <?php foreach ($newestBlogs as $newestBlog): ?>
                <li>
                    <a href="<?php echo($url)?>blog/detail/<?=$newestBlog['id']?>">
                        <?=$newestBlog['title']?>
                        <?php echo(Yii::$app->formatter->asDate($newestBlog['create_date']/1000,'yyyy-MM-dd'))?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>
    <section id="recent-comments-2" class="widget widget_recent_comments">
        <h2 class="widget-title">近期评论</h2>
        <ul id="recentcomments">
            <?php foreach ($newestReplies as $newestReply): ?>
                <li>
                    <a href="<?php echo($url)?>blog/detail/<?=$newestReply['blog_id']?>">
                        <?php echo(Yii::$app->formatter->asDate($newestReply['create_date']/1000,'yyyy-MM-dd'))?>:
                        <?=$newestReply['content']?> by<?=$newestReply['author']?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>
    <section id="archives-2" class="widget widget_archive">
        <h2 class="widget-title">文章归档</h2>
        <ul>
            <?php foreach ($years as $year): ?>
                <li>
                    <a href='<?php echo($url)?>blog/list/<?=$year['year']?>'>
                        <?=$year['year']?>年 (<?=$year['total']?>篇)
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>

</aside>
