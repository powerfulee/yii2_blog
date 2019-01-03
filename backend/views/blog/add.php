<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;

$this->registerJsFile('@web/js/ckeditor/ckeditor.js',['depends'=>['backend\assets\AppAsset'],'position'=>$this::POS_HEAD]);

$this->registerJsFile('@web/js/ckfinder/ckfinder.js',['depends'=>['backend\assets\AppAsset'],'position'=>$this::POS_HEAD]);
?>

<?= Html::beginForm(['save', 'id' => 'blogAdd-form'], 'post', ['class' => 'form-horizontal']); ?>
<div>
	<div class="form-group">
		<label for="inputEmail3" class="col-sm-2 control-label">类别</label>
		<div class="col-sm-10">
			<?= Html::dropDownList('category_id', $blog->category_id, ArrayHelper::map($categories, 'id', 'category_name'),['class'=>'form-control']) ?>
		</div>
	</div>
	<div class="form-group">
		<label for="inputEmail3" class="col-sm-2 control-label">标题</label>
		<div class="col-sm-10">
		<?= Html::input('text', 'title', $blog->title, ['class' => 'form-control']) ?>
		</div>
	</div>
	<div class="form-group">
		<label for="inputPassword3" class="col-sm-2 control-label">状态</label>
		<div class="col-sm-10">
		<?=Html::dropDownList('status',$blog->status,['0'=>'显示','1'=>'屏蔽'],['class'=>'form-control']);?>
		</div>
	</div>
	<div class="form-group">
		<label for="inputPassword3" class="col-sm-2 control-label">内容</label>
		<div class="col-sm-10">
			<?=Html::textarea('content',$blog->content,['class'=>'form-control','id'=>'content','rows'=>'5']);?>
			<script>
	        	CKEDITOR.replace( 'content', {

        filebrowserBrowseUrl        : '../../js/ckfinder/ckfinder.html',

        filebrowserImageBrowseUrl   : '../../js/ckfinder/ckfinder.html?Type=Images',

        filebrowserFlashBrowseUrl   : '../../js/ckfinder/ckfinder.html?Type=Flash',

        filebrowserUploadUrl        : '../../js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',

        filebrowserImageUploadUrl   : '../../js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',

        filebrowserFlashUploadUrl   : '../../js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'

    });
	        </script>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<?=Html::input('hidden','id',$blog->id,['class' => 'form-control']);?>
			<?= Html::submitButton('提交', ['class' => 'btn btn-success']) ?>
		</div>
	</div>
</div>
<?= Html::endForm() ?>
