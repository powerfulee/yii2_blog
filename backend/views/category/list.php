<?php
use yii\helpers\Html;
?>
<?= Html::a('新增', ['category/add', 'id' => 'categoryList'], ['class' => 'profile-link']) ?>
<br/><br/>
<table class="table  table-striped">
	<thrad>
	<tr>
		<td>类别名称</td>
		<td>状态</td>
		<td>提交日期</td>
		<td>操作</td>
	</tr>
	</thrad>
	<?php foreach ($models as $model): ?>
	<tr>
		<td><?php echo $model['category_name']?></td>
		<td>
			<?php echo ($model['status'] == 0) ? '显示' : '屏蔽'?>
		</td>
		<td><?php echo(Yii::$app->formatter->asDate($model['create_date'],'yyyy-MM-dd'))?></td>
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