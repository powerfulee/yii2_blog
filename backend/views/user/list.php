<?php
use yii\helpers\Html;
?>
<?= Html::a('新增', ['user/add', 'id' => 'userList'], ['class' => 'profile-link']) ?>
<br/><br/>
<table class="table  table-striped">
	<thrad>
	<tr>
		<td>用户名</td>
		<td>角色</td>
		<td>邮箱</td>
		<td>注册日期</td>
		<td>操作</td>
	</tr>
	</thrad>
	<?php foreach ($models as $model): ?>
	<tr>
		<td><?php echo($model['username'])?></td>
		<td><?php echo($model['roles']['name'])?></td>
		<td><?php echo($model['email'])?></td>
		<td><?php echo(Yii::$app->formatter->asDate($model['created_at'],'yyyy-MM-dd'))?></td>
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