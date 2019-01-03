<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
?>

<?= Html::beginForm(['save', 'id' => 'userAdd-form'], 'post', ['class' => 'form-horizontal']); ?>
<div>
	<div class="form-group">
		<label for="inputEmail3" class="col-sm-2 control-label">类别名称</label>
		<div class="col-sm-10">
			<?= Html::input('text', 'category_name', $category->category_name, ['class' => 'form-control']) ?>
		</div>
	</div>
	<div class="form-group">
		<label for="inputEmail3" class="col-sm-2 control-label">状态</label>
		<div class="col-sm-10">
		<?=Html::dropDownList('status',$category->status,['0'=>'显示','1'=>'屏蔽'],['class'=>'form-control']);?>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<?=Html::input('hidden','id',$category->id,['class' => 'form-control']);?>
			<?= Html::submitButton('提交', ['class' => 'btn btn-success']) ?>
		</div>
	</div>
</div>
<?= Html::endForm() ?>
