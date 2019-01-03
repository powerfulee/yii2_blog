<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
?>

<?= Html::beginForm(['save', 'id' => 'userAdd-form'], 'post', ['class' => 'form-horizontal']); ?>
<div>
	<div class="form-group">
		<label for="inputEmail3" class="col-sm-2 control-label">角色</label>
		<div class="col-sm-10">
			<?= Html::dropDownList('role', $user->role_id, ArrayHelper::map($roles, 'id', 'name'),['class'=>'form-control']) ?>
		</div>
	</div>
	<div class="form-group">
		<label for="inputEmail3" class="col-sm-2 control-label">帐号</label>
		<div class="col-sm-10">
		<?= Html::input('text', 'username', $user->username, ['class' => 'form-control']) ?>
		</div>
	</div>
	<div class="form-group">
		<label for="inputPassword3" class="col-sm-2 control-label">密码</label>
		<div class="col-sm-10">
		<?= Html::input('text', 'password', $user->password_hash, ['class' => 'form-control']) ?>
		</div>
	</div>
	<div class="form-group">
		<label for="inputPassword3" class="col-sm-2 control-label">邮箱</label>
		<div class="col-sm-10">
		<?= Html::input('email', 'email', $user->email, ['class' => 'form-control']) ?>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<?=Html::input('hidden','id',$user->id,['class' => 'form-control']);?>
			<?= Html::submitButton('提交', ['class' => 'btn btn-success']) ?>
		</div>
	</div>
</div>
<?= Html::endForm() ?>
