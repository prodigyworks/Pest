<?php
	require_once("crud.php");
	
	
	class DiaryCrud extends Crud {
		
		public function postScriptEvent() {
?>
			function printDocument(node) {
				window.open("reportjob.php?id=" + node);
			}
			
			function loadComplete() {
			    var rowIds = $("#tempgrid").getDataIDs();
			    var today = new Date();
			    
			    for (i = 1; i <= rowIds.length; i++) {//iterate over each row
			        rowData = $("#tempgrid").jqGrid('getRowData', i);
	
			        if (rowData['status'] == 'Clocked In') {
			            $("#tempgrid").jqGrid('setRowData', i, false, "red-row");
			            
			        } else if (rowData['status'] == 'Clocked Out') {
			            $("#tempgrid").jqGrid('setRowData', i, false, "green-row");
			        }
			    }
			}		
<?php
		}
	}

	$crud = new DiaryCrud();
	$crud->allowAdd = false;
	$crud->allowEdit = false;
	$crud->postDataRefreshEvent = "loadComplete";
	$crud->title = "Completed Jobs";
	$crud->table = "{$_SESSION['DB_PREFIX']}diary";
	$crud->dialogwidth = 450;
	$crud->sql = 
			"SELECT A.*, B.fullname, C.name
			 FROM {$_SESSION['DB_PREFIX']}diary A 
			 INNER JOIN {$_SESSION['DB_PREFIX']}members B 
			 ON B.member_id = A.memberid 
			 LEFT OUTER	 JOIN {$_SESSION['DB_PREFIX']}client C 
			 ON C.id = A.clientid 
			 WHERE A.status = 'C'
			 ORDER BY A.starttime DESC, A.status";
	
	$crud->columns = array(
			array(
				'name'       => 'id',
				'length' 	 => 6,
				'pk'		 => true,
				'showInView' => false,
				'editable'	 => false,
				'bind' 	 	 => false,
				'filter' 	 => false,
				'label' 	 => 'ID'
			),
			array(
				'name'       => 'clientid',
				'type'       => 'DATACOMBO',
				'length' 	 => 25,
				'label' 	 => 'Client',
				'table'		 => 'client',
				'required'	 => true,
				'table_id'	 => 'id',
				'alias'		 => 'name',
				'table_name' => 'name'
			),
			array(
				'name'       => 'memberid',
				'type'       => 'DATACOMBO',
				'length' 	 => 25,
				'label' 	 => 'Operator',
				'table'		 => 'members',
				'required'	 => true,
				'table_id'	 => 'member_id',
				'alias'		 => 'fullname',
				'table_name' => 'fullname'
			),
			array(
				'name'       => 'jobdate',
				'datatype'	 => 'date',
				'length' 	 => 20,
				'label' 	 => 'Completed Date'
			)
		);

	$crud->subapplications = array(
			array(
				'title'		  => 'Print',
				'imageurl'	  => 'images/print.png',
				'script' 	  => 'printDocument'
			)
		);	
		
	$crud->run();
?>
