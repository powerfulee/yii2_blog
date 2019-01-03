<?php

use yii\helpers\Html;

use yii\widgets\LinkPager;

$this->title = 'On The Road';
?>
<script type="text/javascript">
    function add() {
        var blog_id = $("#blog_id").val();
        var author = $("#author").val();
        var content = $("#replyContent").val();

        var url = "/reply/insert";

        $.ajax({
            type : "post",
            url : url,
            data : {
                blog_id : blog_id,
                author : author,
                content : content
            },
	        async: false,
            dataType : "json",
            success : function(json) {
                if (json.status == 0){
	                alert("己成功评论！");
	                window.location.href = "/blog/detail/" + blog_id;
                }
            },
            error : function() {
                alert("系统异常，请稍后重试！");
            }
        });
    }
</script>
<div id="content" class="site-content">

    <div class="wrap">
        <div id="primary" class="content-area">
            <main id="main" class="site-main" role="main">


                <article id="post-25"
                         class="post-25 post type-post status-publish format-standard hentry category-feeling">
                    <header class="entry-header">
                        <div class="entry-meta">
						<span class="posted-on"><span class="screen-reader-text">发布于</span>
							<time class="entry-date published updated"
                                  datetime="2017-05-24T16:19:17+08:00">
								<?php echo(Yii::$app->formatter->asDate($blog['create_date'] / 1000, 'yyyy-MM-dd')) ?>
							</time></span><span class="byline"> 由<span class="author vcard">peterlee</span></span>
                        </div>
                        <!-- .entry-meta -->
                        <h1 class="entry-title">
                            <?= $blog['title'] ?>
                        </h1>
                    </header>
                    <!-- .entry-header -->


                    <div class="entry-content">
                        <?= $blog['content'] ?>
                        <p>&nbsp;</p>
                    </div>
                    <!-- .entry-content -->

                    <footer class="entry-footer">
					<span class="cat-tags-links"><span class="cat-links"><svg
                                    class="icon icon-folder-open" aria-hidden="true" role="img"> <use
                                        href="#icon-folder-open" xlink:href="#icon-folder-open"></use> </svg><span
                                    class="screen-reader-text">分类</span><a
                                    href="../../category/list/<?= $blog['category_id'] ?>"
                                    rel="category tag"> <?= $blog['category_name'] ?>
						</a></span></span>
                    </footer>
                    <!-- .entry-footer -->
                </article>
                <!-- #post-## -->

                <div id="comments" class="comments-area">
                    <?php if (count($replies) > 0): ?>
                        <h2 class="comments-title">
                            &ldquo;
                            <?= $blog['title'] ?>
                            &rdquo;的
                            <?= count($replies) ?>
                            个回复
                        </h2>
                    <?php endif; ?>
                    <ol class="comment-list">
                        <?php foreach ($replies as $reply): ?>
                            <li id="comment-2" class="comment even thread-even depth-1 parent">
                                <article id="div-comment-2" class="comment-body">
                                    <footer class="comment-meta">
                                        <div class="comment-author vcard">
                                            <img alt=''
                                                 src='http://0.gravatar.com/avatar/c5c025f9486c9227b9db14ac874a02b9?s=100&#038;d=mm&#038;r=g'
                                                 srcset='http://0.gravatar.com/avatar/c5c025f9486c9227b9db14ac874a02b9?s=200&amp;d=mm&amp;r=g 2x'
                                                 class='avatar avatar-100 photo' height='100' width='100'/> <b
                                                    class="fn"> <?= $reply['content'] ?>
                                            </b> <span class="says">说道：</span>
                                        </div>
                                        <!-- .comment-author -->

                                        <div class="comment-metadata">
                                            <a
                                                    href="http://192.168.2.29/wordpress/2017/05/24/%e7%88%b1%e4%b8%8aruby/#comment-2">
                                                <time datetime="2017-06-12T17:29:09+00:00">
                                                    <?php echo(Yii::$app->formatter->asDate($reply['create_date'] / 1000, 'yyyy-MM-dd')) ?>
                                                </time>
                                            </a>
                                        </div>
                                        <!-- .comment-metadata -->

                                    </footer>
                                    <!-- .comment-meta -->

                                    <div class="comment-content">
                                        <p>
                                            <?= $reply['author'] ?>
                                        </p>
                                    </div>
                                    <!-- .comment-content -->
                                </article>
                            </li>
                        <?php endforeach; ?>
                    </ol>

                    <div id="respond" class="comment-respond">
                        <h3 id="reply-title" class="comment-reply-title">
                            发表评论
                            <small><a rel="nofollow"
                                      id="cancel-comment-reply-link"
                                      href="/wordpress/2017/05/24/10000%e5%b0%8f%e6%97%b6/#respond"
                                      style="display: none;">取消回复</a></small>
                        </h3>
                        <!-- <p class="comment-notes">
                                        <span id="email-notes">电子邮件地址不会被公开。</span> 必填项已用<span
                                            class="required">*</span>标注
                                    </p> -->
                        <p class="comment-form-comment">
                            <label for="comment">评论</label>
                            <textarea id="replyContent" name="replyContent" cols="45" rows="8"
                                      maxlength="65525" aria-required="true" required="required"></textarea>
                        </p>
                        <p class="comment-form-author">
                            <label for="author">姓名 <span class="required">*</span></label> <input
                                    id="author" name="author" type="text" value="" size="30"
                                    maxlength="245" aria-required='true' required='required'/>
                        </p>
                        <p class="form-submit">
                            <input type='hidden'
                                   name='blog_id' id='blog_id' value='<?= $blog['id'] ?>'/>
                            <input name="submit" type="button" id="submit" class="submit"
                                   value="发表评论" onclick="add()"/>
                        </p>
                    </div>
                    <!-- #respond -->

                </div>
                <!-- #comments -->

                <nav class="navigation post-navigation" role="navigation">
                    <h2 class="screen-reader-text">文章导航</h2>
                    <div class="nav-links">
                        <#if (nextBlog?exists)>
                            <div class="nav-previous">
                                <a href="${contextPath}/blog/detail/${nextBlog.id}" rel="prev"><span
                                            class="screen-reader-text">上一篇文章</span><span aria-hidden="true"
                                                                                         class="nav-subtitle">上一篇</span>
                                    <span class="nav-title"><span
                                                class="nav-title-icon-wrapper"><svg
                                                    class="icon icon-arrow-left" aria-hidden="true" role="img"> <use
                                                        href="#icon-arrow-left"
                                                        xlink:href="#icon-arrow-left"></use> </svg></span>${nextBlog.title}</span></a>
                            </div>
                        </#if>
                        <#if (preBlog?exists)>
                            <div class="nav-next">
                                <a href="${contextPath}/blog/detail/${preBlog.id}" rel="next"><span
                                            class="screen-reader-text">下一篇文章</span> <span aria-hidden="true"
                                                                                          class="nav-subtitle">下一篇</span>
                                    <span class="nav-title">
								${preBlog.title} <span class="nav-title-icon-wrapper"> <svg
                                                    class="icon icon-arrow-right" aria-hidden="true" role="img">
													<use href="#icon-arrow-right"
                                                         xlink:href="#icon-arrow-right">
													</use> 
												</svg>
							</span>
						</span> </a>
                            </div>
                        </#if>
                    </div>
                </nav>
            </main>
            <!-- #main -->
        </div>
        <!-- #primary -->