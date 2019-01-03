<?php
use yii\helpers\Html;
?>
<?= Html::a('新增', ['role/add', 'id' => 'roleList'], ['class' => 'profile-link']) ?>
<br/><br/>
<table class="table table-striped">
	<thrad>
	<tr>
		<td>角色名称</td>
		<td>注册日期</td>
		<td>操作</td>
	</tr>
	</thrad>
	<?php foreach ($models as $model): ?>
	<tr>
		<td><?php echo($model['name'])?></td>
		<td><?php echo(Yii::$app->formatter->asDate($model['create_dt'],'yyyy-MM-dd'))?></td>
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