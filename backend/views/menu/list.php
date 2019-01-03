<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use backend\widgets\Alert;

AppAsset::register($this);
AppAsset::addCss($this,'@web/css/easyui.css');
AppAsset::addCss($this,'@web/css/icon.css');

$this->registerJsFile('@web/js/jquery.easyui.min.js',['depends'=>['backend\assets\AppAsset'],'position'=>$this::POS_HEAD]);
?>
<script type="text/javascript">
	function doPost(){
		var menu_name = $("#menu_name").val();
		var link_url = $("#link_url").val();
		var parent_id = $("#parent_id").combobox("getValue");
		var csrfToken = $('#_csrf').val();
		
		var url = "save";
		$.post(url, {
			_csrf : csrfToken,
			menu_name : menu_name,
			parent_id : parent_id,
			link_url : link_url
		}, function(json) {
			var status = json.status;
			window.location.reload();
		});
	}	
</script>
<div style="margin: 10px 0;">
	<?= Html::button('修改', ['class' => 'btn btn-success','onclick' =>'edit()']) ?>
	<?= Html::button('保存', ['class' => 'btn btn-success','onclick' =>'save()']) ?>
	<?= Html::button('删除', ['class' => 'btn btn-success','onclick' =>'del()']) ?>
	<?= Html::button('取消', ['class' => 'btn btn-success','onclick' =>'cancel()']) ?>
</div>
<table id="tg" class="easyui-treegrid" title="系统菜单管理"
		style="width:700px;height:600px"
		data-options="
				iconCls: 'icon-ok',
				rownumbers: true,
				animate: true,
				collapsible: true,
				fitColumns: true,
				url: 'getMenuTree',
				idField: 'id',
				treeField: 'menu_name',
				showFooter: true
			">
	<thead>
		<tr>
			<th data-options="field:'menu_name',width:320,editor:'text'">菜单</th>
			<th data-options="field:'link_url',width:320,editor:'text'">地址</th>
		</tr>
	</thead>
</table>
<?= Html::beginForm(['save', 'id' => 'ff'], 'post', ['class' => 'form-horizontal']); ?>
<div>
	<div class="form-group">
		<label for="inputEmail3" class="col-sm-2 control-label">菜单名称</label>
		<div class="col-sm-10">
			<?= Html::input('text', 'menu_name', '', ['class' => 'form-control', 'id' => 'menu_name']) ?>
		</div>
	</div>
	<div class="form-group">
		<label for="inputEmail3" class="col-sm-2 control-label">链接地址</label>
		<div class="col-sm-10">
			<?= Html::input('text', 'link_url', '', ['class' => 'form-control', 'id' => 'link_url']) ?>
		</div>
	</div>
	<div class="form-group">
		<label for="inputPassword3" class="col-sm-2 control-label">上级菜单</label>
		<div class="col-sm-10">
			<select id="parent_id" name="parent_id" class="easyui-combotree"
					style="width: 200px;"
					data-options="url:'/menu/getMenuList',required:true"></select>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<input name="_csrf" type="hidden" id="_csrf" value="<?=  Yii::$app->request->csrfToken; ?>">
			<?= Html::button('提交', ['class' => 'btn btn-success','onclick' =>'doPost()']) ?>
		</div>
	</div>
</div>
<?= Html::endForm() ?>
<script type="text/javascript">
		function formatProgress(value) {
			if (value) {
				var s = '<div style="width:100%;border:1px solid #ccc">'
						+ '<div style="width:' + value
						+ '%;background:#cc0000;color:#fff">' + value + '%'
						+ '</div>'
				'</div>';
				return s;
			} else {
				return '';
			}
		}
		var editingId;
		function edit() {
			//alert(editingId);
			if (editingId != undefined) {
				$('#tg').treegrid('select', editingId);
				return;
			}
			var row = $('#tg').treegrid('getSelected');
			if (row) {

				editingId = row.id;
				$('#tg').treegrid('beginEdit', editingId);
			}
		}
		function save() {
			if (editingId != undefined) {
				var t = $('#tg');
				t.treegrid('endEdit', editingId);
				editingId = undefined;
				var persons = 0;
				var text = t.treegrid('getSelected');

				var url = "save";
				var id = text.id;
				var menu_name = text.menu_name;
				var link_url = text.link_url;
				var parent_id = text._parentId;

				$.post(url, {
					menu_name : menu_name,
					link_url : link_url,
					id : id,
					parent_id : parent_id
				}, function(json) {
					//window.location.href = "list";
					window.location.reload();
				});
			}
		}
		function cancel() {
			if (editingId != undefined) {
				$('#tg').treegrid('cancelEdit', editingId);
				editingId = undefined;
			}
		}
		function del() {
			var t = $('#tg');
			t.treegrid('endEdit', editingId);
			var text = t.treegrid('getSelected');
			var id = text.id;
			
			var url = "delete";

			$.post(url, {
				id : id
			}, function(json) {
				//window.location.href = "list";
				window.location.reload();
			});
		}
</script>