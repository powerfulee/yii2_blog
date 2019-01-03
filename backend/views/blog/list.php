<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
?>
<?= Html::a('新增', ['blog/add', 'id' => 'blogAdd'], ['class' => 'profile-link']) ?>
<br/><br/>
<div class="report-index">
	<table class="table  table-striped">
		<thrad>
		<tr>
			<td>类别名称</td>
			<td>标题</td>
			<td>状态</td>
			<td>提交日期</td>
			<td>操作</td>
		</tr>
		</thrad>
		<?php foreach ($models as $model): ?>
		<tr>
			<td><?php echo $model['category']['category_name']?></td>
			<td><?php echo $model['title']?></td>
			<td>
				<?php echo ($model['status'] == 0) ? '显示' : '屏蔽'?>
			</td>
			<td><?php echo(Yii::$app->formatter->asDate($model['create_date']/1000,'yyyy-MM-dd'))?></td>
			<td>
				<a href="add/<?php echo($model['id'])?>">
					<img src="../images/icon-ed.gif"></img>
				</a>
				&nbsp;
				<a href="delete/<?php echo($model['id'])?>">
					<img src="../images/icon-del.gif"></img>
				</a>
			</td>
		</tr>
		<?php endforeach; ?>
	</table>
	
	<div id="custom-pagination" class="nav-links">
		<?= \yii\widgets\LinkPager::widget([
			'pagination' => $pages
		]); ?>
	</div>
</div>