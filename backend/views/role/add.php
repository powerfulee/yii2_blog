<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

use backend\assets\AppAsset;
use backend\widgets\Alert;

AppAsset::register($this);
AppAsset::addCss($this,'@web/css/easyui.css');
AppAsset::addCss($this,'@web/css/icon.css');

$this->registerJsFile('@web/js/jquery.easyui.min.js',['depends'=>['backend\assets\AppAsset'],'position'=>$this::POS_HEAD]);
?>
<script type="text/javascript">
	function add(){
		var role_id = $("#role_id").val();
		var role_name = $("#name").val();
		var role_right = $("#role_right").combotree("getValues");
		var csrfToken = $('#_csrf').val();
		
		url = "/advanced/backend/web/role/save";
				
		$.post(url, {
			_csrf : csrfToken,
			role_id : role_id,
			role_name : role_name,
			role_right : role_right
		}, function(json) {
			alert(json);
		});
	}
</script>
<?= Html::beginForm(['save', 'id' => 'roleAdd-form'], 'post', ['class' => 'form-horizontal']); ?>
<div>
	<div class="form-group">
		<label for="inputEmail3" class="col-sm-2 control-label">角色名称</label>
		<div class="col-sm-10">
		<?= Html::input('text', 'name', $role->name, ['class' => 'form-control','id' => 'name']) ?>
		</div>
	</div>
	<div class="form-group">
		<label for="inputEmail3" class="col-sm-2 control-label">角色权限</label>
		<div class="col-sm-10">
			<select id="role_right" class="easyui-combotree"
				style="width: 200px;"
				data-options="url:'/role/getMenuTree/<?php echo($role->id)?>',required:true"
				multiple="true">
			</select>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<input name="_csrf" type="hidden" id="_csrf" value="<?=  Yii::$app->request->csrfToken; ?>">
			<?=Html::input('hidden','role_id',$role->id,['class' => 'form-control','id' => 'role_id']);?>
			<?= Html::button('提交', ['class' => 'btn btn-success','onclick' =>'add()']) ?>
		</div>
	</div>
</div>
<?= Html::endForm() ?>
