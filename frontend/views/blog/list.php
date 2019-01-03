<?php
use yii\helpers\Html;

use yii\widgets\LinkPager;

$this->title = 'On The Road';

$url='http://'.$_SERVER['HTTP_HOST'].substr($_SERVER['PHP_SELF'],0,strrpos($_SERVER['PHP_SELF'],'/')+1);
?>
<header class="page-header">
	<h2 class="page-title">文章</h2>
</header>
<div id="primary" class="content-area">
						<main id="main" class="site-main" role="main">
						<form id="blogsForm">
							<?php foreach ($models as $model): ?>

							<article id="post-27"
								class="post-27 post type-post status-publish format-standard hentry category-learning">
								<header class="entry-header">
									<div class="entry-meta">
										<span class="screen-reader-text">发布于</span>
										<time class="entry-date published updated"
												datetime="${blog.createDate}">
												<?php echo(Yii::$app->formatter->asDate($model['create_date']/1000,'yyyy-MM-dd'))?>
										</time>
									</div>
									<!-- .entry-meta -->
									<h3 class="entry-title">
										<a href="<?php echo($url)?>blog/detail/<?php echo($model['id'])?>" rel="bookmark">
											<?php echo($model['title'])?>
										</a>
									</h3>
								</header>
								<!-- .entry-header -->

								<div class="entry-content">
									<?php echo($model['content'])?>
								</div>
								<p class="link-more">
									<a
										href="<?php echo($url)?>blog/detail/<?php echo($model['id'])?>"
										rel="bookmark">阅读全文<span class="screen-reader-text">“${blog.title}”</span></a>
								</p>
								<!-- .entry-content -->

							</article>
							<?php endforeach; ?>
						</form>
						<!-- #post-## -->

						<nav class="navigation pagination" role="navigation"
							style="border-top: 1px solid #eee;">
							<h2 class="screen-reader-text">文章导航</h2>
							<div class="nav-links">
								<?= LinkPager::widget([
								    'pagination' => $pages,
								    'options' => ['class' => 'm-pagination'],
								]); ?>
							</div>
						</nav>
						</main>
						<!-- #main -->
					</div>
					<!-- #primary -->

                    <!-- #secondary -->
					
